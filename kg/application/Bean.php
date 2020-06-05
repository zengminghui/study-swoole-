<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/7/3
 * Time: 22:40
 */
return [
    'Route'=>function(){
        return  \Six\Core\Route\Route::get_instance(); //单例
    },
    'Config'=>function(){
        return  \Six\Core\Config::get_instance(); //单例
    }
];