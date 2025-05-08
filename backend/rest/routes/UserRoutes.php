<?php

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users (no pagination)",
 *     @OA\Response(
 *         response=200,
 *         description="List of users"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/users/{size}",
 *     tags={"users"},
 *     summary="Get all users with size",
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of users per page"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/users/{size}/{page}",
 *     tags={"users"},
 *     summary="Get all users with pagination",
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of users per page"
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Page number"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users"
 *     )
 * )
 */
Flight::route('GET /users(/@size(/@page))', function($size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::userService()->get_all_users($size, $page));
});

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Get a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the user"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User data"
 *     )
 * )
 */
Flight::route('GET /user/@id', function($id) {
    Flight::json(Flight::userService()->get_user_by_id($id));
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the user to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /user/@id', function($id) {
    Flight::userService()->delete_user($id);
});
?>
