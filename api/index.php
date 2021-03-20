<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/dao/AccountDao.class.php';

// Register your class
Flight::register('accountDao', 'AccountDao');

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


Flight::route('/hello3', function(){
    echo 'hello world3!';
});


Flight::route('/hello5', function(){
    echo 'hello world5!';
});

Flight::start();

?>