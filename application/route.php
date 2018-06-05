<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '__rest__' => [
    	'api/:version/user'=>'api/:version.User',
        'api/:version/tokens'=>'api/:version.Tokens',
        'api/:version/category'=>'api/:version.Category',
        'api/:version/article'=>'api/:version.Article',
        'api/:version/uploads'=>'api/:version.Uploads'
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];

/*
作用				传统模式					REST模式
列举出所有的用户	GET /users/list				GET /users
列出ID为1的用户信息	GET /users/show/id/1		GET /users/1
插入一个新的用户	POST /users/add				POST /users
更新ID为1的用户信息	POST /users/update/id/1		PUT /users/1
删除ID为1的用户		POST /users/delete/id/1		DELETE /users/1


标识	请求类型	生成路由规则	对应操作方法（默认）	描述
index	GET			blogs			index					显示博客列表
create	GET			blogs/create	create					新增博客页面
save	POST		blogs			save					保存博客内容
read	GET			blogs/:id		read					查看博客内容
edit	GET			blogs/:id/edit	edit					编辑博客页面
update	PUT			blogs/:id		update					更新博客内容
delete	DELETE		blogs/:id		delete					删除博客
*/