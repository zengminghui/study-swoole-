<?php
/**
 * Version 4.4.16
 */
//监听地址 监听端口
$server = new Swoole\Server("127.0.0.1", 9502);
//设置属性
$server->set(array(

));
//监听连接进入事件
$server->on('Connect', function($server, $fd){
    echo "connet ok---客户端的fd".$fd.PHP_EOL;
});
//监听数据接收事件
$server->on('Receive', function($server, $fd, $from_id, $data){
    sleep(2);
    echo $data;
    $server->send($fd, '收到111111'.PHP_EOL);
});
//监听连接关闭事件
$server->on('Close', function($server, $fd){
    echo "客户端关闭连接----". $fd.PHP_EOL;
});
//启动服务
$server->start();