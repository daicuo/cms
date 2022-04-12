<?php
namespace app\ckeditor\controller;

use app\common\controller\Front;

class Index extends Front
{

	public function _initialize()
    {
		parent::_initialize();
	}

	public function index()
    {
        config('common.editor_name','ckeditor');
        
        $file = new \files\File();
        
        $file->d_delete(TEMP_PATH);

		return $this->fetch();
	}
}