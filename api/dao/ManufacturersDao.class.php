<?php


require_once dirname(__FILE__) . "/BaseDao.class.php";

class ManufacturersDao extends BaseDao {
    public function __construct() {
        parent::__construct("manufacturers");
    }

    public function get_all_manufacturers() {
        return $this->query("SELECT * FROM manufacturers", []);
    }

}