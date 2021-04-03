<?php

/**
 * 
 * @OA\Post(path="/users/register", tags={"user"},
 *      @OA\RequestBody(
 *          description="Basic user inforamtion!", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="account", required="true", type="string", example="My Test Account", description="Account name"),
 *    				@OA\Property(property="username", required="true", type="string", example="Your username", description="user256"),
 *    				@OA\Property(property="first_name", required="true", type="string", example="John", description="Your first name"),
 *    				@OA\Property(property="last_name", required="true", type="string", example="Doe", description="Your last name"),
 *    				@OA\Property(property="email", required="true", type="string", example="myEmail@gmail.com", description="Your email address"), 
 *    				@OA\Property(property="password", required="true", type="string", example="12345678", description="Password") 
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Message that user has been created")
 * )
 * 
 */
Flight::route('POST /users/register', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->register($data));
});

Flight::route('GET /users/confirm/@token', function ($token) {
    Flight::userService()->confirm($token);
    Flight::json(["message" => "Your account has been activated"]);
});
