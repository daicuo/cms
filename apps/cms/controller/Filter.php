<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Filter extends Front
{
    //继承上级
    public function _initialize()
    {
        //请求验证
        if( !cmsRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('cms_error_rest'), 'cms/index/index');
        }
        //请求过滤
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        //继承上级
        parent::_initialize();
    }
    
    //按条件筛选页
    public function index()
    {
        //过滤空值
        $this->query        = DcArrayEmpty($this->query);
        //扩展字段列表
        $fieldsMeta         = DcArrayFilter($this->query, cmsMetaFields());
        //固定参数
        $info = [];
        $info['pageSize']   = cmsPageSize($this->query['pageSize']);
        $info['pageNumber'] = $this->site['page'];
        $info['sortName']   = $this->sortName($this->query['sortName'], 'info_update_time');
        $info['sortOrder']  = $this->sortOrder($this->query['sortOrder'], 'desc');
        $info['info_type']  = $this->cmsType($this->query['info_type']);
        $info['term_id']    = $this->query['term_id'];
        //定义筛选变量
        $info['pageFilter'] = DcArrayEmpty(DcArrayArgs($fieldsMeta,$info));
        //定义分页PATH变量
        $info['pagePath']   = cmsUrlFilter(array_merge($info['pageFilter'],['pageNumber'=>'[PAGE]']));
        //定义重置条件变量
        $info['pageReset']  = cmsUrlFilter([
            'pageSize'   => 10,
            'pageNumber' => 1,
            'sortName'   => 'info_id',
            'sortOrder'  => 'desc'
        ]);
        //拼装数据查询条件
        $args = [];
        $args['cache']      = true;
        $args['status']     = 'normal';
        $args['limit']      = $info['pageSize'];
        $args['page']       = $info['pageNumber'];
        $args['sort']       = $info['sortName'];
        $args['order']      = $info['sortOrder'];
        //按META字段条件筛选
        $args['meta_query'] = cmsMetaQuery($this->query);
        //按META字段排序
        if( !in_array($args['sort'],['info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
            $args['meta_key'] = $args['sort'];
            $args['sort']     = 'meta_value_num';
        }
        //文章内型限制
        if($info['info_type']){
            $args['type'] = ['eq',$info['info_type']];
        }
        //分类ID限制
        if($info['term_id']){
            $args['term_id'] = ['eq',intval($info['term_id'])];
        }
        //数据查询
        $info['list']  = cmsSelect($args);
        //URL参数
        $info['query'] = $this->query;
        //筛选列表
        $info['types'] = cmsTypeOption();
        //页码列表
        $info['pageSizes'] = [
            '10'  => 10,
            '20'  => 20,
            '30'  => 30,
            '50'  => 50,
            '100' => 100,
        ];
        //排序字段列表
        $info['sortNames'] = [
            'info_id'          => 'ID',
            'info_views'       => lang('info_views'),
            'info_update_time' => lang('info_update_time'),
            'info_order'       => lang('info_order'),
            'cms_up'           => lang('cms_up'),
        ];
        //排序方式列表
        $info['sortOrders'] = [
            'desc' => lang('cms_order_desc'),
            'asc'  => lang('cms_order_asc'),
        ];
        //分类列表
        $terms = cmsCategorySelect([
            'cache'    => true,
            'status'   => 'normal',
            'result'   => 'array',
            'field'    => 'term_id,term_slug,term_name',
            'with'     => '',
            'limit'    => 0,
            'page'     => 0,
            'sort'     => 'term_count desc,term_id',
            'order'    => 'desc',
        ]);
        foreach($terms as $key=>$value){
            $info['termIds'][$value['term_id']] = $value['term_name'];
            $info['termSlugs'][$value['term_slug']] = $value['term_name'];
        }
        //变量赋值
        $this->assign($info);
        $this->assign($term);
        //加载模板
        return $this->fetch();
    }
    
    //文章形式
    private function cmsType($infoType='')
    {
        if( in_array($infoType,array_keys(cmsTypeOption())) ){
            return $infoType;
        }
        return '';
    }
    
    //排序字段
    private function sortName($sortName='',$sortDefault='info_update_time')
    {
        if( in_array($sortName,['cms_up','cms_down','info_id','info_order','info_views','info_hits','info_create_time','info_update_time']) ){
            return $sortName;
        }
        return $sortDefault;
    }
    
    //排序方式
    private function sortOrder($sortOrder='',$sortDefault='desc')
    {
        if( in_array($sortOrder,['desc','asc']) ){
            return $sortOrder;
        }
        return $sortDefault;
    }

}