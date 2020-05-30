<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/30
 * Time: 22:05
 */
//http服务
$http = new Swoole\Http\Server("0.0.0.0", 9503);

//事件回调有2个参数分别是 $request对象 请求的相关数据，$response对象 可对请求作出响应数据
$http->on('request', function($request, $response){
    //使用 Chrome 浏览器访问服务器，会产生额外的一次请求，/favicon.ico，可以在代码中响应 404 错误。
    if($request->server['request_uri'] == '/favicon.ico' || $request->server['path_info'] == '/favicon.ico')
    {
        $response->status(404);
        $response->end();
        return;
    }

    var_dump($response,$request);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $html = '<h1>正在学习swoole的http服务'.rand(1000,10000).'</h1>';
    $response->end($html);
});
//应用程序可以根据 $request->server['request_uri'] 实现路由。如：http://127.0.0.1:9501/test/index/?a=1，代码中可以这样实现 URL 路由。
$http->on('request', function ($request, $response) {
    list($controller, $action) = explode('/', trim($request->server['request_uri'], '/'));
    //根据 $controller, $action 映射到不同的控制器类和方法
    (new $controller)->$action($request, $response);
});

//启动服务
$http->start();