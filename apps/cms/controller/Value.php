<?php
namespace app\cms\controller;

use app\common\controller\Front;

class Value extends Front
{
    public function _initialize()
    {
        //请求验证
        if( !cmsRequestCheck($this->request->ip(),$this->request->header('user-agent')) ){
            $this->error(lang('cms_error_rest'), 'cms/index/index');
        }
		parent::_initialize();
    }
    
    public function index()
    {
        return json(['code'=>0,'value'=>0]);
    }
    
    public function hits()
    {
        return $this->incBase('info_hits');
    }
    
    public function views()
    {
        return $this->incBase('info_views');
    }
    
    public function up()
    {
        return $this->incMeta('cms_up');
    }
    
    public function down()
    {
        return $this->incMeta('cms_down');
    }
    
    //普通字段
    public function incBase($field='info_hits')
    {
        $id = input('id/f', 0);

        $value = dbFindValue('common/Info', ['info_id'=>['eq',$id]], $field);
        if( !is_null($value) ){
            cmsInfoInc($id, $field);
            return json(['code'=>1,'value'=>intval($value)+1]);
        }
        
        return json(['code'=>0,'value'=>0]);
    }
    
    //扩展字段
    private function incMeta($field='cms_up')
    {
        $id = input('id/f', 0);

        $value = dbFindValue('common/infoMeta', ['info_id'=>['eq',$id],'info_meta_key'=>['eq',$field]], 'info_meta_value');
        
        if( !is_null($value) ){
            cmsMetaInc($id, $field);
            return json(['code'=>1,'value'=>intval($value)+1]);
        }
        
        return json(['code'=>0,'value'=>0]);
    }
}