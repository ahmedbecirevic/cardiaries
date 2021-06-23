<?php

/**
 * @OA\Get(path="/car/{vin}", tags={"cars"}, 
 *    @OA\Parameter(type="string", in="path", name="vin", default=1, description="VIN of the car"),
 *    @OA\Response(response="200", description="Fetch individual car, globally accessible")
 * )
 */
Flight::route('GET /car/@vin', function ($vin) {
    // $car = Flight::carService()->get_car_by_vin($vin);
    // if (Flight::get('user')['id'] != $car['user_id']) {
    //     Flight::json([]);
    // } else {
    //     Flight::json($car);
    // }
    $car = Flight::carService()->get_car_by_vin($vin);
    unset($car['user_id']);
    Flight::json($car);
});

/**
 * @OA\Get(path="/car/name/{id}", tags={"cars"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Parameter(type="int", in="path", name="id", default=1, description="ID of the car"),
 *    @OA\Response(response="200", description="Fetch car by id")
 * )
 */
Flight::route('GET /car/name/@id', function ($id) {
    Flight::json(Flight::carService()->get_car($id));
});

/**
 * @OA\Get(path="/user/cars", tags={"cars", "users"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Response(response="200", description="Fetch logged in user's cars")
 * )
 */
Flight::route('GET /user/cars', function () {
    Flight::json(Flight::carService()->get_cars_by_id(Flight::get('user')['id']));
});

/**
 * 
 * @OA\Post(path="/cars", tags={"cars"}, security={{"ApiKeyAuth": {}}},
 *      @OA\RequestBody(
 *          description="Car information!",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="model_name", required="true", type="string", example="Golf", description="Car Model"),
 *    				@OA\Property(property="year_of_production", type="int", example="2019", description="Production year"), 
 *                  @OA\Property(property="mileage", type="int", example="70000", description="Car mileage"), 
 *                  @OA\Property(property="num_of_doors", type="int", example="3", description="Car door number"), 
 *                  @OA\Property(property="engine_power_kw", type="int", example="110", description="Power of the engine in kilowatts"), 
 *                  @OA\Property(property="fuel", required="true", type="string", example="diesel", description="Type of fuel the car takes in"),
 *                  @OA\Property(property="vin", required="true", type="string", example="4Y1SL65848Z411439", description="VIN number of the car"),
 *                  @OA\Property(property="manufacturer", required="true", type="string", example="Volkswagen", description="Carmanufacturer")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Account that has been added to the database with ID assigned")
 * )
 * 
 */
Flight::route('POST /cars', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->add($data));
});
