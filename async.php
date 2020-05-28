<?php
//客户端异步案例
$clients = array();
$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC); //同步阻塞

if(!$client->connect('127.0.0.1', 9501, 0.5, 0))
{
    echo "Connect Server fail.errCode=".$client->errCode;
}
$client->send("异步客户端发送的\n");
$clients[$client->sock] = $client;
//$clients[] = $client;

while (!empty($clients))
{
    $write = $error = array();
    $read = array_values($clients);

    $n = swoole_client_select($read, $write, $error, 0.6);
    if ($n > 0)
    {
        foreach ($read as $index => $c)
        {
            echo "Recv #{$c->sock}: " . $c->recv() . "\n";
            //因为引用传参 所以直接unset($clients[$c->sock]), while条件就为false 退出循环
            unset($clients[$c->sock]);
            //关闭连接的2种方式
//            unset($clients[$index]);
//            $clients[$c->sock]->close();
        }
    }
}
