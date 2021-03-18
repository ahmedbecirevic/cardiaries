<?php

require_once dirname(__FILE__) . "/BaseDao.class.php";

class CitiesDao extends BaseDao {
    public function __construct() {
        parent::__construct("cities");
    }

    public function get_all_cities() {
        return $this->query("SELECT * FROM cities", []);
    }
}