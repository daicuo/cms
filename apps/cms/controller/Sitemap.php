<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Sitemap extends Front
{

    public function _initialize()
    {
        //请求验证
        if( !cmsRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('cms_error_rest'), 'cms/index/index');
        }
        parent::_initialize();
    }
    
    public function index()
    {
        //数据查询参数
        $args = [];
        $args['cache']    = true;
        $args['status']   = 'normal';
        $args['field']    = 'info_id,info_slug,info_name,info_status,info_update_time';
        $args['with']     = 'term';
        $args['limit']    = cmsPageSize(config('cms.limit_sitemap'));
        $args['page']     = DcEmpty($this->query['pageNumber'], $this->site['page']);
        $args['sort']     = DcEmpty($this->query['sortName'], 'info_update_time');
        $args['order']    = DcEmpty($this->query['sortOrder'], 'desc');
        //数据查询
        $list = cmsSelect($args);
        //拼装结果
        $result = [];
        foreach($list['data'] as $key=>$value){
            array_push($result,$this->site['domain'].cmsUrlDetail([
                'info_id'       => $value['info_id'],
                'info_slug'     => $value['info_slug'],
                'info_name'     => $value['info_name'],
                'category_id'   => $value['category_id'],
                'category_slug' => $value['category_slug'],
                'category_name' => $value['category_name'],
            ]));
        }
        unset($list);
        return implode("\n",$result);
    }
    
}