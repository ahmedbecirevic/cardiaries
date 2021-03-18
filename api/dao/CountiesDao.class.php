<?php

require_once dirname(__FILE__) . "/BaseDao.class.php";

class CountiesDao extends BaseDao {
    public function __construct() {
        parent::__construct("counties");
    }

    public function get_all_counties() {
        return $this->query("SELECT * FROM counties", []);
    }
}