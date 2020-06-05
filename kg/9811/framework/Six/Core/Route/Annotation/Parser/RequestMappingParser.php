<?php

namespace Six\Core\Route\Annotation\Parser;

use Six\Core\Bean\BeanFactory;

class RequestMappingParser
{
    public function parse($annotation)
    {
        $routeInfo=[
            'routePath'=>$annotation->getRoute(),
            'handle' =>$annotation->getHandle()
        ];
        //\Six\Core\Route\Route::addRoute($annotation->getMethod(),$routeInfo); //添加路由
         BeanFactory::get('Route')::addRoute($annotation->getMethod(),$routeInfo);
    }
}
