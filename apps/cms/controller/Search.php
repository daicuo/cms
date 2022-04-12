<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Search extends Front
{

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
        //post请求
        if( $this->request->isPost() ){
            $this->redirect(cmsUrlSearch(['searchText'=>input('post.searchText/s')],$this->site['action']),302);
        }
    }
    
    //站内搜索
    public function index()
    {
        //判断是否有关键词
        if( !$this->query['searchText'] ){
            $this->error(lang('cms_error_params'),'cms/index/index');
        }
        
        //搜索限制验证
        if( !$this->searchCheck() ){
            $this->error(lang('cms_error_rest'), 'cms/index/index');
        }
        
        //地址栏
        $info = [];
        $info['searchText'] = $this->query['searchText'];
        $info['pageSize']   = cmsPageSize(config('cms.limit_search'));
        $info['pageNumber'] = $this->site['page'];
        $info['sortName']   = 'info_order desc,info_views';
        $info['sortOrder']  = 'desc';
        
        //所有搜索引擎链接
        $info = $this->searchList($info);
    
        //分页路径
        $info['pagePath'] = cmsUrlSearch([
            'searchText' => $info['searchText'],
            'pageNumber' => '[PAGE]',
        ],'index');
        
        //SEO标签
        $info['seoTitle']       = cmsSeo(str_replace('[searchText]',$info['searchText'],config('cms.search_title')),$this->site['page']);
        $info['seoKeywords']    = cmsSeo(str_replace('[searchText]',$info['searchText'],config('cms.search_keywords')),$this->site['page']);
        $info['seoDescription'] = cmsSeo(str_replace('[searchText]',$info['searchText'],config('cms.search_description')),$this->site['page']);
        
        //查询数据
        $item = cmsSelect([
            'cache'   => true,
            'status'  =>'normal',
            'limit'   => $info['pageSize'],
            'page'    => $info['pageNumber'],
            'sort'    => $info['sortName'],
            'order'   => $info['sortOrder'],
            'search'  => $info['searchText'],
            /*'whereOr' => ['info_name'=>['like','%'.$info['search'].'%']],
            'meta_query'  => [
                ['key' => ['eq','url_web'], 'value' => ['like','%'.$info['search'].'%']],
            ],*/
        ]);
        
        //变量赋值
        $this->assign($info);
        $this->assign($item);
        
        //加载模板
        return $this->fetch();
    }
    
    public function baidu()
    {
        $this->redirect('https://www.baidu.com/s?tn=bds&cl=3&ct=2097152&si='.config('common.site_domain').'&wd='.$this->query['searchText'],302);
    }
    
    public function sogou()
    {
        $this->redirect('https://www.sogou.com/web?query='.$this->query['searchText'],302);
    }
    
    public function toutiao()
    {
        $this->redirect('https://so.toutiao.com/search?mod=website&keyword='.$this->query['searchText'],302);
    }
    
    public function bing()
    {
        $this->redirect('https://cn.bing.com/search?q='.$this->query['searchText'],302);
    }
    
    public function so()
    {
        $this->redirect('https://www.so.com/s?q='.$this->query['searchText'],302);
    }
    
    //搜索请求是否合法（搜索间隔时长）
    private function searchCheck()
    {
        //后台验证开关
        $configInterval = intval(config('cms.search_interval'));
        if($configInterval < 1){
            return true;
        }
        //搜索限制白名单
        if( array_intersect(['administrator','edit'], $this->site['user']['user_capabilities']) ){
            return true;
        }
        //客户端唯一标识
        $client = md5($this->request->ip().$this->request->header('user-agent'));
        //几秒内不得再次搜索(缓存标识未过期)
        if( DcCache('search'.$client) ){
            return false;
        }
        DcCache('search'.$client, 1, $configInterval);
        //未超出限制
        return true;
    }
    
    //第三方搜索引擎列表
    private function searchList($info=[])
    {
        //定义搜索列表
        foreach(explode(',',config('cms.search_list')) as $key=>$name){
            $info['search_list'][$name] = cmsUrlSearch(['searchText' => $info['searchText']], $name);
        }
        
        //预留钩子
        \think\Hook::listen('cms_search_list', $info);
        
        return $info;
    }
}