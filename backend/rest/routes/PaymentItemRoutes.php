<?php

/**
 * @OA\Post(
 *     path="/paymentItem/add_generic",
 *     tags={"paymentItem"},
 *     summary="Add a new payment item",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "payment_id": 1,
 *                 "product_id": 123,
 *                 "quantity": 2,
 *                 "unit_price": 100,
 *                 "total_price": 200
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment item added successfully"
 *     )
 * )
 */
Flight::route('POST /paymentItem/add_generic', function() {
    $data = Flight::request()->data->getData();
    Flight::paymentItemService()->add($data);
});

/**
 * @OA\Get(
 *     path="/paymentItem/get_generic",
 *     tags={"paymentItem"},
 *     summary="Get all payment items",
 *     @OA\Response(
 *         response=200,
 *         description="List of all payment items"
 *     )
 * )
 */
Flight::route('GET /paymentItem/get_generic', function() {
    Flight::json(Flight::paymentItemService()->get());
});

/**
 * @OA\Get(
 *     path="/paymentItem/get_generic/{id}",
 *     tags={"paymentItem"},
 *     summary="Get a payment item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the payment item"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment item retrieved successfully"
 *     )
 * )
 */
Flight::route('GET /paymentItem/get_generic/@id', function($id) {
    Flight::json(Flight::paymentItemService()->get_by_id($id));
});

/**
 * @OA\Put(
 *     path="/paymentItem/update_generic/{id}",
 *     tags={"paymentItem"},
 *     summary="Update a payment item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the payment item to update"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "payment_id": 1,
 *                 "product_id": 123,
 *                 "quantity": 3,
 *                 "unit_price": 90,
 *                 "total_price": 270
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment item updated successfully"
 *     )
 * )
 */
Flight::route('PUT /paymentItem/update_generic/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::paymentItemService()->update($data, $id);
});

/**
 * @OA\Delete(
 *     path="/paymentItem/delete_generic/{id}",
 *     tags={"paymentItem"},
 *     summary="Delete a payment item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the payment item to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment item deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /paymentItem/delete_generic/@id', function($id) {
    Flight::paymentItemService()->delete($id);
});
?>
