<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/7/18
 * Time: 19:26
 */

return [
    'http' => [
        'host' => '0.0.0.0',
        'port' => 9503,
        'rpcEnable'=>1, //启动rpc
        'setting'=>[
            'worker_num'=>3
        ]
    ],
    'rpc' => [
        'host' => '0.0.0.0',
        'port' => 8001,
        'setting'=>[
            'worker_num'=>3
        ]
    ],
];