<?php

/**
 * 
 * @OA\Post(path="/register", tags={"users"},
 *      @OA\RequestBody(
 *          description="Basic user inforamtion!", required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="username", required="true", type="string", example="Your username", description="user256"),
 *    				@OA\Property(property="first_name", required="true", type="string", example="John", description="Your first name"),
 *    				@OA\Property(property="last_name", required="true", type="string", example="Doe", description="Your last name"),
 *    				@OA\Property(property="email", required="true", type="string", example="myEmail@gmail.com", description="Your email address"), 
 *    				@OA\Property(property="password", required="true", type="string", example="1234", description="Password") 
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
    header("Location: ".'//'.$_SERVER["SERVER_NAME"].str_replace("/api/index.php","/login.html",$_SERVER["SCRIPT_NAME"]));
    exit();
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
 * @OA\Post(path="/upload", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Upload file to DOSpaces", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="name",	description="Photo Name with file extension" ),
 *    				 @OA\Property(property="content", required="true", type="string", example="test",	description="Base64 encoded photo" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Upload file to CDN")
 * )
 */
Flight::route('POST /upload', function(){
    $data = Flight::request()->data->getData();
    $url = Flight::userService()->uploadImage($data['name'], $data['content']);
    Flight::json(["url" => $url]);
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
