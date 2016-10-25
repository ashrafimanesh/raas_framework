<?php
/**
 * return global system config. 
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 * @global array $config
 * @param string $item
 * @return string
 */
function config_item($item) {
    global $config;
    $func=function($config,$item){
        return isset($config[$item]) ? $config[$item] : null; 
    };
    
    if(func_num_args()==1){
        return $func($config,$item);
    }
    else if(func_num_args()==2){
        return isset($config[func_get_arg(0)]) ? $func($config[func_get_arg(0)],func_get_arg(1)) : false;
    }
}

/**
 * load app controller
 * @author ashrafimanesh
 * @param strin $controller controller file name
 * @param string $app app folder name
 */
function load_app_controller($controller,$app="") {
    if(!$app){
        if (file_exists(APPPATH . "controllers/$controller.php")) {
            require_once APPPATH . "controllers/$controller.php";
        }
        else{
            die('file not exist: ' . APPPATH . "controllers/$controller.php");
        }
    }
    else if (file_exists(MODULESPATH. "$app/controllers/$controller.php")) {
        require_once MODULESPATH. "$app/controllers/$controller.php";
    } else {
        die('file not exist: ' . MODULESPATH . "$app/controllers/$controller.php");
    }
}

/**
 * load app model
 * @author ashrafimanesh
 * @param string $model model file name
 * @param string $app app folder name
 */
function load_app_model($model,$app="") {
    if (!$app) {
        if(file_exists(APPPATH . "models/$model.php")){
            require_once APPPATH . "models/$model.php";
        }
        else if (file_exists(SYSTEMPATH . "models/$model.php")) {
            require_once SYSTEMPATH . "models/$model.php";
        }
        else{
            die('file not exist: ' .APPPATH. "$app/models/$model.php");
        }
    }
    else if (file_exists(MODULESPATH. "$app/models/$model.php")) {
        require_once MODULESPATH. "$app/models/$model.php";
    }
    else {
        die('file not exist: ' .MODULESPATH. "$app/models/$model.php");
    }
}

/**
 * load app or system library
 * @param type $library
 * @param type $app
 */
function load_app_library($library,$app='')
{
    if(!$app)
    {
        if (file_exists(APPPATH . "libraries/$library.php")) {
            require_once APPPATH . "libraries/$library.php";
        } else {
            die('file not exist: ' .APPPATH. "libraries/$library.php");
        }
    }
    else if (file_exists(APPPATH . "$app/libraries/$library.php")) {
        require_once APPPATH . "$app/libraries/$library.php";
    } else {
        die('file not exist: ' .APPPATH. "$app/libraries/$library.php");
    }
}

function log_message2($text){
    
}
