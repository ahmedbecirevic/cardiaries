<?php

/**
 * @OA\Get(path="/post/users/{id}", tags={"post"}, 
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of user"),
 *    @OA\Response(response="200", description="Fetch individual user")
 * )
 */
Flight::route('GET /user/posts/@id', function ($id) {
    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * 
 * @OA\Post(path="/user/post", tags={"post"}, security={{"ApiKeyAuth": {}}},
 *      @OA\RequestBody(
 *          description="Post fields",
 *          required=true,
 *          @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				@OA\Property(property="body", required="true", type="text", example="Writing about my car bla bla", description="Body of the post"),
 * 
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Account that has been added to the database with ID assigned")
 * )
 * 
 */
Flight::route('POST /accounts', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::postService()->add($data));
});
