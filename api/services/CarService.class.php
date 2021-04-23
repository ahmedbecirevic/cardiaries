<?php

require_once dirname(__FILE__) . '/BaseService.class.php';

require_once dirname(__FILE__) . '/../dao/CarDao.class.php';


class CarService extends BaseService
{

    public function __construct()
    {
        $this->dao = new CarDao();
    }

    public function get_car_by_vin($vin)
    {
        return $this->dao->get_car_by_vin($vin);
    }
}
