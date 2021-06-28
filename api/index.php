<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/services/AccountService.class.php';
require_once dirname(__FILE__) . '/services/UserService.class.php';
require_once dirname(__FILE__) . '/services/CarService.class.php';
require_once dirname(__FILE__) . '/services/PostService.class.php';
require_once dirname(__FILE__) . '/clients/DOSpacesClient.class.php';

Flight::set('flight.log_errors', true);

/* Error handling for APIIII */
Flight::map('error', function (Exception $ex) {
    // Flight::halt($ex->getCode(), json_encode(["message" => $ex->getMessage()]));
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});

/* Utility function for reading query parameters from URL */
Flight::map('query', function ($name, $default_value = NULL) {
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;

    return urldecode($query_param);
});

Flight::map('header', function ($name) {
    $headers = getallheaders();
    $token = @$headers[$name];
    return $token;
});

Flight::map('jwt', function ($user) {
    $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME), "id" => $user["id"], "r" => $user["role"]], Config::JWT_SECRET);
    return ["token" => $jwt];
});

Flight::route('GET /swagger', function () {
    $openapi = @\OpenApi\scan(dirname(__FILE__) . "/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

Flight::route('GET /', function () {
    Flight::redirect('/docs');
});

/* Register Business Logic Layer services */
Flight::register('accountService', 'AccountService');
Flight::register('userService', 'UserService');
Flight::register('carService', 'CarService');
Flight::register('postService', 'PostService');
Flight::register('spacesClient', 'DOSpacesClient');

/*Include all routes */
require_once dirname(__FILE__) . "/routes/middleware.php";
require_once dirname(__FILE__) . "/routes/accounts.php";
require_once dirname(__FILE__) . "/routes/users.php";
require_once dirname(__FILE__) . "/routes/cars.php";
require_once dirname(__FILE__) . "/routes/posts.php";

Flight::start();
