{include /common/header@ebcms/admin}
<div class="my-4 display-4">系统概览</div>
<hr>
<div>
    欢迎使用xxx系统。。，xxx系统是xxx开发的，如果什么exxx下，欢迎加qq群(xxxxxxxx)讨论，坚决抵制盗版系统，维护健康网络环境。
</div>
<div class="table-responsive">
    <div class="h4 my-3">系统信息</div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td style="width:120px;">系统版本</td>
                <td>EBCMS v{php echo json_decode(file_get_contents($app->getAppPath() . '/composer.json'), true)['version']}</td>
            </tr>
            <tr>
                <td>上传限制</td>
                <td>{:get_cfg_var('upload_max_filesize')}</td>
            </tr>
            <tr>
                <td>脚本超时</td>
                <td>{:get_cfg_var('max_execution_time')}秒</td>
            </tr>
            <tr>
                <td>服务器系统</td>
                <td>{:php_uname()}</td>
            </tr>
            <tr>
                <td>运行环境</td>
                <td>PHP v{:PHP_VERSION}&nbsp;&nbsp;{$_SERVER['SERVER_SOFTWARE']}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <div class="h4 my-3">安全提示</div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td style="width:120px;">调试模式</td>
                <td>网站正式上线后，建议关闭错误信息显示，开启模板编译缓存</td>
            </tr>
            <tr>
                <td>数据备份</td>
                <td>网站正式上线后，建议定期对系统重要数据进行备份</td>
            </tr>
            <tr>
                <td>文件安全</td>
                <td>网站正式上线后，建议只开启runtime、uploads的读写权限，其他文件和目录设置为只读</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <div class="h4 my-3">产品团队</div>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td style="width:120px;">总策划</td>
                <td>荷塘月色</td>
            </tr>
            <tr>
                <td>开发团队</td>
                <td>荷塘月色、鱼摆摆、请输入昵称等</td>
            </tr>
            <tr>
                <td>官方网址</td>
                <td><a href="http://www.ebcms.com" target="_blank">EBCMS官方网站</a></td>
            </tr>
            <tr>
                <td>QQ群</td>
                <td><span style="color:red;">457911526</span></td>
            </tr>
        </tbody>
    </table>
</div>
{include common/footer@ebcms/admin}