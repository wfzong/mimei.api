<?php
namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\model\Profile as UserProfile;
use app\api\model\Tokens as UserTokens;
use app\api\model\Article as ArticleModel;
use app\api\model\Category as CategoryModel;

use think\Request;
use think\Controller;
use think\Validate;
/**
 * Class Category
 * @author 王福宗 <wfz123@126.com>
 *
 */

class Category extends Controller
{
	/**
	* 显示资源列表
	*
	* @return \think\Response
	*/
	public function index(){
		$article = new ArticleModel;
		$category = new CategoryModel;

		$ca = $category->all();
		//$ca->articles;
		return json($ca);
		//return abort(404, '分类不存在');

	}
	public function create(){
		return json(array('info'=>"create"));
	}

	/**
	* 保存新建的资源
	*
	* @param  \think\Request  $request
	* @return \think\Response
	*/
    public function save(){
		return json(array('info'=>"save"));
	}

	/**
	* 显示指定的资源
	*
	* @param  int  $id
	* @return \think\Response
	*/
	public function read($id){
		return json(array('info'=>"read:$id"));
	}
	public function edit(){
		return json(array('info'=>"edit"));
	}

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id){
		return json(array('info'=>"update:$id"));
	}

	/**
	* 删除指定资源
	*
	* @param  int  $id
	* @return \think\Response
	*/
	public function delete($id){
		return json(array('info'=>"delete:$id"));
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