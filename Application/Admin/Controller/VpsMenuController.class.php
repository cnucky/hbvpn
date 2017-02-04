<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class VpsMenuController extends CommonController {
    
    public function vps(){
    	$this->display();
    }
    
    public function server(){
    	$this->display();
    }
    
    public function account(){
        $this->display();
    }
    
}