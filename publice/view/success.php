<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
	<style>
		body{
			background: #eee;
		}
	</style>
</head>
<body>
<!--定义外层div-->
<div class="jumbotron" style="text-align: center">
<!--    标题-->
    <h2 style="color: dodgerblue">我曾经跨过山和大海 也穿过人山人海</h2>
<!--    输出Entry里面的定义的msg-->
	<h1><?php echo $this->msg ?> (:</h1>
<!--    如果没有自动跳转，就让他点击自动跳转-->
	<p>
		如果没有跳转，请点击下面的按钮
	</p>
<!--    自动跳转按钮-->
	<p><a class="btn btn-info" href="javascript:<?php echo $this->url ?>;" role="button">跳转</a></p>
</div>
<!--自动跳转js-->
<script>
//    setTimeout定时器只执行一次
	setTimeout(function () {
        //跳转到Entry里面的定义的url
		<?php echo $this->url ?>
//        1秒后跳转
    },1000);
</script>
</body>
</html>