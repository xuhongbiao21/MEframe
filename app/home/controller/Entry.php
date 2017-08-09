<?php
/**
 * Created by PhpStorm.
 * User: TCKJ
 * Date: 2017/7/30
 * Time: 18:29
 */
namespace app\home\controller;//定义命名空间 autoload 会自动引入文件
use houdunwang\view\View;//使用这个目录下的自动引入函数
use houdunwang\core\Controller;//使用这个类是为了继承 使用里面的方法
use houdunwang\model\Model;//model模版类 里面现在是数据库的类
use system\model\Arc;//使用文章表类
use system\model\Tag;//使用标签表类
use Gregwar\Captcha\CaptchaBuilder;//使用验证码类

class Entry extends Controller//继承工具类
{
    public function index()//定义的index方法 也就是主页面
    {
        //标签表数据
//		$tagData = Tag::get();
        //文章表数据
        $arcData = Arc::get();
//        p($arcData);

//        $oneData = Arc::find(2);
//		p($oneData);
        if (IS_POST) {//是否为post提交
            //判断验证码是否正确用post里面的captcha也就是验证码转为小写 和$_SESSION['phrase']对比
            if (strtolower($_POST['captcha']) != strtolower($_SESSION['phrase'])) {//判断眼炸恒
                //如果不对就弹出错误跳转到错误页面  继承了工具类 调用了里面的方法
                return $this->error('验证码错误');
            }
            //调用save添加方法会把post传入通过自动引入函数找到对应的方法 执行里面的数据
            Arc::save($_POST);
            //继承了工具类 调用了里面的添加和跳转方法
            return $this->success('添加成功')->setRedirect('index.php');
        }


//返回当前对象 通过自动引入函数 找到对应模版 同时分配变量
        return View::make()->with(compact('arcData'));
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // 删除

//删除方法
    public function remove()
    {
        //先通过Model自动找到where方法where实际上就是一个容器 用来存储值实际上就是aid={$_GET['aid']}之后条件满足调用密令自后删除
        Arc::where("aid={$_GET['aid']}")->destory();
        //返回当前对象到Model 继承了工具类 调用了里面的添加和跳转方法
        return $this->success('删除成功')->setRedirect('index.php');
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //定义修改方法
    public function update()
    {//找到要修改的那一条
        $aid = $_GET['aid'];
        if (IS_POST) {//是否为post提交
            Arc::where("aid={$aid}")->update($_POST);//输入条件自动找到Base（）里面update方法 传入参数
            //返回当前对象到Model 继承了工具类 调用了里面的添加和跳转方法
            return $this->success('修改成功')->setRedirect('index.php');
        }
        //找到当前的数据
//        Array
//        (
//            [0] => Array
//            (
//                [click] => 0
//            [aid] => 100
//            [title] => 的撒打算
//        )

//)
        $oldData = Arc::find($aid);//找到当前的数据
        //返回当前对象 view找到模版 同时分配变量
        return View::make()->with(compact('oldData'));
    }

    public function captcha()//验证码类
    {
        header('Content-type: image/jpeg');//定义画布头部
        $builder = new CaptchaBuilder();//实体化类 才能进行下一步操作
        $builder->build();//复制参数
        $builder->output();//复制参数
        //把值存入到session
        $_SESSION['phrase'] = $builder->getPhrase();//把验证码存到session 为了和添加数据的验证码做对比
    }

}