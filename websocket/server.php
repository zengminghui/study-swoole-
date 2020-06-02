<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/29
 * Time: 16:01
 */
//websocket 服务器端
$server = new Swoole\WebSocket\Server('0.0.0.0','9503');

//设置参数


//事件回调绑定，监听网络事件
//当 WebSocket 客户端与服务器建立连接并完成握手后会回调此函数。
$server->on('open', function (Swoole\WebSocket\Server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});

//监听消息
$server->on('message', function(Swoole\WebSocket\Server $server, $frame){
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    //获取所有用户fd值，可以用来广播或其他操作
    $fds = $server->connection_list();
    foreach ($fds as $fd)
    {
        $server->push($fd,$frame->data);
    }
    var_dump($fds);
    //向客户端推送消息
//    $server->push($frame->fd, "this is server");
    $timeid1 = Swoole\Timer::tick(1000, function() use(&$timeid1){
        var_dump(Swoole\Timer::clear($timeid1));
        var_dump($timeid1);

    });


});

//关闭事件
$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});
//在start事件回调中获取 master进程pid 和manager进程pid
$server->on('start', function($serv){
    var_dump($serv->master_pid, $serv->manager_pid);
});

//启动服务
$server->start();