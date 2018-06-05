<?php
namespace app\api\model;

use think\Model;
use think\Request;
use think\Cookie;

class Tokens extends Model
{
    /*
		根据用户信息，生成并返回token、设置cookie
	*/
    static function generateToken($userinfo, $expiration = 2592000)
    {
        /*
			iss: 该JWT的签发者
			sub: 该JWT所面向的用户
			aud: 接收该JWT的一方
			exp(expires): 什么时候过期，这里是一个Unix时间戳
			iat(issued at): 在什么时候签发的
		*/
        $header['alg'] = 'MD5';
        $header['typ'] = 'JWT';
        $header_str = base64_encode(serialize($header));
        
        $Payload['aud'] = "user";
        $Payload['exp'] = time()+$expiration;
        $Payload['iat'] = time();
        $Payload['iss'] = "WFZONG";
        $Payload['name'] = $userinfo['nickname'];
        $Payload['uid'] = $userinfo['id'];
        $Payload['type'] = $userinfo['type'];
        $Payload_str = base64_encode(serialize($Payload));

        $sign_str = md5($header_str.$Payload_str."WFZONG_secret");//生成秘钥；这个秘钥泄露出去了，网站就裸奔了

        $token_str = $header_str.".".$Payload_str.".".$sign_str;
        Cookie::set('think_token', $token_str, $expiration);

        return array("token"=>$token_str,"expiration"=>$expiration);
    }

    /*
		从url或者cookie中读取token字符串，验证并返回结果
	*/
    static function checkToken(Request $request)
    {
        $token_cook = Cookie::get('think_token');
        $token_req = $request->param('token');
        $token = $token_cook ? $token_cook : $token_req;//从参数或者cookie中接收token值


        if ($token) {
            try {//防止token被修改后，验证出错

                $jwt_info = explode(".", $token);

                $jwt_info['header'] = unserialize(base64_decode($jwt_info[0]));
                $jwt_info['Payload'] = unserialize(base64_decode($jwt_info[1]));

                $check_str = md5($jwt_info[0].$jwt_info[1].'WFZONG_secret');//通过 秘钥 验证

                if ($jwt_info['Payload']['exp'] < time()) {
                    return ['authorized'=>false,'info'=>'token 时间过期'];
                } elseif ($jwt_info[2] !=$check_str) {
                    return ['authorized'=>false,'info'=>'token 验证出错'];
                } else {
                    return ['authorized'=>true,'info'=>'token 验证通过','userinfo'=>$jwt_info['Payload']];
                }
            } catch (Exception $e) {
                return ['authorized'=>false,'info'=>'发生未知错误'];
            }
        } else {
            return ['authorized'=>false,'info'=>'未获取token值'];
        }
    }
}
