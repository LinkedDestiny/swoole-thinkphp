<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
    public function index(){
    	$this->assign("SERVER" , $_SERVER );
    	$this->display("index");
    }

    public function form(){

        $this->assign("content" , $_POST );
        $this->display("form");
    }
}