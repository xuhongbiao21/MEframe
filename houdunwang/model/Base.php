<?php

namespace houdunwang\model;//定义命名空间 autoload 会自动引入文件
use PDO;//在当前目录下
use PDOException;//在当前目录下
class Base//数据库类
{

    private static $pdo = null;//保存PDO对象的静态属性 默认为空
    //保存表名属性
    private $table;
    //保存where
    private $where;

    public function __construct($table)//构造方法 自动连接数据库
    {
        $this->connect();//执行构造方法 会自动连接数据库
        $this->table = $table;//赋值操作 传入什么等于什么
    }


    //链接数据库
    private function connect()
    {
        //如果构造方法多次执行，那么此方法也会多次执行，用静态属性可以把对象保存起来不丢失，
        //第一次self::$pdo为null，那么就正常链接数据库
        //第二次self::$pdo已经保存了pdo对象，不为NULL了，这样不用再次链接mysql了。
        if (is_null(self::$pdo)) {//判断链接数据库 第一次为空 会链接 第二次 $pdo 已经不为空 就停止链接数据库 避免多次连接数据库
            try {//如果没有触发异常，则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
                //        mysql:host=数据库的主机地址 /dbname=use使用的数据库
                $dsn = 'mysql:host=' . c('database.db_host') . ';dbname=' . c('database.db_name');
                //实体化PDO/数据库的主机地址 /use使用的数据库/用户名/密码
                $pdo = new PDO($dsn, c('database.db_user'), c('database.db_password'));
                //设置为异常错误 只有异常错误 才会输出
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //设置数据库编码
                $pdo->exec("SET NAMES " . c('database.db_charset'));
                //把PDO对象放入到静态属性中
                self::$pdo = $pdo;
                //捕获异常错误
            } catch (PDOException $e) {
                //停止代码 显示出错误
                exit($e->getMessage());
            }
        }

    }


// 获取全部数据
    public function get()
    {
        //获得当前数据库下的所有数据 查询密令
        $sql = "SELECT * FROM {$this->table}";
        //执行密令查询mysql
        $result = self::$pdo->query($sql);
        //获得关联数组 方便使用
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
//返回当前对象 把数组返回到Model
        return $data;
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//添加
//添加函数
    public function save($post)
    {
        //查询当前表信息
        $tableInfo = $this->q("DESC {$this->table}");
        //获取字段需要用到的数组
        $tableFields = [];
        //获取当前表的字段 [title,click]
        foreach ($tableInfo as $info) {
            //$tableFields=当前的字段
            $tableFields[] = $info['Field'];
//            p($info);click，aid，title
        }

//        Array
//        (
//            [Field] => click
//            [Type] => smallint(6)
//        [Null] => YES
//        [Key] =>
//    [Default] =>
//    [Extra] =>
//)
//Array
//(
//    [Field] => aid
//    [Type] => smallint(6)
//        [Null] => NO
//        [Key] => PRI
//        [Default] =>
//    [Extra] => auto_increment
//)
//Array
//(
//    [Field] => title
//    [Type] => char(30)
//        [Null] => NO
//        [Key] =>
//    [Default] =>
//    [Extra] =>
//)

//        p($tableFields);
        //循环post提交过来的数据
//        Array
//        (
//             [0] => click
//             [1] => aid
//            [2] => title
//)
        //默认为空数组 下面过滤$post会用到
        $filterData = [];
        //循环$post里面的数据 键名=》对应键值
        foreach ($post as $f => $v) {
//            p($post);
//            Array
//            (
//                [title] => 单位
//                [click] => 我得
//            [captcha] => bj8df
//)
            //判断如果$post有属于当前表的字段，那么保留，否则就过滤掉
            if (in_array($f, $tableFields)) {
                //用filterData来接收$post数据 用post里面的键名也就是post里面的字段来和当前表的字段对比
                $filterData[$f] = $v;
            }
        }
//        p($filterData);
//        Array
//        (
//            [title] => 问
//            [click] => 二
//)

        //字段
        //获得所有数组里面的键名 也就是字段
        $field = array_keys($filterData);
        //把数组元素组合为字符串：
        $field = implode(',', $field);
        //获得里面的值
        $values = array_values($filterData);
//p($values);
//        Array
//        (
//            [0] => 多少
//            [1] => 多少
//)//转换为字符串 自后整理成可用格式 类始于代码合法化
        $values = '"' . implode('","', $values) . '"';
//        p($values);"多少","多少"
        //拼出密令
        $sql = "INSERT INTO {$this->table} ({$field}) VALUES ({$values})";
        //返回当前对象 进行没有结果集的操作 添加
        return $this->e($sql);
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// 单条数据
    public function find($id)
    {
        //现获得字段名
        $priKey = $this->getPriKey();
//p($priKey);//aid
        //aid/aid=
        //拼出密令
        $sql = "SELECT * FROM {$this->table} WHERE {$priKey}={$id}";
//echo $sql;//SELECT * FROM arc WHERE aid=1
        //执行有结果集的操作查询 调用密令
        $data = $this->q($sql);
//        p($data);
        //返回当前对象 到Molde 函数返回数组中的当前元素（单元）。
        return current($data);
    }


    //获得主键
    private function getPriKey()
    {
        //获得类型的密令
        $sql = "DESC {$this->table}";//查看数据库的类型
        $data = $this->q($sql);//调用密令 打印出desc
//        p($data);
        //主键默认为空 为遍历数组
        $primaryKey = '';

        //遍历数组 传入的数据就是desc查到的类型
        foreach ($data as $v) {
//            p($data);
            //查找里面的主键 如果有就证明存在 可以执行下一步
            if ($v['Key'] == 'PRI') {
                //找到主键
                $primaryKey = $v['Field'];
                //如果存在就跳出循环
                break;
            }
        }
//        p($primaryKey);
        //返回当前对象 到Model
        return $primaryKey;
    }

//Array
//(
//[0] => Array
//(
//[Field] => click
//[Type] => smallint(6)
//[Null] => YES
//[Key] =>
//[Default] =>
//[Extra] =>
//)
//
//[1] => Array
//(
//[Field] => aid
//[Type] => smallint(6)
//[Null] => NO
//[Key] => PRI
//[Default] =>
//[Extra] => auto_increment
//)
//
//[2] => Array
//(
//[Field] => title
//[Type] => char(30)
//[Null] => NO
//[Key] =>
//[Default] =>
//[Extra] =>
//)
//
//)

//////////////////////////////////////////////////////////////////////////////////////////
//删除


    //where条件
    //定义了一个容器函数
    public function where($where)
    {
        //where就等于传入的值就是一个容器 传入什么他就是什么 目的是为了判断用户传没传这个参数
        $this->where = $where;
//        返回当前对象到Model
        return $this;
    }

    //定义删除函数
    public function destory()
    {
        //判断where这个条件存不存在 如果不存在 会报错 所以 停止代码加警告
        if (!$this->where) {
            //停止代码 警告传入参数
            exit('delete必须有where条件');
        }
        //拼出mysql密令
        $sql = "DELETE FROM {$this->table} WHERE {$this->where}";
//        echo $sql;
        //返回当前对象到Model 执行没有结果集的操作删除
        return $this->e($sql);
    }
//////////////////////////////////////////////////////////////////////////////////////////////////
//修改
    //修改方法 $data=$_post
    public function update($data)
    {
        //先判断有没有条件 没有条件必须停止运行 否则会把所有的数据都会修改 谨慎处理
        if (!$this->where) {
            //阻挡用户必须传入要修改的id 否者后果很严重
            exit('update必须有where条件');
        }
        //Array
//		(
//			[title] => 标题,
//			[click] => 100,
//		)
        //定义空数组 便利数组会用到
        $set = '';
        //便利$post 键名和键值
        foreach ($data as $field => $value) {
            //p($field );//$set=title/click
            $set = "{$field}='{$value}',";
//            p($value);//是/0
        }
//        p($set);click='0',
//        rtrim从字符串右侧移除字符：
        $set = rtrim($set, ',');
//        p($set);
//        $set=click='0'
//                 arc/click='0'/$git['aid']/拼出密令
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->where}";
        //返回当前对象到Model 执行没有结果集的操作修改
        return $this->e($sql);
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//执行有结果集的操作
    public function q($sql)
    {
        try {//如果没有触发异常，则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
            //调用密令查询数据库
            $result = self::$pdo->query($sql);
            //返回当前的关联数组 到Model
            return $result->fetchAll(PDO::FETCH_ASSOC);
            //捕获异常错误
        } catch (PDOException $e) {
            //停止代码 显示出错误
            exit("SQL错误：" . $e->getMessage());
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//执行没有结果集的操作
    public function e($sql)
    {
        try {//如果没有触发异常，则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
            //执行没有结果集的操作
            $afRows = self::$pdo->exec($sql);
            //返回当前没有结果集的操作到Model
            return $afRows;
            //捕获异常错误
        } catch (PDOException $e) {
            //停止代码 显示出错误
            exit("SQL错误：" . $e->getMessage());
        }
    }
}