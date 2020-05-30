<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/30
 * Time: 23:33
 */
//发送任务客户端
$client = new Swoole\Client(SWOOLE_SOCK_TCP);

if(!$client->connect('127.0.0.1', 9503, -1))
{
    //errCode 的值等于 Linux errno。可使用 socket_strerror 将错误码转为错误信息。
    echo '连接失败--'.socket_strerror($client->errCode);
}

$client->send('发送数据到异步任务队列');

echo $client->recv();

$client->close();