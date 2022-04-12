<?php
namespace app\ckeditor\event;

use think\Controller;

class Admin extends Controller
{
	
	public function _initialize(){
		parent::_initialize();
	}

	public function index(){
        return '此插件不需要后台';
	}
    
}