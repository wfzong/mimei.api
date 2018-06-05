<?php
namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\model\Profile as UserProfile;
use think\Request;
use think\Controller;
use think\Validate;

class User extends Controller {
    protected $errorInfo = "";

	public function index(){
        $user = new UserModel;
        $u = $user->find(1);
        $u->articles;
		return json($u);
	}

	public function create(){

    	return json(['info'=>'create']);

	}

    public function save(Request $request)
    {
    	$data = $request->param();
    	$data['password'] = md5($data['password']);
    	$user = new UserModel;


        $result = $this->validate($data,'User');//控制器验证 规则定义在app\api\validate;
    	if(true === $result) {
	    	$checkField = [
	    		'nickname'=>'此昵称已经存在，请更换昵称',
	    		'email'=>'此mail已经存在，请更换mail'
	    	];
	    	if($this->checkFieldRepeat($user,$data,$checkField)) {//验证数据库没有重复字段，插入数据
	    		if($user->data($data,true)->save()){
	    			$profile = new UserProfile;
/*	    			$profile->truename = $data['truename'];
	    			$profile->birthday = $data['birthday'];
	    			$profile->address = $data['address'];
*/	    			$user->profile()->save($data);

                    return json(['success'=>"yes"]);
	    		} else {

	    		}
	    	} else {
                return json(["error"=>"yes","info"=>$this->errorInfo]);

				//验证函数中会处理，这里不作处理
				
	    	}
    	} else {
    		//return abort(404, $user->getError());//验证不通过，返回错误信息
            return json(["error"=>"yes","info"=>$result]);
    	}

    }

	// 获取用户信息
    public function read($id = 0)
    {
        try {
            // 制造一个方法不存在的异常
            $user = UserModel::get($id, 'profile');
            if ($user) {
                return json($user);
            } else {
                return abort(404, '用户不存在');
            }
        } catch (\Exception $e) {
            // 捕获异常并转发为HTTP异常
            return abort(404, $e->getMessage());
        }
    }

    public function edit(){
    	return json(['info'=>'edit']);
    }

    public function update(){
    	return json(['info'=>'update']);
    }
    public function delete(){
    	return json(['info'=>'delete']);
    }


    /**
     * 检查特定字段在数据库中是否有重复
     * @access protected
     * @param object    $model 要返回的数据
     * @param Array 	$data 返回类型 JSON XML
     * @param Array   	$fields 要检查的字段名及错误提示
     * @return mixed
     */
    protected function checkFieldRepeat($model,$data,$fields)
    {
    	$repeatInfo = [];
    	foreach ($fields as $key => $value) 
    	{
    		if($model->where($key,$data[$key])->count() > 0)
    		{
    			array_push($repeatInfo, $value);
    		}
    	}
    	if(count($repeatInfo) > 0)
    	{
    		//return abort(200, implode(';',$repeatInfo));
            //echo json(["error"=>"yes","info"=>implode(';',$repeatInfo)]);
            $this->errorInfo = implode(';',$repeatInfo);
            return false;
            
    	} else {
    		return true;
    	}
    }

}

/*
标识	请求类型	生成路由规则	对应操作方法（默认）	描述
index	GET			blogs			index					显示博客列表
create	GET			blogs/create	create					新增博客页面
save	POST		blogs			save					保存博客内容
read	GET			blogs/:id		read					查看博客内容
edit	GET			blogs/:id/edit	edit					编辑博客页面
update	PUT			blogs/:id		update					更新博客内容
delete	DELETE		blogs/:id		delete					删除博客


200 OK - [GET]：服务器成功返回用户请求的数据，该操作是幂等的（Idempotent）。
201 CREATED - [POST/PUT/PATCH]：用户新建或修改数据成功。
202 Accepted - [*]：表示一个请求已经进入后台排队（异步任务）
204 NO CONTENT - [DELETE]：用户删除数据成功。
400 INVALID REQUEST - [POST/PUT/PATCH]：用户发出的请求有错误，服务器没有进行新建或修改数据的操作，该操作是幂等的。
401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。
422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。


***返回结果***
GET /collection：返回资源对象的列表（数组）
GET /collection/resource：返回单个资源对象
POST /collection：返回新生成的资源对象
PUT /collection/resource：返回完整的资源对象
PATCH /collection/resource：返回完整的资源对象
DELETE /collection/resource：返回一个空文档

*/

?>