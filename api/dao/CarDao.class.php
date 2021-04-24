<?php
require_once dirname(__FILE__) . "/BaseDao.class.php";

class CarDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("cars");
    }

    public function get_car_by_vin($vin)
    {
        return $this->query_unique("SELECT * FROM cars WHERE vin = :vin", ["vin" => $vin]);
    }
}
