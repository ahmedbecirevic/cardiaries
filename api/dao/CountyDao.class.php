<?php
require_once dirname(__FILE__) . "/BaseDao.class.php";

class CountyDao extends BaseDao {
    public function __construct() {
        parent::__construct("counties");
    } 
}