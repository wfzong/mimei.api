<?php
namespace app\api\model;
use think\Model;

class User extends Model {
	protected static function init(){
		User::beforeInsert(function($user){
			//return true;//对数据进行检验
		});
	}

	protected $auto = [ 'ip'];//更新、新增的时候，会处理对应字段
	protected $insert = ['status' => 1];//新增的时候，会处理的字段
	protected $update = [];//更新的时候，会处理的字段

	protected function setIpAttr()
	{
		return request()->ip();
	}


	//定义一对一关系
	public function profile()
	{
		return $this->hasOne('Profile');
	}

	//发布的文章
	public function articles(){
		return $this->hasMany("Article");
	}


}

?>