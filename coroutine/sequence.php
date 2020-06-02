<?php
/**
 * Created by: phpstorm
 * Author: danny
 * Date: 2020/6/2
 * Time: 20:23
 */
//测试嵌套协程的执行顺序
//执行顺序跟正常阻塞模式一样 都是从上而下执行，协程不同的地方是在遇到io阻塞时，会让出CPU让其他代码先执行或者其他协程先执行。
//直到IO阻塞的代码块返回数据，才继续执行，所以说是并行的。以下面代码为说明更好理解
go(function () {
    echo Co::getPcid(),'----1';
    go(function () {
        echo Co::getPcid(),'----2';
        go(function () {
            //此处代码sleep模拟遇见IO阻塞
            Co::sleep(0.005);
            //此协程因为上面IO阻塞了 所以让出了CPU 这里var_dump 需等待上面IO阻塞完成之后才会执行，
//            此处var_dump最后执行
            var_dump(Co::exists(Co::getPcid()),'---3'); // 1: true
        });
        //因为上面的协程被IO阻塞了 所以CPU就执行这里的程序
        go(function () {
            //同理 此处也遇见IO 所以此协程让出CPU
            Co::sleep(0.003);   //此处阻塞时长0.003比上面阻塞时间短 所以这里比上面阻塞的代码先执行
            var_dump(Co::exists(Co::getPcid()),'---4'); // 3: false
        });
        //此处的sleep代码被注释 没IO阻塞 所以var_dump 比上面的2个协程的var_dump先执行
//        Co::sleep(0.002);
        var_dump(Co::exists(Co::getPcid()),'---5'); // 2: false
    });
});
//按照上面标示的数字进行顺序输出的话就是 1 2 5 4 3
//如果不存在阻塞 先后输出顺序 12345
//官方解释：
//决定到底让 CPU 执行哪个协程的代码决断过程就是协程调度，Swoole 的调度策略又是怎么样的呢？
//首先，在执行某个协程代码的过程中发现这行代码遇到了 Co::sleep() 或者产生了网络 IO，例如 MySQL->query()，
//这肯定是一个耗时的过程，Swoole 就会把这个 Mysql 连接的 Fd 放到 EventLoop 中。