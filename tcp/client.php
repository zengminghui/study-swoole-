<?php
//客户端同步案例
/**
 * Swoole\Client->__construct(int $sock_type, int $is_sync = SWOOLE_SOCK_SYNC, string $key);
 * sock_type 表示 socket 的类型【支持 SWOOLE_SOCK_TCP、SWOOLE_SOCK_TCP6、SWOOLE_SOCK_UDP、SWOOLE_SOCK_UDP6】
 * is_sync 同步阻塞模式，现在只有这一个类型，保留此参数只为了兼容 api 默认值：SWOOLE_SOCK_SYNC
 * key 用于长连接的 Key【默认使用 IP:PORT 作为 key。相同的 keynew 两次也只用一个 TCP 连接】
 */
$client = new Swoole\Client(SWOOLE_SOCK_TCP);
/**
 * Swoole\Client->connect(string $host, int $port, float $timeout = 0.5, int $flag = 0): bool
 * $host 服务器地址【支持自动异步解析域名，$host 可直接传入域名】
 * $port 服务器端口
 * $timeout 设置超时时间 值单位: 秒【支持浮点型，如 1.5 表示 1s+500ms】 默认值：0.5
 * $flag 在 UDP 类型时表示是否启用 udp_connect 设定此选项后将绑定 $host 与 $port，此 UDP 将会丢弃非指定 host/port 的数据包。
 * 在 TCP 类型，$flag=1 表示设置为非阻塞 socket，之后此 fd 会变成异步 IO，connect 会立即返回。如果将 $flag 设置为 1，那么在 send/recv 前必须使用 swoole_client_select
 * 来检测是否完成了连接。
 * @return bool 成功返回 true 失败返回 false，请检查 errCode 属性获取失败原因
 */
if (!$client->connect('127.0.0.1', 9501, -1)) {
    exit("connect failed. Error: {$client->errCode}\n");
}
/**
 * Swoole\Client->send(string $data): int|false;
 * string $data 发送内容【支持二进制数据】
 * @return 成功发送，返回已发数据长度 失败返回 false，并设置 errCode 属性
 */
//$client->send("hello world\n");
$client->send("task\n");
/**
 * Swoole\Client->recv(int $size = 65535, int $flags = 0): string | false
 * $size 接收数据的缓存区最大长度【此参数不要设置过大，否则会占用较大内存】
 * $flags 可设置额外的参数【如 Client::MSG_WAITALL】, 具体哪些参数参考此节
 * @return 成功收到数据返回字符串  连接关闭返回空字符串 失败返回 false，并设置 $client->errCode 属性
 */
echo $client->recv();
/**
 * Swoole\Client->close(bool $force = false): bool
 * int $force 强制关闭连接【可用于关闭 SWOOLE_KEEP 长连接】
 * 当一个 swoole_client 连接被 close 后不要再次发起 connect。正确的做法是销毁当前的 Client，重新创建一个 Client 并发起新的连接。Client 对象在析构时会自动 close。
 */
$client->close();