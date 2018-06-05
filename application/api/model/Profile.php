<?php
namespace app\api\model;
use think\Model;

class Profile extends Model {
	protected $type = [
		'birthday' => 'timestamp:Y-m-d'
	];

	public function user(){

		//档案 belongs to 关联用户
		return $this->belongsTo('User');
	}
}

?>