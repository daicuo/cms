<?php
namespace app\cms\event;

use app\common\controller\Addon;

class Collect extends Addon
{
    public function _initialize()
    {
        parent::_initialize();
    }
    
    //定义表单字段列表
    protected function fields($data=[])
    {
        return model('cms/Collect','loglic')->Fields($data);
    }
    
    //定义表单初始数据
    protected function formData()
    {
        if( $id = input('id/d',0) ){
            return model('cms/Collect','loglic')->get(['id'=>$id]);
		}
        return [];
    }
    
    //首页
    public function index()
    {
        $args = array();
        $args['cache']    = false;
        $args['limit']    = 0;
        $args['page']     = 0;
        $args['sort']     = 'op_id';
        $args['order']    = 'desc';
        $this->assign('item', model('cms/Collect','loglic')->select($args));
        return $this->fetch('cms@collect/index');
    }
    
    //绑定分类
    public function bind()
    {
        $data = $this->formData();
        //资源站分类列表
        $dataApi = model('cms/Collect','loglic')->apiCategory($data['collect_url'],$data['collect_token']);
        if(!$dataApi){
            $this->error( model('cms/Collect','loglic')->getError() );
        }
        $apiCategory = [];
        foreach($dataApi as $key=>$value){
            $apiCategory[$value['term_name']]='';
        }
        //合并已经绑定了的分类
        if($data['collect_category']){
            $data['collect_category'] = array_merge($apiCategory, $data['collect_category']);
        }else{
            $data['collect_category'] = $apiCategory;
        }
        //定义绑定换行格式
        $data['collect_categoryBind'] = model('cms/Collect','loglic')->categoryGet($data['collect_category']);
        //加载模板
        $this->assign('data', $data);
        $this->assign('fields', $this->formFields('edit', $this->fields($data)));
        return $this->fetch('cms@collect/edit');
    }
    
    public function save()
    {
        if( !model('cms/Collect','loglic')->write(input('post.')) ){
            $this->error( model('cms/Collect','loglic')->getError() );
        }

        $this->success(lang('success'));
    }
    
    public function delete()
    {
        model('common/Config','loglic')->deleteIds(input('id/a'));
        
        $this->success(lang('success'));
    }
    
    public function update()
    {
        if( !model('cms/Collect','loglic')->write(input('post.')) ){
            $this->error( model('cms/Collect','loglic')->getError() );
        }
        $this->success(lang('success'));
    }
    
    public function loading()
    {
        return "<script>alert($('#collect-loading',parent.document).html());</script>";
        $this->query['action'] = 'write';
        $this->jump(DcUrlAddon($this->query));
    }
    
    public function write()
    {
        //当前采集规则
        $data = model('cms/Collect','loglic')->get(['cache'=>true,'id'=>$this->query['id']]);
        if(!$data['collect_url']){
            return json(['code'=>0,'msg'=>lang('empty')]);
        }
        //分页入口（支持断点续采）
        if($this->query['time']){
            $this->query['pageNumber'] = DcEmpty($this->query['pageNumber'],1);
        }else{
            $this->query['pageNumber'] = $this->cachePage($data['collect_id'],$this->query['pageNumber']);
        }
        //采集内容列表数据
        $args = [];
        $args['time']       = $this->query['time'];
        $args['termId']     = $this->query['termId'];
        $args['pageNumber'] = $this->query['pageNumber'];
        $args['sortOrder']  = $this->query['sortOrder'];
        $json = model('cms/Collect','loglic')->apiDetail($data['collect_url'], $data['collect_token'], DcArrayEmpty($this->query) );
        if(!$json){
            return json(['code'=>0,'msg'=>model('cms/Collect','loglic')->getError()]);
        }
        $msg = '共需要采集'.$json['total'].'个数据，每页采集'.$json['per_page'].'个，已采集'.($json['current_page']*$json['per_page']).'个';
        //采集入库
        $result = [];
        $result['list'] = [];
        foreach($json['list'] as $key=>$value){
            //先验证来源是否已采集
            if( !model('cms/Collect','loglic')->apiReferer($value['cms_referer']) ){
                $result['list'][$key] = $value['info_name'].'已经采集（不作处理）';
                continue;
            }
            //单个按ID采集
            $post = model('cms/Collect','loglic')->apiIndex($data['collect_url'], $data['collect_token'], $value['info_id']);
            if(!$post){
                $result['list'][$key] = model('cms/Collect','loglic')->getError().'';
                continue;
            }
            //采集入库
            $infoId = model('cms/Collect','loglic')->apiSave($post,$data['collect_category']);
            $result['list'][$key] = $value['info_name'].'采集完成（'.$infoId.'）';
        }
        //分页采集
        if($this->query['pageNumber'] < $json['last_page']){
            //记录断点
            if(!$this->query['time']){
                DcCache('cmsGoOn'.$data['collect_id'], $this->query['pageNumber'], 0);
            }
            //下一页地址
            $this->query['pageNumber'] = $this->query['pageNumber']+1;
            $result['nextPage']        = DcUrlAddon($this->query);
        }else{
            //清除断点
            DcCache('cmsGoOn'.$data['collect_id'], NULL);
            //采集完成
            $result['nextPage']        = '';
        }
        return json(['code'=>1,'msg'=>$msg,'data'=>$result]);
    }
    
    //获取当前采集页码
    private function cachePage($collectId=0, $currentPage=1)
    {
        if($currentPage < 2){
            return DcEmpty(DcCache('cmsGoOn'.$collectId), 1);
        }
        return $currentPage;
    }
}