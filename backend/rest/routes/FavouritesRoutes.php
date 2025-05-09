<?php

/**
 * @OA\Post(
 *     path="/favourites",
 *     tags={"favourites"},
 *     summary="Add a product to user's favourites",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"user_id", "product_id"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="product_id", type="integer", example=42)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product added to favourites"
 *     )
 * )
 */
Flight::route('POST /favourites', function() {
    $data = Flight::request()->data->getData();
    Flight::favouritesService()->add_to_favourites_for_user($data);
});

/**
 * @OA\Delete(
 *     path="/favourites/{user_id}/{product_id}",
 *     tags={"favourites"},
 *     summary="Remove a product from user's favourites",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="User ID"
 *     ),
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Product ID"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product removed from favourites"
 *     )
 * )
 */
Flight::route('DELETE /favourites/@user_id/@product_id', function($user_id, $product_id) {
    Flight::favouritesService()->delete_from_favourites_for_user($user_id, $product_id);
});

/**
 * @OA\Get(
 *     path="/favourites/{user_id}",
 *     tags={"favourites"},
 *     summary="Get all favourite products for a user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="User ID"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of favourite products"
 *     )
 * )
 */
Flight::route('GET /favourites/@user_id', function($user_id) {
    Flight::json(Flight::favouritesService()->get_all_favourites_for_user($user_id));
});

/**
 * @OA\Post(
 *     path="/favourites/add_generic",
 *     tags={"favourites"},
 *     summary="Add a new favourite item",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"user_id": 1, "product_id": 123}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Favourite item added successfully"
 *     )
 * )
 */
Flight::route('POST /favourites/add_generic', function() {
    $data = Flight::request()->data->getData();
    Flight::favouritesService()->add($data);
});

/**
 * @OA\Get(
 *     path="/favourites/get_generic",
 *     tags={"favourites"},
 *     summary="Get all favourite entries",
 *     @OA\Response(
 *         response=200,
 *         description="List of all favourite entries"
 *     )
 * )
 */
Flight::route('GET /favourites/get_generic', function() {
    Flight::json(Flight::favouritesService()->get());
});

/**
 * @OA\Get(
 *     path="/favourites/get_generic/{id}",
 *     tags={"favourites"},
 *     summary="Get a favourite entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the favourite entry"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Favourite entry found"
 *     )
 * )
 */
Flight::route('GET /favourites/get_generic/@id', function($id) {
    Flight::json(Flight::favouritesService()->get_by_id($id));
});

/**
 * @OA\Put(
 *     path="/favourites/update_generic/{id}",
 *     tags={"favourites"},
 *     summary="Update a favourite entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the favourite entry to update"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"user_id": 1, "product_id": 456}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Favourite entry updated successfully"
 *     )
 * )
 */
Flight::route('PUT /favourites/update_generic/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::favouritesService()->update($data, $id);
});

/**
 * @OA\Delete(
 *     path="/favourites/delete_generic/{id}",
 *     tags={"favourites"},
 *     summary="Delete a favourite entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the favourite entry to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Favourite entry deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /favourites/delete_generic/@id', function($id) {
    Flight::favouritesService()->delete($id);
});
?>