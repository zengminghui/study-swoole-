<?php
/**
 * Created by: phpstorm
 * Author: danny
 * Date: 2020/6/2
 * Time: 21:43
 */
//多个协程是并发执行的，因此不能使用类静态变量/全局变量保存协程上下文内容。使用局部变量是安全的，因为局部变量的值会自动保存在协程栈中，其他协程访问不到协程的局部变量。
//可以使用一个Context类来管理协程上下文，在Context类中，使用Coroutine::getUid获取了协程ID，然后隔离不同协程之间的全局变量
//协程退出时清理上下文数据
use Swoole\Coroutine;
use Swoole\Http\Server;
class Context
{
    protected static $pool = [];

    static function get($key)
    {
        $cid = Coroutine::getuid();
        if ($cid < 0)
        {
            return null;
        }
        if(isset(self::$pool[$cid][$key])){
            return self::$pool[$cid][$key];
        }
        return null;
    }

    static function put($key, $item)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            self::$pool[$cid][$key] = $item;
        }

    }

    static function delete($key = null)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            if($key){
                unset(self::$pool[$cid][$key]);
            }else{
                unset(self::$pool[$cid]);
            }
        }
    }
}
//示例代码 使用 curl http://127.0.0.1:9501/a & curl http://127.0.0.1:9501/b 可以测试出 使用类静态变量/全局变量保存协程上下文内容会出现逻辑错误，
//反之使用 Context 管理上下文 不会出现脏数据
//调用代码
$serv = new Server('0.0.0.0',9501);
//错误代码
$_array = [];
$serv->on("Request", function ($req, $resp){
    global $_array;
    //请求 /a（协程 1 ）
    if ($req->server['request_uri'] == '/a') {
        $_array['name'] = 'a';
        co::sleep(1.0);
        echo $_array['name'];
        $resp->end($_array['name']);
    }
    //请求 /b（协程 2 ）
    else {
        $_array['name'] = 'b';
        $resp->end();
    }
});
//正确代码
$serv->on("Request", function ($req, $resp) {
    if ($req->server['request_uri'] == '/a') {
        Context::put('name', 'a');
        co::sleep(1.0);
        echo Context::get('name');
        $resp->end(Context::get('name'));
        //退出协程时清理
        Context::delete('name');
    } else {
        Context::put('name', 'b');
        $resp->end();
        //退出协程时清理
        Context::delete();
    }
});