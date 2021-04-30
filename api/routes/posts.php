<?php

/**
 * @OA\Get(path="/user/post/{id}", tags={"posts"}, 
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of user"),
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
Flight::route('GET user/posts', function () {
    Flight::json(Flight::postService()->get_posts_by_id(Flight::get('user')['id']));
});

/**
 * 
 * @OA\Post(path="/post", tags={"posts"}, security={{"ApiKeyAuth": {}}},
 *      @OA\RequestBody(
 *          description="Post fields",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="string", example="Writing about my car", description="Body of the post"),
 * 
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Account that has been added to the database with ID assigned")
 * )
 * 
 */
Flight::route('POST /post', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->add($data));
});
