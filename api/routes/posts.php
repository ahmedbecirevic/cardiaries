<?php

/**
 * @OA\Get(path="/posts/users/{id}", tags={"post"}, 
 *    @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of user"),
 *    @OA\Response(response="200", description="Fetch individual user")
 * )
 */
Flight::route('GET /posts/users/@id', function ($id) {
    Flight::json(Flight::userService()->get_by_id($id));
});
