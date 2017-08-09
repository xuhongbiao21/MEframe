<?php
/**
 * Created by PhpStorm.
 * User: TCKJ
 * Date: 2017/7/30
 * Time: 20:46
 */
namespace houdunwang\core;//houdunwang\的核心目录
//定义命名空间 autoload 会自动引入文件
class Controller//工具类
{
    private $url = 'window.history.back()';//默认为回退 如果传值了就跳转到传的值得地址
    private $template;//模版位置
    private $msg;//传入的数据
    //$this->success('修改成功')


    protected function setRedirect($url)//跳转方法
    {
        //跳转到的地址
        //setRedirect('index.php');
        $this->url = "location.href='{$url}'";
        //返回当前对象 为了__toString()方法 返回到 Boot
        return $this;
    }


    protected function success($msg)//成功的时候
    {
        $this->msg = $msg;////$this->success('修改成功') $msg=修改成功
        $this->template = './view/success.php';//在成功的自动引入模版路径
        //返回当前对象 为了__toString()方法 返回到 Boot
        return $this;
    }


    protected function error($msg)//失败的时候
    {
        $this->msg = $msg;//$msg=修改失败
        $this->template = './view/error.php';//在失败的自动引入模版路径
        //返回当前对象 为了__toString()方法 返回到 Boot
        return $this;
    }
//__toString() 方法是自动被调用的，是在直接输出对象引用时自动调用的
    public function __toString()//自动引入方法//必须返回字符串 才可以使用

    {//自动引入模版 include'./view/success.php';
        include $this->template;
        //必须返回字符串 才可以使用 返回到 Boot
        return '';
    }
}