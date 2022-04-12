<?php
namespace app\cms\behavior;

use think\Controller;

class Hook extends Controller
{
    public function adminIndexHeader(&$params)
    {
        echo $this->fetch('cms@count/index');
    }
    
    //前台权限扩展
    public function adminCapsFront(&$caps)
    {
        $caps = array_merge($caps,[
            'cms/data/index',
        ]);
    }
    
    //后台权限扩展
    public function adminCapsBack(&$caps)
    {
        $caps = array_merge($caps,[
            'cms/admin/index',
            'cms/admin/save',
            'cms/admin/delete',
            'cms/collect/index',
            'cms/collect/save',
            'cms/collect/delete',
            'cms/collect/write',
        ]);
    }
}