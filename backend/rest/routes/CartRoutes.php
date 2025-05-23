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
    Flight::authMiddleware()->authorize_role(Roles::USER);
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
    Flight::authMiddleware()->authorize_role(Roles::USER);
    Flight::cartService()->delete_from_cart_for_user($user_id, $product_id);
});

/**
 * @OA\Get(
 *     path="/cart/{user_id}",
 *     tags={"cart"},
 *     summary="Get all products in the user's cart",
 *     description="Retrieves all products currently added to a user's cart.",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of products in user's cart",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="product_id", type="integer", example=123),
 *                 @OA\Property(property="quantity", type="integer", example=2),
 *                 @OA\Property(property="product_name", type="string", example="Gold Necklace"),
 *                 @OA\Property(property="price_per_unit", type="number", format="float", example=150.00)
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /cart/@user_id', function($user_id) {
    Flight::authMiddleware()->authorize_role(Roles::USER);
    Flight::json(Flight::cartService()->get_all_cart_products_for_user($user_id));
});

/**
 * @OA\Post(
 *     path="/cart/add_generic",
 *     tags={"cart"},
 *     summary="Add a generic cart entry",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"user_id": 1, "product_id": 123, "quantity": 2}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Generic cart entry added successfully"
 *     )
 * )
 */
Flight::route('POST /cart/add_generic', function() {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::cartService()->add($data);
});

/**
 * @OA\Get(
 *     path="/cart/get_generic",
 *     tags={"cart"},
 *     summary="Get all generic cart entries",
 *     @OA\Response(
 *         response=200,
 *         description="List of all generic cart entries"
 *     )
 * )
 */
Flight::route('GET /cart/get_generic', function() {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::json(Flight::cartService()->get());
});

/**
 * @OA\Get(
 *     path="/cart/get_generic/{id}",
 *     tags={"cart"},
 *     summary="Get a specific generic cart entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the cart entry"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart entry found"
 *     )
 * )
 */
Flight::route('GET /cart/get_generic/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::json(Flight::cartService()->get_by_id($id));
});

/**
 * @OA\Put(
 *     path="/cart/update_generic/{id}",
 *     tags={"cart"},
 *     summary="Update a generic cart entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the cart entry to update"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"user_id": 1, "product_id": 123, "quantity": 3}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart entry updated successfully"
 *     )
 * )
 */
Flight::route('PUT /cart/update_generic/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::cartService()->update($data, $id);
});

/**
 * @OA\Delete(
 *     path="/cart/delete_generic/{id}",
 *     tags={"cart"},
 *     summary="Delete a generic cart entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the cart entry to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart entry deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /cart/delete_generic/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::cartService()->delete($id);
});
?>
