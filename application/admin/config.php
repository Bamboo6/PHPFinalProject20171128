<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/10
 * Time: 12:21
 */
$root = request()->root();
define('__ROOT__',str_replace('/index.php','',$root));
return [
// 应用调试模式
    'app_debug'              => false,
    // 应用Trace
    'app_trace'              => false,
    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__PUBLIC__' => __ROOT__.'/static/admin',
        '__COMMON__' => __ROOT__.'/static/common'
    ],
];