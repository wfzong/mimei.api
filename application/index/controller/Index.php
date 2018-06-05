<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller {
    public function index()
    {
    	$apiInfo = [
    		'links' => [
    			'register' => '/api/v1/user/ POST',
    			'login' => '/api/v1/tokens/ POST',
    			'logout' => '/api/v1/tokens/$token DELETE'
    		]
    	];
        return json($apiInfo);
    }
}