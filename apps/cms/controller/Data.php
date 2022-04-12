<?php
namespace app\cms\controller;

use app\common\controller\Api;

class Data extends Api
{
    protected $auth = [
         'check'       => true,
         'none_login'  => ['cms/data/login'],
         'none_right'  => ['cms/data/category','cms/data/detail'],
         'error_login' => 'cms/index/index',
         'error_right' => 'cms/index/index',
    ];
    
    public function _initialize()
    {
		parent::_initialize();
    }
    
    //login
    public function login()
    {
        $this->error(lang('empty'));
    }
    
    //分类列表接口
    public function category()
    {
        $item = cmsCategorySelect([
            'cache'    => true,
            'status'   => 'normal',
            'result'   => 'array',
            'limit'    => 0,
            'page'     => 0,
            'sort'     => 'term_id',
            'order'    => 'asc',
            'with'     => '',
            'field'    => 'term_id,term_name,term_slug',
        ]);
        foreach($item as $key=>$value){
            unset($item[$key]['term_status_text']);
        }
        $this->success(lang('success'),$item);
    }
    
    //内容列表接口
    //detail?termId=1&pageNumber=1
    public function detail()
    {
        //初始参数
        $args = [
            'cache'      => true,
            'status'     => 'normal',
            'sort'       => 'info_update_time',
            'order'      => cmsSortOrder(input('request.sortOrder/s','asc')),
            'limit'      => 10,
            'page'       => input('request.pageNumber/d',1),
            'with'       => 'info_meta,term,term_map',
            'field'      => 'info_id,info_name,info_slug,info_excerpt,info_update_time,info_type,info_views,info_hits',
            'with'       => '',//term,info_meta
        ];
        //分类筛选参数
        if($this->query['termId']){
            $args['term_id'] = intval($this->query['termId']);
            $args['field']   = 'info.info_id,info_name,info_slug,info_excerpt,info_update_time,info_type,info_views,info_hits';
        }
        //时间限制参数
        if($this->query['time']){
            $args['where']['info_update_time'] = ['> time',$this->query['time']];
        }
        //数据查询
        if(!$item = cmsSelect($args)){
            $this->error(lang('empty'));
        }
        //重新组合数据
        $json = [];
        $json['total']        = $item['total'];
        $json['per_page']     = $item['per_page'];
        $json['current_page'] = $item['current_page'];
        $json['last_page']    = $item['last_page'];
        $json['list']         = [];
        //拼装数据
        foreach($item['data'] as $key=>$value){
            unset($value['info_status_text']);
            $json['list'][$key] = $value;
            $json['list'][$key]['cms_referer'] = md5($this->site['domain'].'/cms/'.$value['info_id']);
        }
        unset($item);
        //返回数据
        $this->success(lang('success'),$json);
    }
    
    //单个内容详情接口
    //index?id=1
    public function index()
    {
        $id = input('request.id/f',1);
        $data = cmsGet([
            'cache'      => true,
            'status'     => 'normal',
            'module'     => 'cms',
            'id'         => ['in',$id],
            'sort'       => 'info_id',
            'order'      => 'asc',
            'with'       => 'info_meta,term',
            'field'      => 'info_id,info_name,info_slug,info_module,info_controll,info_action,info_excerpt,info_content,info_create_time,info_update_time,info_order,info_type,info_views,info_hits',
        ]);
        if(!$data){
            $this->error(lang('empty'));
        }
        $this->success(lang('success'),$this->detailValue($data));
    }
    
    //内容详情格式化
    private function detailValue($value=[])
    {
        unset($value['category']);
        unset($value['category_slug']);
        unset($value['tag']);
        unset($value['tag_slug']);
        unset($value['cms_attr']);
        unset($value['info_status_text']);
        //详情
        if($value['info_content']){
            $value['info_content']   = cmsEditor($value['info_content']);
        }
        //图标
        if($value['cms_cover']){
            $value['cms_cover']   = cmsUrlImage($value['cms_cover']);
        }
        //头条
        if($value['cms_slide']){
            $value['cms_slide']   = cmsUrlImage($value['cms_slide']);
        }else{
            $value['cms_slide']   = '';
        }
        //来源
        $value['cms_referer']     = md5($this->site['domain'].'/cms/'.$value['info_id']);
        //返回
        return $value;
    }
}