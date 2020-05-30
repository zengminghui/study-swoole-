<?php
/**
 * Created by: danny
 * Author: danny
 * Date: 2020/5/30
 * Time: 23:09
 */
//异步任务
$server = new Swoole\Server('0.0.0.0', 9503);

//设置异步任务的工作进程数量
$server->set(['task_worker_num'=>1]);

//接受客户端发来的数据并生成任务
$server->on('receive', function ($server, $fd, $from_id, $data) {
    //此回调函数在worker进程中执行
    //投递任务 非阻塞task，阻塞taskwait
    $taskid = $server->task($data);
    var_dump($taskid,$from_id,$fd);
    echo '已投递任务---ID'.$taskid.PHP_EOL;
    $server->send($fd,'任务分发成功');
});
echo '谁先执行'.PHP_EOL;

//异步处理任务
$server->on('task', function ($server, $taskid, $from_id, $data){
    //此回调函数在task进程中执行
    echo '创建异步任务id为-'.$taskid.PHP_EOL;
    $void = $server->finish("$data-> ok");

});

//处理异步任务的结果并返回
$server->on('finish', function($server, $taskid, $data){
    //此回调函数在worker进程中执行
    echo '异步任务ID为'.$taskid.'Finish:'.$data.PHP_EOL;
});

$server->start();
