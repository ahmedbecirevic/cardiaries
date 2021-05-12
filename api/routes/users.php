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
    Flight::json(Flight::jwt(Flight::userService()->confirm($token)));
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
    Flight::json(Flight::jwt(Flight::userService()->login(Flight::request()->data->getData())));
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
    Flight::json(Flight::jwt(Flight::userService()->reset(Flight::request()->data->getData())));
});


/**
 * @OA\Post( path="/upload", tags={"users"},
 *   description="Upload your image",
 *   @OA\RequestBody(required=true, description="Upload your image",
 *      @OA\MediaType(mediaType="multipart/form-data",
 *          @OA\Schema(
 *               @OA\Property(property="image", type="string", format="binary"),
 *          )
 *      )
 *   ),
 *   @OA\Response(response="200", description="Message that the image was uploaded successfuly")
 * )
 */
Flight::route('POST /upload', function () {
    $request = Flight::request()->files['image'];
    // $uploadDirectory = 'C:/Bitnami/wampstack-8.0.2-1/apache2/htdocs/cardiaries/api/files/';
    // move_uploaded_file($request['tmp_name'], $uploadDirectory . $request['name']);
    Flight::userService()->uploadImage($request['tmp_name']);
});

// /**
//  * @OA\Get(path="/user/car/posts", tags={"cars", "users", "posts"}, security={{"ApiKeyAuth": {}}},
//  *    @OA\Parameter(type="string", in="path", name="vin", default=1, description="VIN of the car"),
//  *    @OA\Response(response="200", description="Fetch user's car posts")
//  * )
//  */
// Flight::route('GET /user/car/posts', function () {
//     Flight::json(Flight::postService()->get_posts_by_car_id($car['id']));
//     Flight::json(Flight::carService()->get_cars_by_id(Flight::get('user')['id']));
// });
