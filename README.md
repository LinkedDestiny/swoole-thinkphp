##**swoole-thinkphp**
结合PHP的ThinkPHP框架和Swoole扩展的高性能PHP Web框架


##**描述**
底层使用Swoole内置的swoole_http_server提供服务
上层应用使用ThinkPHP框架搭建

##**发起人**
Lancelot（李丹阳） from **LinkedDestiny**（**牵机工作室**）

##**使用说明**
打开终端
cd swoole-thinkphp
php server/server.php

配置nginx代理

打开浏览器，访问nginx

目前本人还没有进行大规模的适配性测试，此项目仅适用于功能测试，如用于线上环境造成严重后果别怪我没提醒你……

##**swoole版本**
swoole-1.8.6以上版本

##**ThinkPHP版本**
thinkphp-3.2.2

## nginx配置
见conf目录

## 依赖

runkit扩展 >= 0.7.0

## ThinkPHP改造

注释`ThinkPHP/Library/Think/Think.class.php`的120行

全局替换 `ThinkPHP/Library/Think` 目录下的所有`define`为`runkit_constant_redefine` (注意: 一些常量的define可以不修改)<br>
修改`ThinkPHP/ThinkPHP.php`中的

```php
define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);
```
为
```php
define('IS_CLI' , 0);
```

修改`ThinkPHP/Library/Think/Controller.class.php`文件中的ajaxReturn方法:
```php
protected function ajaxReturn($data,$type='',$json_option=0) {
    if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
    switch (strtoupper($type)){
        case 'JSON' :
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($data,$json_option);
            return;
        case 'XML'  :
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            echo xml_encode($data);
            return;
        case 'JSONP':
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:application/json; charset=utf-8');
            $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
            echo $handler.'('.json_encode($data,$json_option).');';
            return;
        case 'EVAL' :
            // 返回可执行的js脚本
            header('Content-Type:text/html; charset=utf-8');
            echo($data);
            return;
        default     :
            // 用于扩展其他返回格式数据
            Hook::listen('ajax_return',$data);
    }
}
```

修改同一文件下`dispatchJump`方法,去掉末尾的exit

修改`ThinkPHP/Common/functions.php`文件中的`redirect`方法:
```php
function redirect($url, $time=0, $msg='') {
    //多行URL地址支持
    $url        = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        return;
    } else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        echo($str);
        return;
    }
}
```

> 注意: 以上函数修改完之后调用不再会终止流程,需要在调用后显示调用return起到返回作用

