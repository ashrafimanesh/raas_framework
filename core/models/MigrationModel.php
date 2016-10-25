<?php

/**
 * Description of MigrationModel
 *
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 */
class MigrationModel extends mysqli_model{
    public static $tbl_name;
    public $db;
    public function __construct() {
        parent::__construct();
        self::$tbl_name="migrations";
    }
}
