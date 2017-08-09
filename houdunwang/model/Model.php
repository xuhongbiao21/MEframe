<?php

namespace houdunwang\model;
//定义命名空间 autoload 会自动引入文件
class Model
{//定义自动引入函数
    public static function __callStatic($name, $arguments)
    {
//        p($name);//get
        $className = get_called_class();//get_called_class():获取静态绑定后的类名；
//        p($className);//system\model\Arc
        $table = strtolower(ltrim(strrchr($className, '\\'), '\\'));
//        p($table);//arc
        //返回自己 实体化base（）base找get方法
        return call_user_func_array([new Base($table), $name], $arguments);
    }
}