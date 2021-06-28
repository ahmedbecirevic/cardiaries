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

    public function get_cars_by_id($id)
    {
        return $this->query("SELECT * FROM cars WHERE user_id = :id", ["id" => $id]);
    }

    public function get_car_by_its_id($id)
    {
        return $this->query_unique("SELECT * FROM cars WHERE id = :id", ["id" => $id]);
    }
}
