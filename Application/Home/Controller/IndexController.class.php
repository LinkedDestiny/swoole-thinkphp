<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {
    public function index(){
    	$this->display("index");
    }

    public function form(){
        $this->assign("content" , $_POST );
        $this->display("form");
    }
}
