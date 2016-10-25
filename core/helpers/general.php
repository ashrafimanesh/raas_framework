<?php
/**
 * convert en numbers to fa numbers
 * @param string $string
 * @return string
 */
function fa_number($string) {
    return str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹']
            , $string);
}

/**
 * check array keys has an array values or not
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 * @param type $arr
 * @return boolean
 */
function is_two_side($arr) {
    if (is_array($arr)) {
        foreach ($arr as $f => $v) {
            if (is_array($v)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

if (!function_exists("dd")) {
    /**
     * beautiful var_dump variables and die in end
     * @param type $v
     * @param type $v
     */
    function dd($v=null) {
        $func=function($v=null){
            echo '<pre>';
            var_dump($v);
            echo '</pre>';
        };
        for($i=0;$i<func_num_args();$i++){
            $func(func_get_arg($i));
        }
        die;
    }
}

/**
 * @param type $code
 * @param type $msg
 */
function error_403($code, $msg, $data = array(), $exit = FALSE) {
    $status["status"] = false;
    $status["code"] = $code;
    $status["data"] = $data;
    $status["msg"] = $msg;
    if (!$exit && config_item("is_same_server")) {
        return $status;
    }
    header('HTTP/1.1 403 Forbidden');
    echo json_encode($status);
    exit;
}

/**
 * return custom mt_rand characters
 * @param integer $length
 * @param string $chars
 * @return string
 */
//function my_mt_rand($length=8,$chars='QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890')
function my_mt_rand($length = 8, $chars = '1234567890') {
    $pass = '';
    while (strlen($pass) < $length) {
        $rand = mt_rand(0, strlen($chars) - 1);
        $rand1 = mt_rand(0, $rand);
        $rand2 = mt_rand($rand, strlen($chars) - 1);
        $rand = mt_rand($rand1, $rand2);
        $pass.=$chars[$rand];
    }
    return $pass;
}

if (!function_exists("obj2arr")) {

    function obj2arr($obj) {
        if (!is_object($obj)) {
            return $obj;
        }
        $tmp = clone($obj);
        $obj = array();
        foreach ($tmp as $k => $v) {
            if (is_object($v)) {
                $obj[$k] = obj2arr($v);
            } else {
                $obj[$k] = $v;
            }
        }
        return $obj;
    }

}

function unset_if_set(&$arr, $index) {
    if (isset($arr[$index])) {
        unset($arr[$index]);
    }
}

function dirToArray($dir,$invalid_dirs=array(".",".."),$recursive=false) {
  
   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,$invalid_dirs))
      {
         if ($recursive && is_dir($dir . '/' . $value))
         {
            $result[$value] = dirToArray($dir . '/' . $value,$invalid_dirs,$recursive);
         }
         else if(!is_dir($dir . '/' . $value))
         {
            $result[] = $value;
         }
      }
   }
   return $result;
} 