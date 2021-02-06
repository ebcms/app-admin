<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$meta['title']??'后台管理系统'} - Powered by EBCMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.js" integrity="sha256-i/Jq6Tc8SbPMBrnvq/sOTfH81hW5emVa4OzZPqhcwtI=" crossorigin="anonymous"></script>
    <script>
        var M = {};
        $(function() {
            localStorage.setItem("toast", "{}");
            M.addToast = function(toast) {
                var html = "";
                html += '<div class="toast fade hide toast_' + toast.id + '" data-toastid="' + toast.id + '" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="' + toast.delay + '">';
                html += '<div class="toast-header">';
                html += toast.icon;
                html += '<strong class="mr-auto ml-1">' + toast.title + '</strong>';
                // html += '<small class="text-muted">2 seconds ago</small>';
                html += '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">';
                html += '<span aria-hidden="true">&times;</span>';
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom shadow-sm" style="z-index:2;">
        <a class="navbar-brand wb" href="http://www.ebcms.com/" target="_blank">EBCMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto d-block d-lg-none">
                {foreach $menus as $v}
                <li class="nav-item">
                    <a class="nav-link" href="{$v.url}" target="main">{$v.title}</a>
                </li>
                {/foreach}
            </ul>
            <span class="navbar-text d-none d-lg-block">
                好用的管理系统
            </span>
            <ul class="navbar-nav ml-auto">
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
            <div>
                <ul class="nav flex-column" id="leftnav">
                    {foreach $menus as $v}
                    <li class="nav-item">
                        <a class="nav-link text-truncate py-3 px-4 font-weight-bold text-secondary" href="{$v.url}" target="{$v['target']??'main'}">{if isset($v['icon']) && $v['icon']}<span class="mr-2">{$v['icon']}</span>{/if}{$v.title}{if strlen($v['badge'])}<span class="badge badge-danger badge-pill ml-1">{$v['badge']}</span>{/if}</a>
                    </li>
                    {/foreach}
                </ul>
            </div>
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