<?php
/**
 * Created by: phpstorm
 * Author: danny
 * Date: 2020/6/3
 * Time: 16:02
 */
//Co\run(function(){
//    $chan = new Swoole\Coroutine\Channel(1);
//    Swoole\Coroutine::create(function () use ($chan) {
//        for($i = 0; $i < 100000; $i++) {
//            co::sleep(1.0);
//            $chan->push(['rand' => rand(1000, 9999), 'index' => $i]);
//            echo "$i\n";
//        }
//    });
//    Swoole\Coroutine::create(function () use ($chan) {
//        while(1) {
//            $data = $chan->pop();
//            var_dump($data);
//        }
//    });
//});

//$serv = new Swoole\Http\Server("0.0.0.0", 9503, SWOOLE_BASE);
//
//$serv->on('request', function ($req, $resp) {
//    $chan = new chan(2);
//    go(function () use ($chan) {
//        $cli = new Swoole\Coroutine\Http\Client('www.qq.com', 80);
//        $cli->set(['timeout' => 10]);
//        $cli->setHeaders([
//            'Host' => "www.qq.com",
//            "User-Agent" => 'Chrome/49.0.2587.3',
//            'Accept' => 'text/html,application/xhtml+xml,application/xml',
//            'Accept-Encoding' => 'gzip',
//        ]);
//        $ret = $cli->get('/');
//        $chan->push(['www.qq.com' => $cli->body]);
//    });
//
//    go(function () use ($chan) {
//        $cli = new Swoole\Coroutine\Http\Client('www.163.com', 80);
//        $cli->set(['timeout' => 10]);
//        $cli->setHeaders([
//            'Host' => "www.163.com",
//            "User-Agent" => 'Chrome/49.0.2587.3',
//            'Accept' => 'text/html,application/xhtml+xml,application/xml',
//            'Accept-Encoding' => 'gzip',
//        ]);
//        $ret = $cli->get('/');
//        $chan->push(['www.163.com' => $cli->body]);
//    });
//
//    $result = [];
//    for ($i = 0; $i < 2; $i++)
//    {
//        $result += $chan->pop();
//    }
//    $resp->end(json_encode($result));
//});
//$serv->start();
