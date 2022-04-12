<?php
namespace app\cms\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        //初始配置
        model('cms/Datas','loglic')->insertConfig();
        
        //初始字段
        model('cms/Datas','loglic')->insertField();
        
        //初始路由
        model('cms/Datas','loglic')->insertRoute();
        
        //后台菜单
        model('cms/Datas','loglic')->insertMenu();
        
        //分类/标签/导航
        model('cms/Datas','loglic')->insertTerm();
        
        //采集规则
        model('cms/Datas','loglic')->insertCollect();
        
        //清空缓存
        \think\Cache::clear();
        
        //返回结果
        return true;
	}
    
    /**
    * 升级时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        //更新数据库、分类、标签、导航
        model('cms/Upgrade','loglic')->init();
        
        //初始字段
        model('cms/Datas','loglic')->insertField();
        
        //后台菜单
        model('cms/Datas','loglic')->insertMenu();
        
        //采集规则
        model('cms/Datas','loglic')->insertCollect();
        
        //更新基础信息
        \daicuo\Apply::updateStatus('cms', 'enable');

        //更新打包配置
        if(config('common.apply_module') == 'cms'){
            \daicuo\Op::write([
                'apply_version' => '1.3.13',
            ]);
        }
        
        //清空缓存
        \think\Cache::clear();

        return true;
    }
    
    /**
    * 卸载时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        //删除配置表
        \daicuo\Op::delete_module('cms');
        
        //删除后台菜单
        model('common/Menu','loglic')->unInstall('cms');
        
        return true;
    }
    
    /**
    * 删除时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        
        //删除配置表
        \daicuo\Op::delete_module('cms');

        //删除队列表
        model('common/Term','loglic')->unInstall('cms');
        
        //删除内容表
        model('common/Info','loglic')->unInstall('cms');
        
        //返回结果
        return true;
	}
}