<?php

require_once dirname(__FILE__)."/BaseDao.class.php";


class CarsDao extends BaseDao {
    public function __construct() {
        parent::__construct("cars");
    }

}
