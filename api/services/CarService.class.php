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

    public function get_cars_by_id($id)
    {
        return $this->dao->get_cars_by_id($id);
    }

    public function get_car($car_id)
    {
        return $this->dao->get_car_by_its_id($car_id);
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
                "user_id" => Flight::get('user')['id']
            ]);
        } catch (Exception $e) {
            if (str_contains($e->getMessage(), 'cars.uq_vin')) {
                throw new Exception("Car with the same VIN already exists!", 400, $e);
            } else {
                throw new Exception($e->getMessage());
            }
        }
        return $car;
    }
}
