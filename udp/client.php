<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/29
 * Time: 13:20
 */
$client = new Swoole\Client(SWOOLE_SOCK_UDP);

$client->sendto('127.0.0.1', 9502, '发送消息给UDP服务器!');

echo $client->recv();