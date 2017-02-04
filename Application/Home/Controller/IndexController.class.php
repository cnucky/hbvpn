<?php
namespace Home\Controller;
use Home\Common\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
		$this->display();
    }
    public function free(){
        $this->display();
    }
    public function download(){
        $this->display();
    }
    public function login_manage(){
    	$this->display();
    }
}