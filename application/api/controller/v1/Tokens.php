<?php
namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\model\Profile as UserProfile;
use app\api\model\Tokens as UserTokens;

use think\Request;
use think\Controller;
use think\Validate;
/**
 * Class Token
 * @author 王福宗 <wfz123@126.com>
 *
 * @method void log($msg) static
 * @method void error($msg) static
 * @method void info($msg) static
 * @method void sql($msg) static
 * @method void notice($msg) static
 * @method void alert($msg) static
 */

class Tokens extends Controller
{
	public function index(){
	}

    /**
     * 登录验证
     * @access public
     * @param Array 	$request POST or GET 过来的用户登录信息
     * @return mixed 	验证通过返回token及用户信息，不通过返回错误信息
     */
    public function save(Request $request)
    {
		$data   = $request->param();

		//使用用户名 or 密码进行登录验证
		if(isset($data['accounts'])){
			$user = UserModel::get(['email' => $data['accounts'],'password' => md5($data['password'])]);
			if (!isset($user)) {
				$user = UserModel::get(['nickname' => $data['accounts'],'password' => md5($data['password'])]);
			}
		} else{
			return json(['error'=>'用户名或者mail不能为空']);
		}
		if (isset($user)) {
			$tokenInfo = UserTokens::generateToken($user);
			return json([
				'userinfo'=>$user,
				'token'=>$tokenInfo['token'],
				'expiration'=>$tokenInfo['expiration']
			]);
		} else {
			return json(['error'=>'用户名或者密码错误']);
		}
    }

    public function delete(Request $request)
    {
    	return json($request->param('id'));
    }

}


?>