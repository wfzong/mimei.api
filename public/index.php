<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){ //**由于RESTful接口里没有响应options请求，这里统一处理
/*	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Headers: X-PINGOTHER, Content-Type");
	header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");
*/
    exit;
}

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 加载框架引导文件.wfzong
require __DIR__ . '/../ThinkPHP/start.php';
