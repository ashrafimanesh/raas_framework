<?php

/*
 * load required system files
 */
require_once('load_base_files.php');
//=================== set ROUTE constant ======================
$dir=__DIR__;
$base_dir=ltrim(__DIR__,$_SERVER['DOCUMENT_ROOT']);
$route=ltrim(ltrim($_SERVER['REQUEST_URI'],$base_dir),'index.php/');
if(!$route){
    $route='/';
}
else{
    $arr=explode('?',$route);
    $route=$arr[0];
}

define('ROUTE',$route);


//=========================================================

Router::any('route1', 'sample_app/controllers/sample_app@index');


Router::any('migrate', function(){
    require_once SYSTEMPATH.'databases/Migrate.php';
    Migrate::run();
});
