<?php

/**
 * Description of UserMessageModel
 *
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 */
class UserMessageModel  extends mysqli_model{
    public static $tbl_name;
    
    public function __construct() {
        parent::__construct();
        self::$tbl_name="tbl_user_messages";
        global $database_config;
        $this->db = db_mysqli::get_instance($database_config['database'], $database_config['host'], $database_config['user'], $database_config['pass']);
    }
    
}
