<?php
namespace app\api\model;
use think\Model;

/**
* 
*/
class Article extends Model
{
    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;
	
	// 定义自动完成的属性
    protected $insert = ['status' => 1];

    public function categories(){
    	//belongsToMany(‘关联模型名’,‘中间表名称’,‘关联外键’,‘关联模型主键’,‘别名定义’)
    	return $this->belongsToMany("Category","access");
    }

    //文章发布者
    public function user(){
    	//belongsTo(‘关联模型名’,‘关联外键’,‘关联模型主键’,‘别名定义’,‘join类型’)
    	return $this->belongsTo("User","user_id","id");
    }

}

?>