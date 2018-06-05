<?php
namespace app\api\validate;

use think\Validate;

class User extends Validate
{

    // 验证规则
    protected $rule = [
        'nickname'  =>  'require|max:25',
        'email' =>  'require|email',
    ];
    protected $message  =   [
        'nickname.require' => '昵称不能为空',
        'nickname.max'     => '昵称最多不能超过25个字符',
        'email.require'    => '邮箱不能为空',    
        'email.email'    => '邮箱格式错误了哦！',    
    ];

    protected $scene = [
        'add'   =>  ['nickname','email'],
        'edit'  =>  ['email'],
    ];



}
?>