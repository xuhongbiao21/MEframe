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

<div class="container" style="width: 1000px">
    <h1 style="text-align: center">修改页面</h1>
    <form action="" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="inputID" class="col-sm-2 control-label">标题:</label>
            <div class="col-sm-10">
                <input type="text" name="title" id="inputID" class="form-control" value="<?php echo $oldData['title'] ?>" title="" required="required">
            </div>
        </div>
        <div class="form-group">
            <label for="inputID" class="col-sm-2 control-label">点击次数:</label>
            <div class="col-sm-10">
                <input type="text" name="click" id="inputID" class="form-control" value="<?php echo $oldData['click'] ?>" title="" required="required">
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">修改</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>