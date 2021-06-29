<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{$meta['title']??'后台管理系统'} - Powered by EBCMS</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha256-djO3wMl9GeaC/u6K+ic4Uj/LKhRUSlUFcsruzS7v5ms=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha256-fh8VA992XMpeCZiRuU4xii75UIG6KvHrbUF8yIS/2/4=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#captcha").trigger('click');
        });
    </script>
</head>

<body class="bg-light">
    <div style="max-width: 600px;margin: 0 auto;">
        <div class="my-3" style="font-size: 35px;">登录</div>
        <hr>
        <div class="p-4 my-5 mx-auto border shadow-sm bg-white" style="max-width: 400px;">
            <form action="{:$router->buildUrl('/ebcms/admin/auth/login')}" method="POST">
                <div class="mb-3">
                    <label class="form-label">账户</label>
                    <input type="text" name="account" class="form-control" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">密码</label>
                    <input type="password" name="password" class="form-control" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">验证码</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <input type="text" name="captcha" class="form-control" autocomplete="off" autocomplete="off" required>
                        <div class="input-group-append">
                            <img id="captcha" style="vertical-align: middle;cursor: pointer;height: 38px;" class="rounded-right" onclick="this.src = '<?php echo $router->buildUrl('/ebcms/admin/auth/captcha'); ?>?time=' + (new Date()).getTime();">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
        <div style="margin-top: 30px;font-size: .8em;color: gray;padding: 10px 0;text-align: right;">Powered By <a href="http://www.ebcms.com" target="_blank">EBCMS</a></div>
    </div>
</body>

</html>
