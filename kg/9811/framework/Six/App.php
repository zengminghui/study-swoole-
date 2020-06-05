<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/6/25
 * Time: 20:19
 */

namespace Six;

use App\Api\Controller\IndexController;
use App\Api\Controller\TestController;
use Six\Core\Bean\BeanFactory;
use Six\Core\Http;
use Six\Core\Route\Annotation\Mapping\RequestMapping;
use Six\Core\Route\Annotation\Parser\RequestMappingParser;
use Six\Core\Rpc\Rpc;

class App
{
    protected  $beanFile='Bean.php';
    public function run($argv)
    {
        try{
            $this->init();
            switch($argv[1]){
                case 'http:start':
                    (new Http())->run();
                    break;
                case 'rpc:start':
                    (new Rpc())->run();
                    break;
            }
        }catch (\Exception $e){
            echo "FILE:".$e->getFile()."  Line:".$e->getLine()."  Message:".$e->getMessage().PHP_EOL;
        }catch (\Throwable $t){
            echo "FILE:".$t->getFile()."  Line:".$t->getLine()."  Message:".$t->getMessage().PHP_EOL;
        }
    }
    public function init()
    {
        define('ROOT_PATH', dirname(dirname(__DIR__))); //根目录
        define('APP_PATH', ROOT_PATH . '/application');
        define('CONFIG_PATH', ROOT_PATH . '/config');
        //程序初始化时载入对象到容器当中
        $bean=require  APP_PATH.'/'.$this->beanFile;
        foreach ($bean as $k=>$v){
            BeanFactory::set($k,$v);
        }
    }
}