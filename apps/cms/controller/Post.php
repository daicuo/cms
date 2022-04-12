<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Post extends Front
{
    public function _initialize()
    {
		parent::_initialize();
    }
    
    public function index()
    {
        //必需设置密码
        if(!config('cms.post_pwd')){
            return json(['code'=>0,'msg'=>lang('cms_post_config')]);
        }
        //获取表单数据
        $post = input('post.');
        //入库密码字段
        if(!$post['post_pwd']){
            return json(['code'=>0,'msg'=>lang('cms_post_empty')]);
        }
        //密码验证
        if($post['post_pwd'] != config('cms.post_pwd')){
            return json(['code'=>0,'msg'=>lang('cms_post_wrong')]);
        }
        //检查是否已存在来源
        if($this->refererUnique($post['cms_referer'])){
            return json(['code'=>0,'msg'=>lang('cms_post_referer')]);
        }
        //保存数据
        if( !$id=cmsSave($post, true) ){
            return json(['code'=>0,'msg'=>lang('cms_post_fail')]);
        }
        //添加成功
        return json(['code'=>1,'data'=>$id]);
    }
    
    //来源网址验证唯一（返回id|null）
    private function refererUnique($referer='')
    {
        if(!$referer){
            return null;
        }
        $where = array();
        $where['info_meta_key']   = ['eq','cms_referer'];
        $where['info_meta_value'] = ['eq',$referer];
        return db('infoMeta')->where($where)->value('info_meta_id');
    }
    
    public function test()
    {
        $data = [];
        $data['post_pwd']      = '123456';//入库密码字段（必填、需与后台设置的一致）
        $data['category_name'] = '分类1,分类2';//分类字段，多个用逗号分隔
        $data['tag_name']      = '标签1,标签2';//标签字段，多个用逗号分隔
        $data['info_name']     = 'this is post test';//文章名称
        $data['info_excerpt']  = 'this is excerpt';//文章简介
        $data['info_content']  = 'this is content';//文章详情
        $data['info_type']     = 'index';//文章形式(index|image|album|video|audio|link)
        $data['cms_cover']    = 'https://cdn.daicuo.cc/images/daicuo/favicon.ico';//封面字段
        $data['cms_referer']   = 'https://cdn.daicuo.cc/post1';//不提交此字段则不验证是否已采集
        $result = DcCurl('auto', 10, 'http://'.config('common.site_domain').'/cms/post', $data);
        dump($result);
    }
}