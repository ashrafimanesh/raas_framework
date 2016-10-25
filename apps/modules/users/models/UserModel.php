<?php
namespace apps\modules\users\models;

/**
 * Description of UserModel
 *
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 */
class UserModel extends mysqli_model{
    public static $tbl_name;
    public $id,$user_id,$firstname,$lastname,$username,$tusername;
    public $db;
    public function __construct() {
        parent::__construct();
        self::$tbl_name="tbl_users";
    }
    public static function make($infos,$obj=false){
        if(!$obj){
            $obj=new UserModel();
        }
        foreach($infos as $field=>$value){
            $obj->$field=$value;
        }
        return $obj;
    }
    
}
