<?php

$config['socket_type'] = 'tcp'; //`tcp` or `unix`
$config['socket'] = '/var/run/redis.sock'; // in case of `unix` socket type
$config['host'] = '115.28.240.188';
$config['password'] = NULL;
$config['port'] = 35050;
$config['timeout'] = 0;
$config['products_pv_timeout'] = 86400;// 秒

$redis['master'] = $config;


return $redis;