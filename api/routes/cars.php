<?php


// Flight::route('GET /cars', function () {
//     $offset = Flight::query('offset', 0);
//     $limit = Flight::query('limit', 10);
//     $search = Flight::query('search');
//     $order = Flight::query('order', "-id");


//     Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit, $order));
// });

Flight::route('GET /accounts', function () {
    Flight::json(Flight::carService()->get_all());
});



Flight::route('POST /cars', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->add($data));
});

//Route to update account table
// Flight::route('PUT /accounts/@id', function ($id) {
//     $data = Flight::request()->data->getData();

//     Flight::json(Flight::accountService()->update($id, $data));
// });
