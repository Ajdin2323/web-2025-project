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

/**
 * @OA\Post(
 *     path="/user/add_generic",
 *     tags={"users"},
 *     summary="Add a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "email": "user@example.com",
 *                 "name": "John Doe",
 *                 "password": "securepassword",
 *                 "is_admin": false
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User added successfully"
 *     )
 * )
 */
Flight::route('POST /user/add_generic', function() {
    $data = Flight::request()->data->getData();
    Flight::userService()->add($data);
});

/**
 * @OA\Put(
 *     path="/user/update_generic/{id}",
 *     tags={"users"},
 *     summary="Update user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "email": "newemail@example.com",
 *                 "name": "Jane Doe",
 *                 "password": "newsecurepassword",
 *                 "is_admin": true
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
Flight::route('PUT /user/update_generic/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::userService()->update($data, $id);
});

/**
 * @OA\Post(
 *     path="/user/register",
 *     tags={"auth"},
 *     summary="Register a new user",
 *     description="Registers a new user with first name, last name, email, and password.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "email", "password"},
 *             @OA\Property(property="first_name", type="string", example="John"),
 *             @OA\Property(property="last_name", type="string", example="Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="strongpassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registration successfull")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Email is not valid or already taken")
 *         )
 *     )
 * )
 */
Flight::route('POST /user/register', function() {
    $data = Flight::request()->data->getData();
    Flight::userService()->register($data);
});
?>
