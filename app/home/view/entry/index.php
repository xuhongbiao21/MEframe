<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
<body>
<div style="width: 1000px;margin: auto;">
    <h1 style="text-align: center">欢迎来到admin</h1>
    <table  class="table table-bordered table-hover">
        <tr>
            <td>aid</td>
            <td>title</td>
            <td>click</td>
            <td>操作</td>
        </tr>
        <?php foreach ($arcData as $v) { ?>
            <tr>
                <td><?php echo $v['aid'] ?></td>
                <td><?php echo $v['title'] ?></td>
                <td><?php echo $v['click'] ?></td>
                <td>
                    <a href="?s=home/entry/update&aid=<?php echo $v['aid'] ?>">编辑</a>
                    <a href="?s=home/entry/remove&aid=<?php echo $v['aid'] ?>">删除</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div  style="margin-left: 700px;position:fixed;top: 340px;left: 200px">
    <img src="?s=home/entry/captcha" alt="" onclick="this.src=this.src+'&='+ Math.random()">
    <p style="text-align: center">点击验证码刷新</p>
    </div>
    <br>
    <form action="" method="post">
        <!--    新添加的数据-->
        用户名：<input type="text" name="title" class="form-control">
        click：<input type="text" name="click" class="form-control">
        验证码：<input type="text" name="captcha" class="form-control" style="width: 300px">
        <br>
        <br>
        <input type="submit" class="btn-success btn-lg">
    </form>
<!--    --><?php //p($_POST)?>
</div>
</body>
</html>