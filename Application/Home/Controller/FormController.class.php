<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller {
    public function index(){
        $this->assign("name" , $_GET['name']);
        $this->display("index");
    }
}