<?php
namespace app\cms\loglic;

use app\common\loglic\Update;

class Upgrade extends Update
{
    public function init()
    {
        //升级表结构	
		if(config('database.type') == 'sqlite'){
            $this->_sqlite();
        }else{
            $this->_mysql();
        }
        
        //升级NAVBAR
        $this->navs();
        
        //升级分类
        $this->category();
        
        //升级标签
        $this->tag();
    }
    
    //升级navbar
    public function navs()
    {
        $list = DcTermSelect([
            'type' => 'navs',
        ]);
        //字段映射
        $navs = [];
        foreach($list as $key=>$value){
            $navs[$key]['term_id']       = $value['term_id'];
            $navs[$key]['term_parent']   = $value['term_parent'];
            $navs[$key]['term_name']     = $value['term_name'];
            $navs[$key]['term_slug']     = $value['navs_url'];
            $navs[$key]['term_type']     = str_replace(['navs','links'],['nav','link'],$value['term_action']);
            $navs[$key]['term_info']     = $value['term_info'];
            $navs[$key]['term_title']    = $value['navs_active'];
            $navs[$key]['term_keywords'] = $value['navs_ico'];
            $navs[$key]['term_description'] = $value['navs_image'];
            $navs[$key]['term_status']   = $value['term_status'];
            $navs[$key]['term_order']    = $value['term_order'];
            $navs[$key]['term_action']   = $value['navs_target'];
            $navs[$key]['term_controll'] = 'navs';
            $navs[$key]['term_module']   = $value['term_module'];
        }
        //批量更新
        $result = dbUpdateAll('term',$navs);
        //删除无用
        $result = db('termMeta')->where(['term_meta_key'=>['in',['navs_url','navs_image','navs_class','navs_active','navs_target']]])->delete();
        //返回结果
        return $result;
    }
    
    //转换分类
    public function category()
    {
        \think\Db::execute("update dc_term set term_controll='category' where term_type='category' and term_module='cms';");
        
        \think\Db::execute("update dc_term set term_type='navbar' where term_controll='category' and term_module='cms';");
    }
    
    //转换标签
    public function tag()
    {
        \think\Db::execute("update dc_term set term_controll='tag' where term_type='tag' and term_module='cms';");
    }
    
    //表结构
    public function _mysql()
    {
        $prefix = config('database.prefix');
        
        $sql = [];
        
        array_push($sql, "ALTER TABLE ".$prefix."term Add term_title VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE ".$prefix."term Add term_keywords VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE ".$prefix."term Add term_description VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE ".$prefix."info Add info_keywords VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE ".$prefix."info Add info_description VARCHAR(255) NULL;");
        
        array_push($sql,"DROP TABLE IF EXISTS `".$prefix."log`;");
        
        array_push($sql, "CREATE TABLE `".$prefix."log` (
          `log_id` bigint(20) NOT NULL,
          `log_user_id` bigint(20) NOT NULL DEFAULT '0',
          `log_info_id` bigint(20) NOT NULL DEFAULT '0',
          `log_value` int(11) NOT NULL DEFAULT '0' COMMENT '整数值',
          `log_decimal` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '小数值',
          `log_status` varchar(60) NOT NULL DEFAULT 'normal',
          `log_module` varchar(150) DEFAULT NULL,
          `log_controll` varchar(150) DEFAULT NULL,
          `log_action` varchar(150) DEFAULT NULL,
          `log_type` varchar(100) DEFAULT NULL,
          `log_ip` varchar(250) DEFAULT NULL,
          `log_name` varchar(250) DEFAULT NULL,
          `log_info` tinytext,
          `log_create_time` int(11) NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
        //索引
        array_push($sql, "ALTER TABLE `".$prefix."log`
          ADD PRIMARY KEY (`log_id`),
          ADD KEY `log_user_id` (`log_user_id`),
          ADD KEY `log_info_id` (`log_info_id`),
          ADD KEY `log_status` (`log_status`),
          ADD KEY `log_module` (`log_module`),
          ADD KEY `log_controll` (`log_controll`),
          ADD KEY `log_action` (`log_action`),
          ADD KEY `log_type` (`log_type`);");
        //自增
        array_push($sql, "ALTER TABLE `".$prefix."log`
          MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;");
        //执行SQL语句
        $this->executeSql($sql);
    }
    
    //sqlite3数据库
    private function _sqlite()
    {
        //定义变量
        $sql = [];
        
        array_push($sql, "ALTER TABLE dc_term Add term_title VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE dc_term Add term_keywords VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE dc_term Add term_description VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE dc_info Add info_keywords VARCHAR(255) NULL;");
        
        array_push($sql, "ALTER TABLE dc_info Add info_description VARCHAR(255) NULL;");
        
        array_push($sql, "DROP TABLE IF EXISTS dc_log;");
        
        array_push($sql, "CREATE TABLE [dc_log] (
            [log_id] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
            [log_user_id] INTEGER DEFAULT '0' NULL,
            [log_info_id] INTEGER DEFAULT '0' NULL,
            [log_value] INTEGER DEFAULT '0' NULL,
            [log_decimal] REAL DEFAULT '0.00' NULL,
            [log_status] VARCHAR(100) DEFAULT 'normal' NULL,
            [log_module] VARCHAR(100) DEFAULT 'common' NULL,
            [log_controll] VARCHAR(100)  NULL,
            [log_action] VARCHAR(100)  NULL,
            [log_type] VARCHAR(100)  NULL,
            [log_ip] VARCHAR(100)  NULL,
            [log_name] VARCHAR(255)  NULL,
            [log_info] TEXT  NULL,
            [log_create_time] INTEGER DEFAULT '0' NULL
        );");
        
        array_push($sql,"CREATE INDEX [log_id] ON [dc_log](log_id);");
        
        array_push($sql,"CREATE INDEX [log_user_id] ON [dc_log](log_user_id);");
        
        array_push($sql,"CREATE INDEX [log_info_id] ON [dc_log](log_info_id);");
        
        array_push($sql,"CREATE INDEX [log_status] ON [dc_log](log_status);");
        
        array_push($sql,"CREATE INDEX [log_module] ON [dc_log](log_module);");
        
        array_push($sql,"CREATE INDEX [log_controll] ON [dc_log](log_controll);");
        
        array_push($sql,"CREATE INDEX [log_action] ON [dc_log](log_action);");
        
        array_push($sql,"CREATE INDEX [log_type] ON [dc_log](log_type);");
        
        //执行SQL语句
        $this->executeSql($sql);
    }
}