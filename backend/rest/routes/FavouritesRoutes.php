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
?>