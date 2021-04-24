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
        //TODO this is not working most likely because of the parametre passing :vin needs quotes around
        return $this->query_unique("SELECT * FROM cars WHERE vin = :vin", ["vin" => $vin]);
    }
}
