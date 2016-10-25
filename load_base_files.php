<?php

define('APPPATH',__DIR__.'/apps/');
define('SYSTEMPATH',__DIR__.'/core/');

/*
 * load system heplers
 */
require_once SYSTEMPATH.'helpers/system.php';
require_once SYSTEMPATH.'helpers/general.php';

/*
 * load system libraries
 */

/*
 * load system databases
 */
require_once SYSTEMPATH.'databases/active-record/init.php';

/*
 * load security class and input class
 */
require_once SYSTEMPATH.'libraries/lib_security.php';
global $lib_security;
$lib_security=new lib_security();

require_once SYSTEMPATH.'libraries/Request.php';
global $Request;
$Request=new Request();

//load router class
require_once SYSTEMPATH.'libraries/Router.php';


//load apps index.php
require_once APPPATH.'index.php';
