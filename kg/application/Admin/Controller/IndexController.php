<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/6/25
 * Time: 20:21
 */

namespace   App\ Admin \ Controller;
use Six\Core\Rpc\Client;

/**
 * Class TestController
 * @Controller(prefix="/admin")
 */
class IndexController
{
    /**
     * @RequestMapping(route="index")
     */
    public function index()
    {
        $client=new Client();
        //分别从两台rpc的服务端获取服务信息
         $list=$client->services("ListService")->version("2.0")->info(["test"]);
         //$info=$client->services("InfoServices")->info(["test"]);
        return "Admin";
    }

    /**
     * @RequestMapping(route="test")
     */
    public function test()
    {
        return "test";
    }
}