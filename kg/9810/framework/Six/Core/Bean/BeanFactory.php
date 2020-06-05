<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/7/3
 * Time: 22:40
 */

namespace Six\Core\Bean;


class BeanFactory
{
    private static $container=[];

    public static function set(string $name,callable $func){
        self::$container[$name]=$func;
    }

    public static function get(string $name){
        if(isset(self::$container[$name])){
            return (self::$container[$name])(); //执行这个方法
        }
        return null;
    }
}