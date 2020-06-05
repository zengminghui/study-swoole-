<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/6/25
 * Time: 20:21
 */

namespace   App\ Admin \ Controller;

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
        echo "xxxx";
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