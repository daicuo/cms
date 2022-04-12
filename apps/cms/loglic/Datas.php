<?php
namespace app\cms\loglic;

class Datas
{
    //批量添加初始配置
    public function insertConfig()
    {
        return model('common/Config','loglic')->install([
            'theme'             => 'default',
            'theme_wap'         => 'default',
            'index_title'       => '呆错文章管理系统',
            'index_keywords'    => '新闻发布系统,文章管理系统,文章系统,文章CMS,新闻CMS',
            'index_description' => '呆错文章系统是一款基于呆错后台开发框架研发的文章管理系统，被广泛应用于搭建博客、行业站、企业站、产品展示等。',
            'slug_first'        => 1,
            'request_max'       => 0,
            'search_interval'   => 0,
            'search_hot'        => '',
            'search_list'       => 'index,baidu,sogou,toutiao,bing,so',
            'rewrite_index'     => '/cms$',
            'limit_default'     => 10,
            'limit_index'       => 10,
            'limit_search'      => 10,
            'limit_sitemap'     => 100,
            'limit_tag_index'   => 10,
            'limit_tag_all'     => 60,
        ],'cms');
    }
    
    //批量添加路由
    public function insertRoute()
    {
        config('common.validate_name', '');
        
        return model('common/Route','loglic')->install([
            [
                'rule'        => '/cms$',
                'address'     => 'cms/index/index',
                'method'      => '*',
                'op_module'   => 'cms',
                'op_controll' => 'route',
                'op_action'   => 'system',
            ],
        ]);
    }
    
    //批量添加后台菜单
    public function insertMenu()
    {
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '文章',
                'term_slug'   => 'cms',
                'term_info'   => 'fa-file-text',
                'term_module' => 'cms',
            ],
        ]);
        
        $result = model('common/Menu','loglic')->install([
            [
                'term_name'   => '文章管理',
                'term_slug'   => 'cms/admin/index',
                'term_info'   => 'fa-navicon',
                'term_module' => 'cms',
                'term_order'  => 9,
            ],
            [
                'term_name'   => '采集管理',
                'term_slug'   => 'cms/collect/index',
                'term_info'   => 'fa-cloud',
                'term_module' => 'cms',
                'term_order'  => 8,
            ],
            [
                'term_name'   => '栏目管理',
                'term_slug'   => 'admin/category/index?parent=cms&term_module=cms',
                'term_info'   => 'fa-list',
                'term_module' => 'cms',
                'term_order'  => 7,
            ],
            [
                'term_name'   => '标签管理',
                'term_slug'   => 'admin/tag/index?parent=cms&term_module=cms',
                'term_info'   => 'fa-tags',
                'term_module' => 'cms',
                'term_order'  => 6,
            ],
            [
                'term_name'   => '频道设置',
                'term_slug'   => 'cms/config/index',
                'term_info'   => 'fa-gear',
                'term_module' => 'cms',
                'term_order'  => 5,
            ],
            [
                'term_name'   => 'SEO优化',
                'term_slug'   => 'cms/seo/index',
                'term_info'   => 'fa-anchor',
                'term_module' => 'cms',
                'term_order'  => 4,
            ],
            [
                'term_name'   => '字段扩展',
                'term_slug'   => 'admin/field/index?parent=cms&op_module=cms',
                'term_info'   => 'fa-cube',
                'term_module' => 'cms',
                'term_order'  => 3,
            ],
        ],'文章');
    }
    
    //批量添加分类/标签/导航
    public function insertTerm()
    {
        //分类
        $result = model('common/Category','loglic')->install([
            [
                'term_name'       => '分类1',
                'term_slug'       => 'category1',
                'term_type'       => 'navbar',
                'term_module'     => 'cms',
            ],
            [
                'term_name'       => '分类2',
                'term_slug'       => 'category2',
                'term_type'       => 'navbar',
                'term_module'     => 'cms',
            ],
        ]);
        
        //标签
        $result = model('common/Tag','loglic')->install([
            [
                'term_name'       => '标签1',
                'term_slug'       => 'tag1',
                'term_module'     => 'cms',
            ],
            [
                'term_name'       => '标签2',
                'term_slug'       => 'tag2',
                'term_module'     => 'cms',
            ],
        ]);
        
        //导航
        $result = model('common/Navs','loglic')->install([
            [
                'navs_name'       => '文章',
                'navs_url'        => 'cms/index/index',
                'navs_type'       => 'navbar',
                'navs_module'     => 'cms',
                'navs_active'     => 'cmsindexindex',
                'navs_target'     => '_self',
            ],
        ]);
        
        return true;
    }
    
    //批量添加扩展字段
    public function insertField()
    {
        config('common.validate_name', '');
        
        return model('common/Field','loglic')->install([
            [
                'op_name'     => 'cms_color',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_cover',
                'op_value'    => json_encode([
                    'type'         => 'image',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_slide',
                'op_value'    => json_encode([
                    'type'         => 'image',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_up',
                'op_value'    => json_encode([
                    'type'         => 'number',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_down',
                'op_value'    => json_encode([
                    'type'         => 'number',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_referer',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_letter',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_tpl',
                'op_value'    => json_encode([
                    'type'         => 'text',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_top',
                'op_value'    => json_encode([
                    'type'         => 'hidden',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_recommend',
                'op_value'    => json_encode([
                    'type'         => 'hidden',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_fast',
                'op_value'    => json_encode([
                    'type'         => 'hidden',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ],
            [
                'op_name'     => 'cms_head',
                'op_value'    => json_encode([
                    'type'         => 'hidden',
                    'relation'     => 'eq',
                    'data-visible' => false,
                    'data-filter'  => false,
                ]),
                'op_module'   => 'cms',
                'op_controll' => 'detail',
                'op_action'   => 'default',
            ]
        ]);
    }
    
    // 添加采集规则
    public function insertCollect()
    {
        return model('cms/Collect','loglic')->write([
            'collect_name'     => '影视评论',
            'collect_url'      => 'http://api.daicuo.cc/yingping/',
            'collect_token'    => '',
            'collect_category' => '',
        ]);
    }
    
    //按插件应用名删除数据
    public function delete()
    {
        //删除插件配置
        \daicuo\Op::delete_module('cms');
    
        //删除插件分类/标签/导航
        \daicuo\Term::delete_module('cms');
        
        //删除内容数据
        \daicuo\Info::delete_module('cms');
    }
    
}