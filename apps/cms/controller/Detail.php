<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Detail extends Front
{

    public function _initialize()
    {
        //请求验证
        if( !cmsRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('cms_error_rest'), 'cms/index/index');
        }
        // 继承上级
        parent::_initialize();
    }
    
    public function index()
    {
        if( isset($this->query['id']) ){
            $info = cmsGetId($this->query['id']);
        }elseif( isset($this->query['slug']) ){
            $info = cmsGetSlug($this->query['slug']);
        }elseif( isset($this->query['name']) ){
            $info = cmsGetName($this->query['name']);
        }else{
            $this->error(lang('cms_error_params'),'cms/index/index');
        }
        //数据判断
        if(!$info){
            $this->error(lang('cms_error_empty'),'cms/index/index');
        }
        //SEO标签
        $info['seoTitle'] = cmsSeo(DcEmpty($info['info_title'],$info['info_name']));
        $info['seoKeywords'] = cmsSeo(DcEmpty($info['cms_keywords'],$info['info_name']));
        $info['seoDescription'] = cmsSeo(DcEmpty($info['cms_description'],cmsSubstr($info['info_excerpt'],0,100)));
        //模板名称
        $info['info_type'] = DcEmpty($info['info_type'], 'index');
        //分享链接
        if(DcBool(config('common.app_domain'))){
            $info['info_share_url'] = cmsUrlDetail($info);
        }else{
            $info['info_share_url'] = $this->site['domain'].cmsUrlDetail($info);
        }
        //增加人气值
        cmsInfoInc($info['info_id'],'info_views');
        //变量赋值
        $this->assign($info);
        //加载模板
        return $this->fetch(DcEmpty($info['cms_tpl'],$info['info_type']));
    }
}