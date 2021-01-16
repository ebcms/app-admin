<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{$meta['title']??'后台管理系统'} - Powered by EBCMS</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.js" integrity="sha256-i/Jq6Tc8SbPMBrnvq/sOTfH81hW5emVa4OzZPqhcwtI=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#captcha").trigger('click');
        });
    </script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="p-4 my-5 mx-auto border shadow-sm bg-white" style="max-width: 400px;">
            <h1 class="text-center my-4">登录</h1>
            <hr class="my-4">
            <form action="{:$router->buildUrl('/ebcms/admin/auth/login')}" method="POST">
                <div class="form-group">
                    <label>账户</label>
                    <input type="text" name="account" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <input type="password" name="password" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>验证码</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <input type="text" name="captcha" class="form-control" autocomplete="off" autocomplete="off" required>
                        <div class="input-group-append">
                            <img id="captcha" style="vertical-align: middle;cursor: pointer;" class="rounded-right" onclick="this.src = '<?php echo $router->buildUrl('/ebcms/admin/auth/captcha'); ?>?time=' + (new Date()).getTime();">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
            <div style="margin-top: 30px;font-size: .8em;color: gray;padding: 10px 0;text-align: right;">Powered By <a href="http://www.ebcms.com" target="_blank">ebcms</a></div>
        </div>
    </div>
</body>

</html>