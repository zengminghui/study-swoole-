<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/29
 * Time: 14:17
 */
/** 协程客户端 */
//Co::set(['hook_flags' => SWOOLE_HOOK_TCP]);
Co\run(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9501, 0.5))
    {
        echo "connect failed. Error: {$client->errCode}\n";
    }
    $client->send("hello world\n");
    echo $client->recv(-1);
    $client->close();
});
