<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/8/17
 * Time: 14:31
 */

namespace Six\Core\Rpc;


use Six\Core\Bean\BeanFactory;

class Client
{
    protected $version = '1.0';

    public function __call($name, $arguments)
    {
        //先拦截
        if ($name == 'services') {
            $this->serviceName = $arguments[0];
            return $this;
        }
        if ($name == 'version') {
            $this->version = $arguments[0];
            return $this;
        }
        //获取服务的ip加端口
        $config=BeanFactory::get("Config")->get(ucfirst($this->serviceName."_".$this->version));
        //var_dump($this->serviceName."_".$this->version);
        if(!empty($config)){
            $this->ip=$config['host'];
            $this->port=$config['port'];
        }else{
            throw  new  \Exception("没有找到相应的服务,请核对配置");
        }

        //封装数据json_rpc编码协议
        $req = [
            "jsonrpc" => '2.0',
            "method" => sprintf("%s::%s::%s", $this->version, $this->serviceName, $name),
            'params' => $arguments[0]
        ];
        $data = json_encode($req);

        //发送请求
        $client = new \swoole\client(SWOOLE_SOCK_TCP);
        if (!$client->connect($this->ip, $this->port, -1)) {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send($data);
        return $client->recv();
    }
}