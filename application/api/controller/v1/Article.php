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
 * Class Article
 * @author 王福宗 <wfz123@126.com>
 *
 */

class Article extends Controller
{
    /**
     * 返回文章资源列表
     * @access public
     * @param Request 	$request 根据参数过虑列表
	 *			$page 		null 	default 	1		默认第一页
	 *			$limit 		null 	default 	10		默认每页10条
	 *			$orderby	null 	default 	id 		默认按id排序 
	 *			$order 		null 	default 	desc 	默认排序规则desc
	 *			$query 		null 	default 	null 	按标题搜索，默认无
	 *			$status 	null 	default 	1 		默认只提取有效状态的文章
	 *			$token 		null 	default 	null 	默认不验证token，如果status为all，需验证
     * @return JSON
     */	
	public function index(Request $request){
		$article = new ArticleModel;
		$category = new CategoryModel;


		//获取当前页
		$page = intval($request->param("page"));
		$page = $page> 0 ? $page : 1;

		//每页条目
		$limit = intval($request->param("limit"));
		$limit = $limit> 0 ? $limit : 10;

		//获取排序字段
		if(in_array($request->param("orderby"), array("id","create_time","update_time"))){
			$orderby = $request->param("orderby");
		} else {
			$orderby = "id";
		}

		//获取排序规则
		if(in_array($request->param("order"), array("desc","asc"))){
			$order = $request->param("order");
		} else {
			$order = "desc";
		}

		$map=[];//初始化map
		//是否按 标题 搜索
		if($request->param("query")){
			$map['title'] = ['like','%'.$request->param("query").'%'];
		}
		if(in_array($request->param("artType"), array('normal','photos'))){
			$map['artType'] = $request->param("artType");
		}
		if(intval($request->param("recommend")) == 1){
			$map['recommend'] = 1;
		}

		if($request->param("status")=="all"){
			/*
				如果用户想获取所有状态的文章列表
				需要对用户的权限进行验证
				无权限的返回对应 错误信息

				这里暂时不限制
			*/
			unset($map['status']);//取出所有状态

			//return abort("500","没有权限");
		} else {
			$map['status'] = ['=',1];
		}


		if (intval($request->param("categories"))>0) {
			$catInfo = $category->find(intval($request->param("categories")));
			$artQueryHandle = $catInfo->articles();

		} else {
			$catInfo = null;
			$artQueryHandle = $article;
		}

		$artCount = $artQueryHandle->where($map)->count();

		//获取文章列表
		$article_list = $artQueryHandle->where($map)
			->page($page,$limit)
			->order("$orderby $order")
			->field(["id","title","description","imgShow","artType","create_time","update_time","status","user_id"])
			->select();
		foreach ($article_list as $a) {
			$a->categories;
			$a->user;
		}


		return json([
			'list'=>$article_list,
			'count'=>$artCount,
			'limit'=>$limit,
			'page'=>$page,
			'categoryInfo'=>$catInfo
		]);
		//return json($catInfo);

		
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
    public function save(Request $request){
    	$tokenC = new UserTokens;
    	$auth = $tokenC->checkToken($request);

    	if($auth['authorized'] and $auth['userinfo']['type'] == 2){//验证权限通过
    		

    		$article = new ArticleModel;
    		$user = new UserModel;

    		//$userinfo = $user->find($auth['userinfo']['uid']);

    		$artInfo['title'] = $request->param('title');
    		$artInfo['artType'] = $request->param('artType');
    		$artInfo['description'] = $request->param('description');
    		$artInfo['recommend'] = $request->param('recommend');
    		$artInfo['content'] = $request->param('content');
    		$artInfo['imgShow'] = $request->param('imgShow');
    		$artInfo['imgContent'] = $request->param('imgContent');
    		$artInfo['user_id'] = $auth['userinfo']['uid'];


    		$result = $this->validate($artInfo,'Article');
    		if($result === true) {
	    		if($article->save($artInfo)){

	    			foreach (json_decode($request->param("categories")) as $value) {
		    			$article->categories()->attach($value);//添加u关联分类类
		    		}

	    			return json(['authorized'=>true,'info'=>$article]);
	    		} else {
	    			echo "false";
	    		}
	    	} else {
	    		return json(['authorized'=>false,'info'=>$result]);
	    	}

    	} else {
    		return json($auth);
    	}
	}

	/**
	* 显示指定的资源
	*
	* @param  int  $id
	* @return \think\Response
	*/
	public function read($id){
		$article = new ArticleModel;
		$artInfo = $article->find($id);
		$artInfo->categories;
		$artInfo->user;
        if ($artInfo) {
            return json($artInfo);
        } else {
            return abort(404, '文章不存在');
        }

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
    	$tokenC = new UserTokens;
    	$auth = $tokenC->checkToken($request);

    	if($auth['authorized'] and $auth['userinfo']['type'] == 2){//验证权限通过
    		

    		$article = new ArticleModel;
    		$user = new UserModel;
    		$category = new CategoryModel;

    		$articleInfo = $article->find($id);

    		//$userinfo = $user->find($auth['userinfo']['uid']);

    		$artInfo['title'] = $request->param('title');
			//$artInfo['artType'] = $request->param('artType');
    		$artInfo['description'] = $request->param('description');
    		$artInfo['recommend'] = $request->param('recommend');
    		$artInfo['content'] = $request->param('content');
    		$artInfo['imgShow'] = $request->param('imgShow');
    		$artInfo['imgContent'] = $request->param('imgContent');
    		$artInfo['user_id'] = $auth['userinfo']['uid'];


    		$result = $this->validate($artInfo,'Article');
    		if($result === true) {
	    		$articleInfo->save($artInfo);


    			foreach ($articleInfo->categories as $key => $value) {
    				$articleInfo->categories()->detach($value->id);//删除原分类
    			}
    			foreach (json_decode($request->param("categories")) as $value) {
	    			$articleInfo->categories()->attach($value);//添加关联分类
	    		}

    			return json(['authorized'=>true,'info'=>$articleInfo]);
	    		
	    	} else {
	    		return json(['authorized'=>false,'info'=>$result]);
	    	}

    	} else {
    		return json($auth);
    	}
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