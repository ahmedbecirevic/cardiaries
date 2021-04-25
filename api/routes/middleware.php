<?php

/**ROUTE BASED MIDDLEWARE */
Flight::route('/user/*', function () {
    try {
        // Try to decode using the flight function in index.php
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
        Flight::set('user', $user);
        return TRUE;
    } catch (\Exception $th) {
        Flight::json(["message" => $th->getMessage()], 401);
        die;
    }
});

Flight::route('/accounts/*', function () {
    try {
        // Try to decode using the flight function in index.php
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
        Flight::set('user', $user);
        return TRUE;
    } catch (\Exception $th) {
        Flight::json(["message" => $th->getMessage()], 401);
        die;
    }
});

Flight::route('/cars/*', function () {
    try {
        //TODO: add authentification only for POST /cars, GET /cars/@vin can be accessed by everyone
        // Try to decode using the flight function in index.php
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
        Flight::set('user', $user);
        return TRUE;
    } catch (\Exception $th) {
        Flight::json(["message" => $th->getMessage()], 401);
        die;
    }
});
