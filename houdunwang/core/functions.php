<?php
//p函数
function p($data){
    echo '<pre style="background:#cccccc;padding: 10px">';//原样输出pre标签
print_r($data);//print_r打印出数组

    echo '</pre>';//输出pre结束标签
}
//数据库
function c($path){
//    p($path);Array ( [0] => database [1] => db_name )
    //把传入的参数转为数组格式 因为每次调用不一样
    $arr = explode('.',$path);
//    p($arr);
//    Array
//    (
//        [0] => database
//        [1] => db_name
//)
       //引入当前的配置项
    $config = include '../system/config/' . $arr[0] . '.php';
//    p($config);它是一个数组
//    Array
//    (
//        [db_host] => 127.0.0.1
//    [db_user] => root
//    [db_password] => root
//    [db_name] => c83
//    [db_charset] => UTF8
//)
//返回到上一级 判断配置项里面的 传入参数纯不存在存在就执行 不存在 就赋值为null也就是空；
// //return isset //database[db_name]?database[db_name]:NULL;
    return isset($config[$arr[1]]) ? $config[$arr[1]] : NULL;
}