<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Index extends Front
{

    public function _initialize()
    {
        parent::_initialize();
    }
    
    public function index()
    {
        $info = [];
        //分页路径
        $info['pagePath']   = DcUrl('cms/index/index',['pageNumber'=>'[PAGE]']);
        //地址栏
        $info['pageSize']   = cmsPageSize(config('cms.limit_index'));
        $info['pageNumber'] = $this->site['page'];
        //SEO标签
        $info['seoTitle']       = cmsSeo(config('cms.index_title'),$this->site['page']);
        $info['seoKeywords']    = cmsSeo(config('cms.index_keywords'),$this->site['page']);
        $info['seoDescription'] = cmsSeo(config('cms.index_description'),$this->site['page']);
        //数据列表按置顶的排序
        if(config('cms.limit_index')){
            $item = cmsSelect([
                'cache'    => true,
                'status'   => 'normal',
                'limit'    => $info['pageSize'],
                'page'     => $info['pageNumber'],
                'sort'     => 'info_order desc,info_update_time',//meta_value_num
                'order'    => 'desc',
                //'meta_key' => 'cms_top',
            ]);
        }
        //变量赋值
        $this->assign($info);
        $this->assign($item);
        //加载模板
        return $this->fetch();
    }
    
    //最近更新
    public function news()
    {
        return $this->fetch();
    }
    
    //热门文章
    public function views()
    {
        return $this->fetch();
    }
    
    //属性－置顶文章
    public function top()
    {
        return $this->fetch();
    }
    
    //属性－推荐文章
    public function recommend()
    {
        return $this->fetch();
    }
    
    //属性－快审文章
    public function fast()
    {
        return $this->fetch();
    }
    
    //属性－头条文章
    public function head()
    {
        return $this->fetch();
    }
    
    //自定义
    public function _empty($name='')
    {
        $name = DcDirPath(DcHtml($name));
        if(is_file('./'.$this->site['path_view'].'index/'.$name.'.tpl')){
            return $this->fetch($name);
        }
        return $name;
    }
}