<?php
namespace app\cms\validate;

use think\Validate;

class Tag extends Validate
{
	
	protected $rule = [
		'term_name'        => 'require|length:1,60',
        'term_id'          => 'require',
	];
	
	protected $message = [
		'term_name.require' => '{%term_name_require}',
		'term_name.length'  => '{%term_name_length}',
	];
	
	//验证场景
	protected $scene = [
		'save'        =>  ['term_name'],
		'update'      =>  ['term_name','term_id'],
	];
}