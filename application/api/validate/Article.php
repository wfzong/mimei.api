<?php
namespace app\api\validate;

use think\Validate;

class Article extends Validate
{

    // 验证规则
    protected $rule = [
        'title'  =>  'require',
        'description' =>  'require',
        'content' =>  'require'
    ];
    protected $message  =   [
        'title.require' => '文章标题不能为空',
        'description.require'     => '文章描述不能为空',
        'content.require'    => '文章内容不能为空' 
    ];

    protected $scene = [
        'add'   =>  ['title','description','content'],
        'edit'  =>  ['title','description','content']
    ];



}
?>