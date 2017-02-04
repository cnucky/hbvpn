<?php
return array(
    
    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
        '/^user$/'=>array('Home/Index/login_manage',array('ext'=>'html')),
        '/^([a-z]+)$/'=>array('Home/Index/:1',array('ext'=>'html')),
    ),
);