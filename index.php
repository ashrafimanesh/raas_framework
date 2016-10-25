<?php
error_reporting(E_ALL);
ini_set('display_errors',true);
/*
 * load required system files
 */
require_once('load_base_files.php');
//=================== set ROUTE constant ======================
$dir=__DIR__;
$base_dir=ltrim(__DIR__,$_SERVER['DOCUMENT_ROOT']);
$route=ltrim(ltrim(trim($_SERVER['REQUEST_URI'],'/'),$base_dir),'index.php/');
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

trigger_error('Route not found',E_USER_ERROR);