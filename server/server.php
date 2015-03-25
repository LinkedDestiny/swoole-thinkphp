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
		$http = new swoole_http_server("127.0.0.1", 9501);

		$http->set(
			array(
				'worker_num' => 16,
				'daemonize' => false,
	            'max_request' => 10000,
	            'dispatch_mode' => 1
			)
		);

		$http->on('WorkerStart' , array( $this , 'onWorkerStart'));

		$http->on('request', function ($request, $response) {
			if( isset($request->server) ) {
				HttpServer::$server = $request->server;
				foreach ($request->server as $key => $value) {
					$_SERVER[ strtoupper($key) ] = $value;
				}
			}
			if( isset($request->header) ) {
				HttpServer::$header = $request->header;
			}
			if( isset($request->get) ) {
				HttpServer::$get = $request->get;
				foreach ($request->get as $key => $value) {
					$_GET[ $key ] = $value;
				}
			}
			if( isset($request->post) ) {
				HttpServer::$post = $request->post;
				foreach ($request->post as $key => $value) {
					$_POST[ $key ] = $value;
				}
			}

			$uri = explode( "?", $_SERVER['REQUEST_URI'] );
			$_SERVER["PATH_INFO"] = $uri[0];
			if( isset( $uri[1] ) ) {
				$_SERVER['QUERY_STRING'] = $uri[1];
			}

			ob_start();

			require_once './ThinkPHP/ThinkPHP.php';
			
		    $result = ob_get_contents();

		  	ob_end_clean();
		  	$response->end($result);
		});

		$http->start();
	}

	public function onWorkerStart() {
		define('APP_DEBUG',True);

		define('APP_PATH','./Application/');
	}

	public static function getInstance() {
		if (!self::$instance) {
            self::$instance = new HttpServer;
        }
        return self::$instance;
	}
}

HttpServer::getInstance();
