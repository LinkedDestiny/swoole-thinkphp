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

全局替换 `ThinkPHP/Library/Think` 目录下的所有`define`为`runkit_constant_redefine` (注意: 一些常量的define可以不修改)
修改`ThinkPHP/ThinkPHP.php`中的

```php
define('IS_CLI',PHP_SAPI=='cli'? 0   :   0);
```
为
```php
define('IS_CLI' , 0);
```
