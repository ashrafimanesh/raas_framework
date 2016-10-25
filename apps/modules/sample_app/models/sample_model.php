<?php

class sample_model extends mysqli_model{
    public static $tbl_name;
    public $db;
    public function __construct() {
        parent::__construct();
        self::$tbl_name="sample_table";
    }
}