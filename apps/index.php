<?php if(!defined('SYSTEMPATH') || !defined('APPPATH')) die('invalid request');

//load general apps configs
require_once APPPATH.'configs/databases.php';
require_once APPPATH.'configs/app.php';

global $app_configs;
//Projects path is directory for your special controllers
define("PROJECTSPATH",$app_configs['projects_path']);

//Modules path is directory for your general controllers for all sites
define("MODULESPATH",$app_configs['modules_path']);

