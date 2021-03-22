<?php



Flight::route('GET /accounts', function(){
    Flight::json(Flight::accountDao()->get_all(0, 10));
});

Flight::route('GET /accounts/@id', function($id){
    Flight::json(Flight::accountDao()->get_by_id($id));
});

Flight::route('POST /accounts', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::accountDao()->add($data));

});

//Route to update account table
Flight::route('PUT /accounts/@id', function($id){
    $request = Flight::request();
    $data = $request->data->getData();

    Flight::accountDao()->update($id, $data);

    Flight::json(Flight::accountDao()->get_by_id($id));
});