##**swoole-thinkphp**
结合PHP的ThinkPHP框架和Swoole扩展的高性能PHP Web框架


##**描述**
底层使用Swoole内置的swoole_http_server提供服务
上层应用使用Yaf框架搭建

##**发起人**
Lancelot（李丹阳） from **LinkedDestiny**（**牵机工作室**）

##**使用说明**
打开终端
cd swoole-thinkphp
php server/server.php

打开浏览器，输入http://localhost:9501

##**使用说明**
因为目前还没有找到支持PATH_INFO的方法，因此URL_MODE使用了兼容模式。
在跳转到其他Controller时，需要指定Module，例如`__APP__/Home/Form/index/name/hello`,其中Home为Module名，Form为Controller名，index为方法名，name为get参数名，hello为参数值。

目前本人还没有进行大规模的适配性测试，此项目仅适用于功能测试，如用于线上环境造成严重后果别怪我没提醒你……

##**swoole版本**
swoole-1.7.8以上版本

##**ThinkPHP版本**
thinkphp-3.2.2
