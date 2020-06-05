<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/6/25
 * Time: 20:21
 */

namespace App\Api\Controller;

/**
 * Class TestController
 * @Controller(prefix="/index")
 */
class IndexController
{
    /**
     * @RequestMapping(route="index")
     */
    public function index()
    {
        echo "控制器方法";
    }
}