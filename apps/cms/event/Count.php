<?php
namespace app\cms\event;

use app\common\controller\Addon;

class Count extends Addon
{
    public function _initialize()
    {
        parent::_initialize();
    }

	public function index()
    {
        $result = [];
        $result['category'] = number_format( db('term')->where(['term_module'=>'cms','term_controll'=>'category'])->count('term_id') );
        $result['tag']      = number_format( db('term')->where(['term_module'=>'cms','term_controll'=>'tag'])->count('term_id') );
        $result['detail']   = number_format( db('info')->where(['info_module'=>'cms'])->count('info_id') );
        return json($result);
    }
}