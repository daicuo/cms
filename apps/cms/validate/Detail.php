<?php
namespace app\cms\validate;

use think\Validate;

class Detail extends Validate
{
	
	protected $rule = [
        'info_module'   => 'require',
        'info_name'     => 'require',
        'info_id'       => 'require',
        'info_slug'     => 'require',
        'cms_referer'   => 'unique_referer',
	];
	
	protected $message = [
        'info_module.require' => '{%cms_info_module_require}',
		'info_name.require'   => '{%cms_info_name_require}',      
        'info_id.require'     => '{%cms_info_id_require}',
        'info_slug.require'   => '{%cms_info_slug_require}',
        'info_slug.unique'    => '{%cms_info_slug_unique}',
	];
	
	protected $scene = [
        //新增
		'save' => ['info_module','info_name'],
        //修改
		'update' => ['info_module','info_name','info_id'],
        //别名唯一
        'slugUnique' => ['info_module','info_name','info_slug'=>'require|unique_slug'],
        //来源唯一
        'refererUnique' => ['info_module','info_name','cms_referer'],
	];
    
    //别名URL唯一
    protected function unique_slug($value, $rule, $data, $field)
    {
        $where = array();
        $where['info_module']     = ['eq','cms'];
        $where['info_slug']       = ['eq',$value];
        $info = db('info')->where($where)->value('info_id');
        //无记录直接通过
        if(is_null($info)){
            return true;
        }
        //已有记录
		return lang('cms_info_slug_unique');
	}
    
    //来源网址唯一
    protected function unique_referer($value, $rule, $data, $field)
    {
        $where = array();
        $where['info_meta_key']   = ['eq','cms_referer'];
        $where['info_meta_value'] = ['eq',$value];
        $info = db('infoMeta')->where($where)->value('info_meta_id');
        //无记录直接通过
        if(is_null($info)){
            return true;
        }
        //已有记录
		return lang('cms_referer_unique');
	}
}