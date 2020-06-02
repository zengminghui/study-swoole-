<?php
/**
 * Created by: phpstorm
 * Author: danny
 * Date: 2020/6/2
 * Time: 20:57
 */
//获取当前协程的父 ID。

//串联多个协程调用栈
go(function () {
    go(function () {
        $ptrace = Co::getBackTrace(Co::getPcid());
        echo Co::getCid(),'---pcid',Co::getPcid();
        // balababala
        var_dump(array_merge($ptrace, Co::getBackTrace(Co::getCid())));
    });
});