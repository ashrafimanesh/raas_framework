<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lib_input
 *
 * @author ashrafimanesh
 */
class Request {
    private $post;
    public $server;
    public function __construct() {
        $this->post = &$_POST;
        $this->server = &$_SERVER;
    }
    
    /**
     * @author ashrafimanesh
     * @param string $item
     * @param string $value
     */
    public function set_post($item,$value="")
    {
        if ($item){
            $_POST[$item] = $value;
        }
    }
    
    /**
     * @author ashrafimanesh
     * @param type $item
     */
    public function unset_post($item)
    {
        if ($item){
            unset($_POST[$item]);
        }
    }
    
    /**
     * 
     * @author Mohaa
     * @param type $in post key
     * @return mixed return false or array
     */
    
    public function post ($in=NULL,$xss_clean=false)
    {
        $tmp="";
        if (!$_POST)
        {
            return false;
        }
        if ($in==NULL){
            $tmp = $_POST;
        }else{
            if (isset($_POST[$in]))
            {
                if($xss_clean)
                {
                    global $lib_security;
                    $_POST[$in]=$lib_security->xss_clean($_POST[$in]);
                }
                $tmp = $_POST[$in]; 
            }
        }
        
        return $tmp;
    }
    
    public function get ($in=NULL,$xss_clean=false)
    {
        $tmp="";
        if (!$_GET)
        {
            return false;
        }
        if ($in==NULL){
            $tmp = $_GET;
        }else{
            if (isset($_GET[$in]))
            {
                if($xss_clean)
                {
                    global $lib_security;
                    $_GET[$in]=$lib_security->xss_clean($_GET[$in]);
                }
                $tmp = $_GET[$in]; 
            }
        }
        
        return $tmp;
    }
    
}
