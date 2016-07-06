<?php

class HttpServer
{
	public static $instance;

	public $http;
	public static $get;
	public static $post;
	public static $header;
	public static $server;
	private $application;

	public function __construct() {
		$http = new swoole_http_server("0.0.0.0", 9501);

		$http->set(
			array(
				'worker_num' => 16,
				'daemonize' => 0,
	            'max_request' => 10000,
	            'dispatch_mode' => 1
			)
		);

		$http->on('WorkerStart' , array( $this , 'onWorkerStart'));

		$http->on('request', function ($request, $response) {
			if( isset($request->server) ) {
				foreach ($request->server as $key => $value) {
                    unset($_SERVER[ strtoupper($key) ]);
					$_SERVER[ strtoupper($key) ] = $value;
				}
			}
			if( isset($request->header) ) {
				foreach ($request->header as $key => $value) {
                    unset($_SERVER[ strtoupper($key) ]);
					$_SERVER[ strtoupper($key) ] = $value;
				}
			}
            unset($_GET);
			if( isset($request->get) ) {
				foreach ($request->get as $key => $value) {
					$_GET[ $key ] = $value;
				}
			}
            unset($_POST);
			if( isset($request->post) ) {
				foreach ($request->post as $key => $value) {
					$_POST[ $key ] = $value;
				}
			}
            unset($_COOKIE);
			if( isset($request->cookie) ) {
				foreach ($request->cookie as $key => $value) {
					$_COOKIE[ $key ] = $value;
				}
			}
            unset($_FILES);
			if( isset($request->files) ) {
				foreach ($request->files as $key => $value) {
					$_FILES[ $key ] = $value;
				}
			}
            /*
			$uri = explode( "?", $_SERVER['REQUEST_URI'] );
			$_SERVER["PATH_INFO"] = $uri[0];
			if( isset( $uri[1] ) ) {
				$_SERVER['QUERY_STRING'] = $uri[1];
			}*/
            $_SERVER["PATH_INFO"] = explode('/', $_SERVER["PATH_INFO"],3)[2];
            $_SERVER['argv'][1]=$_SERVER["PATH_INFO"];

			ob_start();

            // 记录加载文件时间
            G('loadTime');
            // 运行应用
            \Think\App::run();

		    $result = ob_get_contents();

		  	ob_end_clean();
		  	$response->end($result);
		});

		$http->start();
	}

	public function onWorkerStart() {
		define('APP_DEBUG',False);
        define('_PHP_FILE_','');
		define('APP_PATH',__DIR__.'/../Application/');
        require_once '../ThinkPHP/ThinkPHP.php';
	}

	public static function getInstance() {
		if (!self::$instance) {
            self::$instance = new HttpServer;
        }
        return self::$instance;
	}
}

HttpServer::getInstance();
