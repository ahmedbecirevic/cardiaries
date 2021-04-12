<?php

/**
 * 
 * @OA\Post(path="/register", tags={"users"},
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
Flight::route('POST /register', function () {
    $data = Flight::request()->data->getData();
    Flight::userService()->register($data);
    Flight::json(["message" => "Conformation email has been sent. Please confirm your account!"]);
});


/**
 * @OA\Get(path="/confirm/{token}", tags={"users"},
 *    @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account!"),
 *    @OA\Response(response="200", description="Message after succesfull activation")
 * )
 */
Flight::route('GET /confirm/@token', function ($token) {
    Flight::userService()->confirm($token);
    Flight::json(["message" => "Your account has been activated!"]);
});



/**
 * 
 * @OA\Post(path="/login", tags={"users"},
 *      @OA\RequestBody(
 *          description="Login!", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="email", required="true", type="string", example="myEmail@gmail.com", description="Your email address"), 
 *    				@OA\Property(property="password", required="true", type="string", example="1234", description="Password") 
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Message that user has been created")
 * )
 * 
 */
Flight::route('POST /login', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->login($data));
});


/**
 * 
 * @OA\Post(path="/forgot", tags={"users"}, description="Send recovery URL to users email address",
 *      @OA\RequestBody(
 *          description="Email", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    		@OA\Schema(
 *    			@OA\Property(property="email", required="true", type="string", example="myEmail@gmail.com", description="Your email address"), 
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Message that recovery link has been sent")
 * )
 * 
 */
Flight::route('POST /forgot', function () {
    $data = Flight::request()->data->getData();
    Flight::userService()->forgot($data);
    Flight::json(["message" => "Recovery email has been sent!"]);
});


/**
 * 
 * @OA\Post(path="/reset", tags={"users"}, description="Reset user's password using recovery token",
 *      @OA\RequestBody(
 *          description="Email", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    			@OA\Property(property="token", required="true", type="string", example="i34hfr934fuir3i3", description="Recovery Token"), 
 *    			@OA\Property(property="password", required="true", type="string", example="1234", description="New password")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Message that user has changed his password")
 * )
 * 
 */
Flight::route('POST /reset', function () {
    $data = Flight::request()->data->getData();
    Flight::userService()->reset($data);
    Flight::json(["message" => "Your password has been changed!"]);
});
