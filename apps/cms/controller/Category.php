<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Category extends Front
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
        if( isset($this->query['id']) ){
            $term = cmsCategoryId($this->query['id']);
        }elseif( isset($this->query['slug']) ){
            $term= cmsCategorySlug($this->query['slug']);
        }elseif( isset($this->query['name']) ){
            $term = cmsCategoryName($this->query['name']);
        }else{
            $this->error(lang('cms_error_params'),'cms/index/index');
        }
        //数据为空
        if(!$term){
            $this->error(lang('cms_error_empty'),'cms/index/index');
        }
        //分页路径
        $term['pagePath'] = cmsUrlCategory($term,'[PAGE]');
        //地址栏
        $term['pageSize']   = cmsPageSize($term['term_limit']);
        $term['pageNumber'] = $this->site['page'];
        $term['sortName']   = 'info_order desc,info_update_time';
        $term['sortOrder']  = 'desc';
        //SEO标签
        $term['seoTitle'] = cmsSeo(DcEmpty($term['term_title'],$term['term_name']),$this->site['page']);
        $term['seoKeywords'] = cmsSeo(DcEmpty($term['term_keywords'],$term['term_name']),$this->site['page']);
        $term['seoDescription'] = cmsSeo(DcEmpty($term['term_description'],$term['term_name']),$this->site['page']);
        //数据列表
        $item = cmsSelect([
            'cache'   => true,
            'status'  =>'normal',
            'term_id' => $term['term_id'],
            'limit'   => $term['pageSize'],
            'page'    => $term['pageNumber'],
            'sort'    => $term['sortName'],
            'order'   => $term['sortOrder'],
        ]);
        //变量赋值
        $this->assign($term);
        $this->assign($item);
        //加载模板
        return $this->fetch(DcEmpty($term['term_tpl'],'index'));
    }
    
    public function all()
    {
        $info = [];
        $info['seoTitle']       = cmsSeo(config('cms.category_title'));
        $info['seoKeywords']    = cmsSeo(config('cms.category_keywords'));
        $info['seoDescription'] = cmsSeo(config('cms.category_description'));
        $this->assign($info);
        return $this->fetch('all');
    }
}