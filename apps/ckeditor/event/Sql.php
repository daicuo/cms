<?php
namespace app\ckeditor\event;

class Sql
{
    /**
    * 安装时触发
    * @return bool 只有返回true时才会往下执行
    */
	public function install()
    {
        $this->insertConfig();
        
        $this->clearTemp();
        
        return true;
	}
    
    /**
    * 升级时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function upgrade()
    {
        $this->insertConfig();
        
        $this->clearTemp();
        
        \daicuo\Apply::updateStatus('ckeditor', 'enable');
        
        return true;
	}

    /**
    * 卸载插件时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function remove()
    {
        return $this->unInstall();
    }
    
    /**
    * 删除时触发
    * @return bool 只有返回true时才会往下执行
    */
    public function unInstall()
    {
        if( config('common.editor_name') == 'ckeditor' ){
            db('op')->where(['op_name'=>'editor_name'])->delete();
            
            $this->clearTemp();
        }
        
        return true;
	}
    
    //写入数据
    private function insertConfig()
    {
        //保证唯一
        db('op')->where(['op_name'=>'editor_name'])->delete();
        
        //添加数据
        model('common/Config','loglic')->install([
            'editor_name' => 'ckeditor',
        ],'common');
    }
    
    //清除模板缓存
    private function clearTemp()
    {
        $file = new \files\File();
        
        $file->d_delete(TEMP_PATH);
    }
	
}