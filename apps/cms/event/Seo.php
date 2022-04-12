<?php
namespace app\cms\event;

use app\common\controller\Addon;

class Seo extends Addon
{
    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        $items = [
            'rewrite_index' => [
                'type'        => 'text', 
                'value'       => DcEmpty(config('cms.rewrite_index'), 'cms$'),
                'placeholder' => '',
                'tips'        => 'cms$',
            ],
            'rewrite_category' => [
                'type'        => 'text', 
                'value'       => config('cms.rewrite_category'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:pageNumber]',
            ],
            'rewrite_tag' => [
                'type'        => 'text',
                'value'       => config('cms.rewrite_tag'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:pageNumber]',
            ],
            'rewrite_search' => [
                'type'        => 'text',
                'value'       => config('cms.rewrite_search'),
                'placeholder' => '',
                'tips'        => '[:searchText] [:pageNumber]',
            ],
            'rewrite_detail' => [
                'type'        => 'text',
                'value'       => config('cms.rewrite_detail'),
                'placeholder' => '',
                'tips'        => '[:id] [:slug] [:name] [:termId] [:termSlug] [:termName]',
            ],
            'html_hr' => [
                'type'        => 'html',
                'value'       => '<hr>',
            ],
            'index_title' => [
                'type'        => 'text', 
                'value'       => config('cms.index_title'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'index_keywords' => [
                'type'        => 'text', 
                'value'       => config('cms.index_keywords'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'index_description' => [
                'type'        => 'text', 
                'value'       => config('cms.index_description'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'search_title' => [
                'type'        => 'text', 
                'value'       => config('cms.search_title'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber] [searchText]',
            ],
            'search_keywords' => [
                'type'        => 'text', 
                'value'       => config('cms.search_keywords'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber] [searchText]',
            ],
            'search_description' => [
                'type'        => 'text', 
                'value'       => config('cms.search_description'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber] [searchText]',
            ],
            'category_title' => [
                'type'        => 'text', 
                'value'       => config('cms.category_title'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'category_keywords' => [
                'type'        => 'text', 
                'value'       => config('cms.category_keywords'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'category_description' => [
                'type'        => 'text', 
                'value'       => config('cms.category_description'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'tag_title' => [
                'type'        => 'text', 
                'value'       => config('cms.tag_title'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'tag_keywords' => [
                'type'        => 'text', 
                'value'       => config('cms.tag_keywords'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
            'tag_description' => [
                'type'        => 'text', 
                'value'       => config('cms.tag_description'),
                'placeholder' => '',
                'tips'        => '[siteName] [siteDomain] [pageNumber]',
            ],
        ];
        
        foreach($items as $key=>$value){
            $items[$key]['title']       = lang('cms_'.$key);
            if(!isset($value['placeholder'])){
                $items[$key]['placeholder'] = '';
            }
        }
        
        $this->assign('items', DcFormItems($items));
        
        return $this->fetch('cms@seo/index');
    }
    
    public function update()
    {
        $post   = input('post.');
        $status = \daicuo\Op::write($post, 'cms', 'config', 'system', 0, 'yes');
		if( !$status ){
		    $this->error(lang('fail'));
        }
        //处理伪静态路由
        $this->rewriteRoute($post);
        //返回结果
        $this->success(lang('success'));
    }
    
    //配置伪静态
    private function rewriteRoute($post)
    {
        //批量删除路由伪静态
        \daicuo\Op::delete_all([
            'op_name'     => ['eq','site_route'],
            'op_module'   => ['eq','cms'],
            //'op_controll' => ['in','index,category,tag,search,filter,detail'],
        ]);
        //批量添加路由伪静态
        $result = \daicuo\Route::save_all([
            [
                'rule'        => $post['rewrite_index'],
                'address'     => 'cms/index/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'index',
                'op_action'   => 'index',
            ],
            [
                'rule'        => $post['rewrite_category'],
                'address'     => 'cms/category/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'category',
                'op_action'   => 'index',
            ],
            [
                'rule'        => $post['rewrite_tag'],
                'address'     => 'cms/tag/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'tag',
                'op_action'   => 'index',
            ],
            [
                'rule'        => $post['rewrite_search'],
                'address'     => 'cms/search/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'search',
                'op_action'   => 'index',
            ],
            [
                'rule'        => $post['rewrite_detail'],
                'address'     => 'cms/detail/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'index',
            ],
        ]);
        //清理全局缓存
        DcCache('route_all', null);
    }
}