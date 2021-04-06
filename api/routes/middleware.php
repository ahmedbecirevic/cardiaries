<?php
/* Filter based middleware
Flight::before('start', function (&$params, &$output) {
    if (Flight::request()->url == '/swagger') return TRUE;

    if (str_starts_with(Flight::request()->url, '/users/')) return TRUE;

    $header = getallheaders();
    $token = @$header['Authentication'];

    try {
        // Try to decode using the token fetched from headers
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ["HS256"]);
        Flight::set('user', $decoded);
        return TRUE;
    } catch (\Exception $th) {
        Flight::json(["message" => $th->getMessage()], 401);
        die;
    }
});*/

/**ROUTE BASED MIDDLEWARE */
Flight::route('*', function () {
    if (str_starts_with(Flight::request()->url, '/users/')) return TRUE;

    $header = getallheaders();
    $token = @$header['Authentication'];

    try {
        // Try to decode using the token fetched from headers
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", ["HS256"]);
        Flight::set('user', $decoded);
        return TRUE;
    } catch (\Exception $th) {
        Flight::json(["message" => $th->getMessage()], 401);
        die;
    }
});
