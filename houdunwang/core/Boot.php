<?php
namespace houdunwang\core;
//定义命名空间 autoload 会自动引入文件
class Boot//框架启动类
{
    public static function run()//框架驱动
    {
        self::init();//初始化框架

        self::appRun();//执行应用
    }

    public static function appRun()//执行应用

    {
        //判断git参数存不存在s,如果存在就转为小写之后执行，不存在s这个参数就执行默认home/entry/index；
        $s = isset($_GET['s']) ? strtolower($_GET['s']) : 'home/entry/index';
        //print_r($s);//home/entry/index
        //把字符串转换为数组格式 为了组合路径 以为调用控制器可能不一样所以得转为数组
        $arr = explode('/', $s);
        //print_r($arr);//Array ( [0] => home
                               // [1] => entry
                              // [2] => index
        // )
        define('APP',$arr[0]);//主目录 因为常量可以全局使用 view/Base/make()需要用来拼出路径 所以得定义常量；
        define('CONTROLLER',$arr[1]);//二级目录 因为常量可以全局使用 view/Base/make()需要用来拼出路径 所以得定义常量；
        define('ACTION',$arr[2]);//调用的文件名 因为常量可以全局使用 view/Base/make()需要用来拼出路径 所以得定义常量；
        //组合控制器路径
        //$className=app/home/controller/Entry
        $className = "\app\\{$arr[0]}\controller\\" . ucfirst($arr[1]);
//        print_r($className);
        //调用当前控制器 就实体化 在调用里面的方法
        //echo 是为了 调用__toString()方法 __toString() 方法是自动被调用的，是在直接输出对象引用时自动调用的
        echo call_user_func_array([new $className,$arr[2]],[]);
    }


    public static function init()//初始化框架
    {
        //开启session//为了判断验证码
        session_id() || session_start();
        //设置时区
        date_default_timezone_set('PRC');
        //定义是否POST提交的常量//用于form表单提交
        define('IS_POST',$_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    }
}