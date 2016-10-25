<?php if(!defined('SYSTEMPATH')) die('invalid request');

class Router{
    public static function any($route,$controller){
        if($route!=ROUTE){
            return;
        }
        if(is_callable($controller)){
            return $controller();
        }
        
        $arr=  explode('@', $controller);
        if(file_exists(APPPATH.$arr[0].'.php'))
        {
            //load general app
            require_once APPPATH.$arr[0].'.php';
        }
        else if(file_exists(MODULESPATH.$arr[0].'.php')){
            //load Modules(special app)
            require_once MODULESPATH.$arr[0].'.php';
        }
        else{
            die('invalid controller name');
        }
        $class=end(explode('/',$arr[0]));
        $obj=new $class();
        $method_name=$arr[1];
        if(!method_exists($obj, $method_name)){
            die('method not exist on '.$class);
        }
        global $Request;
        return $obj->$method_name($Request);
    }
}