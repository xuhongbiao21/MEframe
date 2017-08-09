<?php
/**
 * Created by PhpStorm.
 * User: TCKJ
 * Date: 2017/7/30
 * Time: 20:24
 */
namespace houdunwang\view;
//定义命名空间 autoload 会自动引入文件
class View//自动引入静态函数类
{
//__callStatic 当调用的静态方法不存在，会自动调用__callStatic方法
    public static function __callStatic($name, $arguments)//定义一个静态自动引入函数
    {
        //返回当前对象到Boot 实体化[Base(),执行里面的方法],传值
        return call_user_func_array([new Base(), $name], $arguments);

    }

}