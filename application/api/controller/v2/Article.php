<?php
namespace app\api\controller\v2;
use app\api\model\User as UserModel;
use app\api\model\Profile as UserProfile;
use app\api\model\Tokens as UserTokens;

use think\Request;
use think\Controller;
use think\Validate;
/**
 * Class Article
 * @author 王福宗 <wfz123@126.com>
 *
 */

class Article extends Controller
{
	public function index(){
		return json(array('info'=>"index"));
	}
	public function create(){
		return json(array('info'=>"create"));
	}
	public function save(){
		return json(array('info'=>"save"));
	}
	public function read(){
		return json(array('info'=>"read"));
	}
	public function edit(){
		return json(array('info'=>"edit"));
	}
	public function update(){
		return json(array('info'=>"update"));
	}
	public function delete(){
		return json(array('info'=>"delete"));
	}
}

/*
标识	请求类型	生成路由规则	对应操作方法（默认）	描述
index	GET			blogs			index		显示博客列表
create	GET			blogs/create	create		新增博客页面
save	POST		blogs			save		保存博客内容
read	GET			blogs/:id		read		查看博客内容
edit	GET			blogs/:id/edit	edit		编辑博客页面
update	PUT			blogs/:id		update		更新博客内容
delete	DELETE		blogs/:id		delete		删除博客
*/