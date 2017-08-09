<?php
/**
 * Created by PhpStorm.
 * User: TCKJ
 * Date: 2017/7/30
 * Time: 20:25
 */
namespace houdunwang\view;
//定义命名空间 autoload 会自动引入文件
class Base
{
    //保存分配变量的属性
    private $data = [];
    //模版的路径
    private $template;


//分配变量
    public function with($data){

        $this->data=$data;
        //1.返回当前的对象
        //（1）返给\houdunwang\view\View里面的__callStatic
        // (2)View里面的__callStatic再返回给\app\home\controller\Entry里面的index方法(View::make()-with())
        //(3)Entry里面的index方法又返回给\houdunwang\core\Boot里面的appRun方法，在appRun方法用了echo 输出这个对象
        //(3)引入模版的同时分配了变量

        //返回当前对象
        return $this;
    }


//组合路径
    public function make(){
        //拼出模版的路径
        $this->template= '../app/' . APP . '/view/' . CONTROLLER . '/' . ACTION . '.php';
        //1.返回当前对象，
        //(1)返给\houdunwang\view\View里面的__callStatic
        //(2)View里面的__callStatic再返回给\app\home\controller\Entry里面的index方法(View::make())
        //(3)Entry里面的index方法又返回给\houdunwang\core\Boot里面的appRun方法，在appRun方法用了echo 输出这个对象
        //2.为了触发__toString
        //返回当前对象
        return $this;
    }

    //载入模版
    //__toString() 方法是自动被调用的，是在直接输出对象引用时自动调用的
    public function __toString()//tostring必须返回字符串才可以使用

    {		//把键名变为变量名，键值变为变量值 相当于 $data = ['title'=>'我是文章标题'];
        extract($this->data);

        include $this->template;//引入当前的模版 $this->template模版路径//app/home/view/index.php

        //必须返回字符串，才能使用
        return'';
    }

}