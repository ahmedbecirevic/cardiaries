<?php

/**
 * @OA\Get(path="/user/post/{id}", tags={"posts"}, 
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of post"),
 *    @OA\Response(response="200", description="Fetch individual user")
 * )
 */
Flight::route('GET /user/post/@id', function ($id) {
    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Get(path="/user/posts", tags={"posts","users"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Response(response="200", description="Fetch user's cars")
 * )
 */
Flight::route('GET /user/posts', function () {
    Flight::json(Flight::postService()->get_posts_by_id(Flight::get('user')['id']));
});

/**
 * 
 * @OA\Post(path="/posts", tags={"posts"}, security={{"ApiKeyAuth": {}}},
 *      @OA\RequestBody(
 *          description="Post fields",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="string", example="Writing about my car", description="Body of the post"),
 *    				@OA\Property(property="vin", required="true", type="string", example="4Y1SL65848Z411439", description="VIN of the car that you are posting about")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Account that has been added to the database with ID assigned")
 * )
 * 
 */
Flight::route('POST /posts', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->addPostByVin($data, Flight::get('user')['id']));
});


/**
 * 
 * @OA\Post(path="user/car/posts", tags={"posts","users","cars"}, security={{"ApiKeyAuth": {}}},
 *      @OA\RequestBody(
 *          description="Post fields",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="string", example="Writing about my car", description="Body of the post")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Account that has been added to the database with ID assigned")
 * )
 * 
 */
Flight::route('POST user/car/posts@car_id', function ($car_id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->addPost($data, Flight::get('user')['id']), $car_id);
});