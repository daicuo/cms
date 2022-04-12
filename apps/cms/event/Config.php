<?php
namespace app\cms\event;

use app\common\controller\Addon;

class Config extends Addon
{
	public function _initialize()
    {
		parent::_initialize();
	}

	public function index()
    {
        $themes = DcThemeOption('cms');
    
        $items  = DcFormItems([
            'theme' => [
                'type'   =>'select', 
                'value'  => config('cms.theme'), 
                'option' => $themes,
            ],
            'theme_wap' => [
                'type'   => 'select',
                'value'  => config('cms.theme_wap'),
                'option' => $themes,
            ],
            'slug_first' => [
                'type'       => 'select',
                'value'      => config('cms.slug_first'),
                'option'     => [0=>lang('close'),1=>lang('open')],
            ],
            'request_max' => [
                'type'        => 'number',
                'value'       => intval(config('cms.request_max')),
                'tips'        => lang('cms_request_max_tips'),
            ],
            'search_interval' => [
                'type'        => 'number',
                'value'       => intval(config('cms.search_interval')),
                'tips'        => lang('cms_search_interval_tips'),
            ],
            'search_hot' => [
                'type'        => 'text',
                'value'       => config('cms.search_hot'),
                'rows'        => 3,
                'tips'        => lang('cms_search_hot_tips'),
            ],
            'search_list' => [
                'type'        => 'text',
                'value'       => config('cms.search_list'),
                'rows'        => 3,
                'tips'        => lang('cms_search_list_tips'),
            ],
            'type_option' => [
                'type'       => 'text',
                'value'      => config('cms.type_option'),
                'tips'        => lang('cms_type_option_tips'),
            ],
            'post_pwd' => [
                'type'       => 'text',
                'value'      => config('cms.post_pwd'),
                'tips'        => lang('cms_post_pwd_tips'),
            ],
            'hr_1' => [
                'type'        => 'html',
                'value'       => '<hr>',
            ],
            'limit_default' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_default'),10),
            ],
            'limit_index' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_index'),10),
            ],
            'limit_search' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_search'),10),
            ],
            'limit_sitemap' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_sitemap'),10),
            ],
            'limit_tag_index' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_tag_index'),10),
            ],
            'limit_tag_all' => [
                'type'        => 'number',
                'value'       => DcEmpty(config('cms.limit_tag_all'),10),
            ],
        ]);
        
        foreach($items as $key=>$value){
            $items[$key]['title'] = lang('cms_'.$key);
            $items[$key]['placeholder'] = '';
        }
        
        $this->assign('items', $items);
        
        return $this->fetch('cms@config/index');
	}
    
    public function update()
    {
        $status = \daicuo\Op::write(input('post.'), 'cms', 'config', 'system', 0, 'yes');
		if( !$status ){
		    $this->error(lang('fail'));
        }
        $this->success(lang('success'));
	}
}