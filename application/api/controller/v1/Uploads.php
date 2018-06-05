<?php
namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\model\Profile as UserProfile;
use app\api\model\Tokens as UserTokens;
use app\api\model\Uploads as UploadsModel;

use think\Request;
use think\Controller;
use think\Validate;
use think\Cookie;

$result = vendor('qiniu/autoload');
use Qiniu\Auth as qiniuAuth;

/**
 * Class Token
 * @author 王福宗 <wfz123@126.com>
 *
 */

class Uploads extends Controller
{
	public function index(){

		  // 用于签名的公钥和私钥
		$accessKey = 'VsMNtGXX_Ertwr96GV6HcI8RVBy2p6fjPiGEnVa9';
		$secretKey = 'lI9PySheEGCh6BHcn6QnLqtrso2rChZLab-E_e4I';
		  // 初始化签权对象
		$auth = new qiniuAuth($accessKey, $secretKey);
		$bucket = 'limpid';
		$expires = 3600;
/*		$policy = array(
			'callbackUrl' => 'http://api.limpid.local/api/v1/uploads/create/',
			'callbackBody' => '{"fname":"$(fname)", "fkey":"$(key)", "desc":"$(x:desc)", "uid":2}'
		);*/
		// 生成上传Token
		$token = $auth->uploadToken($bucket, null, $expires);
		Cookie::set('uploadToken', $token, $expires);
		return json(['uploadToken'=>$token,'expires'=>$expires]);
	}
	
	public function save(){
		
		$_body = file_get_contents('php://input');
		$body = json_decode($_body, true);
		echo $body;
		exit();
		$file['uid'] = $body['uid'];
		$file['fname'] = $body['fname'];
		$file['fkey'] = $body['fkey'];
		$file['description'] = $body['desc'];

		$upload = new UploadsModel;
		if($upload->save($file)){
			return json($upload);
		} else {
			echo "error";
		}




	}
	public function create(){


	}
}