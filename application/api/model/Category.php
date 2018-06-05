<?php
namespace app\api\model;
use think\Model;

/**
* 
*/
class Category extends Model
{
    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    public function articles(){
    	//belongsToMany(‘关联模型名’,‘中间表名称’,‘关联外键’,‘关联模型主键’,‘别名定义’)
    	return $this->belongsToMany("Article","access");
    }
}

?>