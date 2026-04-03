<?php
// 加载 .env 环境配置
$env = parse_ini_file(get_theme_file_path('/.env'));
// 定义全局常量
define('endpoint',        $env['endpoint']);
define('accessKeyId',     $env['accessKeyId']);
define('secretAccessKey', $env['secretAccessKey']);

var_dump(endpoint, accessKeyId, secretAccessKey);
