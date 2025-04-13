<?php

/**
 * @OA\Post(
 *     path="/cart",
 *     tags={"cart"},
 *     summary="Add a product to the user's cart",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"user_id": 1, "product_id": 123, "quantity": 2}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product added to user's cart successfully"
 *     )
 * )
 */
Flight::route('POST /cart', function() {
    $data = Flight::request()->data->getData();
    Flight::cartService()->add_to_cart_for_user($data);
});

/**
 * @OA\Delete(
 *     path="/cart/{user_id}/{product_id}",
 *     tags={"cart"},
 *     summary="Remove a product from the user's cart",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the user"
 *     ),
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the product to remove"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product removed from user's cart successfully"
 *     )
 * )
 */
Flight::route('DELETE /cart/@user_id/@product_id', function($user_id, $product_id) {
    Flight::cartService()->delete_from_cart_for_user($user_id, $product_id);
});

/**
 * @OA\Get(
 *     path="/cart/{user_id}",
 *     tags={"cart"},
 *     summary="Get all products in a user's cart",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the user"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of products in the user's cart"
 *     )
 * )
 */
Flight::route('GET /cart/@user_id', function($user_id) {
    Flight::json(Flight::cartService()->get_all_cart_products_for_user($user_id));
});
?>
