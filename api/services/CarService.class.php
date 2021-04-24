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

    public function add($car)
    {
        try {
            $car = parent::add([
                "model_name" => $car['model_name'],
                "year_of_production" => $car['year_of_production'],
                "mileage" => $car['mileage'],
                "num_of_doors" => $car['num_of_doors'],
                "engine_power_kw" => $car['engine_power_kw'],
                "fuel" => $car['fuel'],
                "vin" => $car['vin'],
                "manufacturer" => $car['manufacturer'],
                "user_id" => 61
            ]);
        } catch (Exception $e) {
            if (str_contains($e->getMessage(), 'cars.uq_vin')) {
                throw new Exception("Car with the same VIN already exists!", 400, $e);
            } else {
                throw $e;
            }
        }
        return $car;
    }
}
