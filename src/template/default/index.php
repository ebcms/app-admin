<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$meta['title']??'后台管理系统'} - Powered by EBCMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha256-djO3wMl9GeaC/u6K+ic4Uj/LKhRUSlUFcsruzS7v5ms=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha256-fh8VA992XMpeCZiRuU4xii75UIG6KvHrbUF8yIS/2/4=" crossorigin="anonymous"></script>
    <script>
        var M = {};
        $(function() {
            localStorage.setItem("toast", "{}");
            M.addToast = function(toast) {
                var html = "";
                html += '<div class="toast fade hide toast_' + toast.id + '" data-toastid="' + toast.id + '" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="' + toast.delay + '">';
                html += '<div class="toast-header">';
                html += toast.icon;
                html += '<strong class="mr-auto ml-1">' + toast.title + '</strong>';
                // html += '<small class="text-muted">2 seconds ago</small>';
                html += '<button type="button" class="ml-2 mb-1 btn-close" data-bs-dismiss="toast" aria-label="Close">';
                html += '</button>';
                html += '</div>';
                html += '<div class="toast-body">';
                html += toast.content;
                html += '</div>';
                html += '</div>';
                if ($("#toast_container").length < 1) {
                    $("body").append('<div style="position: absolute; top: 70px; right: 10px;min-height: 20px;max-width:300px;" id="toast_container"></div>');
                }
                $("#toast_container").append(html);
                $(".toast_" + toast.id).toast("show");
                $(".toast_" + toast.id).on('hidden.bs.toast', function() {
                    var toasts = JSON.parse(localStorage.getItem('toast') ? localStorage.getItem('toast') : '{}');
                    delete toasts[$(this).data('toastid')];
                    localStorage.setItem("toast", JSON.stringify(toasts));
                    $(this).remove();
                });
            }
            setInterval(function() {
                var toasts = JSON.parse(localStorage.getItem('toast') ? localStorage.getItem('toast') : '{}');
                $.each(toasts, function(key, item) {
                    if ($(".toast_" + item.id).length <= 0) {
                        M.addToast(item);
                    }
                });
            }, 300);
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-bottom shadow-sm" style="z-index:2;">
        <div class="container-fluid">
            <a class="navbar-brand wb" href="http://www.ebcms.com/" target="_blank">EBCMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav d-flex d-lg-none">
                    {foreach $menus as $v}
                    <li class="nav-item">
                        <a class="nav-link" href="{$v.url}" target="main">{$v.title}</a>
                    </li>
                    {/foreach}
                </ul>
                <span class="navbar-text me-auto d-none d-lg-flex">
                    好用的管理系统
                </span>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="{:$router->buildUrl('/')}" target="_blank">网站首页</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.ebcms.com" target="_blank">官方网站</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="changepwd">修改密码</a>
                    </li>
                    <li class="nav-item">
                        <script>
                            function clearcache() {
                                $.ajax({
                                    type: "POST",
                                    url: "{:$router->buildUrl('/ebcms/admin/clear-cache')}",
                                    dataType: "JSON",
                                    success: function(response) {
                                        alert(response.message);
                                        location.reload();
                                    },
                                    error: function(context) {
                                        alert(context.statusText);
                                    }
                                });
                            }
                        </script>
                        <a class="nav-link" href="javascript:clearcache();">清理缓存</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{:$router->buildUrl('/ebcms/admin/auth/logout')}">退出</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        $(function() {
            $("#changepwd").bind('click', function() {
                var password = prompt('请输入密码：');
                if (password) {
                    $.ajax({
                        type: "POST",
                        url: "{:$router->buildUrl('/ebcms/admin/auth/password')}",
                        data: {
                            password: password,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            alert(response.message);
                        },
                        error: function(context) {
                            alert(context.statusText);
                        }
                    });
                }
            });
            $(".navbar-nav li a").on("click", function() {
                if (!$(this).hasClass('dropdown-toggle')) {
                    $('.navbar-toggler').trigger('click');
                }
            });
        });
    </script>
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .main {
            overflow: hidden;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 57px;
        }

        .main .left {
            float: left;
            width: 200px;
            height: 100%;
            overflow: auto;
            border-right: 1px solid #eee;
        }

        .main .right {
            height: 100%;
            overflow: auto;
        }

        /*clear float.*/
        .main:after {
            content: "";
            height: 0;
            line-height: 0;
            display: block;
            visibility: hidden;
            clear: both;
        }
    </style>
    <div class="main">
        <div class="left d-none d-lg-block bg-light">
            <ul class="nav flex-column" id="leftnav">
                {foreach $menus as $v}
                <li class="nav-item">
                    <a class="nav-link text-truncate py-3 px-4 font-weight-bold text-secondary" href="{$v.url}" target="{$v['target']??'main'}">{if isset($v['icon']) && $v['icon']}<span class="me-2">{echo $v['icon']}</span>{/if}{$v.title}{if strlen($v['badge'])}<span class="badge badge-danger badge-pill ml-1">{$v['badge']}</span>{/if}</a>
                </li>
                {/foreach}
            </ul>
            <script>
                $("#leftnav > li").bind("click", function() {
                    $(this).addClass("cur").siblings().removeClass("cur");
                });
            </script>
            <style>
                #leftnav>li:hover {
                    background-color: #eaeaea;
                }

                #leftnav>.cur {
                    background-color: #eaeaea;
                }

                /*滚动条整体样式*/
                ::-webkit-scrollbar {
                    width: 5px;
                    height: 1px;
                }

                /*滚动条滑块*/
                ::-webkit-scrollbar-thumb {
                    border-radius: 5px;
                    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
                    background: #f5f5f5;
                }

                /*滚动条轨道*/
                ::-webkit-scrollbar-track {
                    box-shadow: inset 0 0 1px rgba(0, 0, 0, 0);
                    border-radius: 5px;
                    background: #fafafa;
                }
            </style>
        </div>
        <div class="right">
            <iframe src="{:$router->buildUrl('/ebcms/admin/index',['tpl'=>'main'])}" id="mainiframe" name="main" style="width:100%;height:100%;overflow:auto;display:block;" frameborder="0"></iframe>
        </div>
    </div>
</body>

</html>
