<?php

/**
 * @OA\Get(path="/user/post/{id}", tags={"posts"}, 
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of post"),
 *    @OA\Response(response="200", description="Fetch individual post")
 * )
 */
Flight::route('GET /user/post/@id', function ($id) {
    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Get(path="/user/posts", tags={"posts","users"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Response(response="200", description="Fetch user's posts")
 * )
 */
Flight::route('GET /user/posts', function () {
    Flight::json(Flight::postService()->get_posts_by_id(Flight::get('user')['id']));
});

/**
 * @OA\Get(path="/posts/{id}", tags={"posts"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of post"),
 *    @OA\Response(response="200", description="Fetch post by id")
 * )
 */
Flight::route('GET /posts/@id', function ($id) {
    Flight::json(Flight::postService()->get_posts_by_its_id($id));
});

/**
 * @OA\Get(path="/car/posts/{id}", tags={"posts"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of car"),
 *    @OA\Response(response="200", description="Fetch posts of a car")
 * )
 */
Flight::route('GET /car/posts/@id', function ($id) {
    Flight::json(Flight::postService()->get_posts_by_car_id($id));
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
 *    				@OA\Property(property="vin", required="true", type="string", example="4Y1SL65848Z411439", description="VIN of the car that you are posting about"),
 *    				@OA\Property(property="image_url", required="true", type="string", example="https://cardiaries-space.fra1.digitaloceanspaces.com/picture1.jpg", description="CDN URL of the image")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Post that has been added to the database.")
 * )
 * 
 */
Flight::route('POST /posts', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->addPostByVin($data, Flight::get('user')['id']));
});


/**
 * 
 * @OA\Post(path="/user/car/posts/{car_id}", tags={"posts","users","cars"}, security={{"ApiKeyAuth": {}}},
 *      @OA\Parameter(type="integer", in="path", name="car_id", default=1, description="ID of car"),
 *      @OA\RequestBody(
 *          description="Post fields",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="string", example="Writing about my car", description="Body of the post"),
 *    				@OA\Property(property="image_url", required="true", type="string", example="https://cardiaries-space.fra1.digitaloceanspaces.com/picture1.jpg", description="CDN URL of the image")
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Post saved to database!")
 * )
 * 
 */
Flight::route('POST /user/car/posts/@car_id', function ($car_id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->addPost($data, $car_id, Flight::get('user')['id']));
});

/**
 * @OA\Put(path="/posts/{id}", tags={"posts"}, security={{"ApiKeyAuth": {}}},
 *    @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *    @OA\RequestBody(
 *          description="Basic post inforamtion that's going to be updated!",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="string", example="Writing about my car", description="Body of the post"),
 *    				@OA\Property(property="image_url", required="true", type="string", example="https://cardiaries-space.fra1.digitaloceanspaces.com/picture1.jpg", description="CDN URL of the image")
 *              )
 *          )
 *      ),
 *    @OA\Response(response="200", description="Updated post based on id")
 * )
 */
//Route to update account table
Flight::route('PUT /posts/@id', function ($id) {
    $data = Flight::request()->data->getData();

    Flight::json(Flight::postService()->update($id, $data));
});