<?php
/**
 * @OA\Post(
 *     path="/checkout/{user_id}",
 *     tags={"payment"},
 *     summary="Checkout a user's cart and create a payment",
 *     description="Processes all items in the user's cart into a payment, then clears the cart.",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment successfully created",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="payment_id", type="integer", example=101)
 *         )
 *     )
 * )
 */
Flight::route('POST /checkout/@user_id', function($user_id) {
    $payment_id = Flight::paymentService()->checkout_user($user_id);
    Flight::json(["payment_id" => $payment_id]);
});

/**
 * @OA\Get(
 *     path="/total_spent/{user_id}",
 *     tags={"payment"},
 *     summary="Get total amount spent by a user",
 *     description="Returns the total amount of money a user has spent across all payments.",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Total amount spent returned",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="total_spent", type="number", format="float", example=259.99)
 *         )
 *     )
 * )
 */
Flight::route('GET /total_spent/@user_id', function($user_id) {
    Flight::json(Flight::paymentService()->get_total_spent_for_user($user_id));
});

/**
 * @OA\Get(
 *     path="/bill/{payment_id}/{user_id}",
 *     tags={"payment"},
 *     summary="Get a detailed receipt for a user's payment",
 *     description="Returns a receipt containing all items purchased, their quantities, prices, and total payment amount.",
 *     @OA\Parameter(
 *         name="payment_id",
 *         in="path",
 *         required=true,
 *         description="ID of the payment",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user who made the payment",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Receipt details successfully fetched",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="name", type="string", example="Vjencani prsten"),
 *                     @OA\Property(property="unit_price", type="number", format="float", example=1000),
 *                     @OA\Property(property="quantity", type="integer", example=1),
 *                     @OA\Property(property="total_price", type="number", format="float", example=1000)
 *                 )
 *             ),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-27 21:58:47"),
 *             @OA\Property(property="full_total_price", type="number", format="float", example=1130)
 *         )
 *     )
 * )
 */
Flight::route('GET /bill/@payment_id/@user_id', function($payment_id, $user_id) {
    Flight::json(Flight::paymentService()->get_bill_for_user($payment_id, $user_id));
});

/**
 * @OA\Get(
 *     path="/purchase_history/{user_id}",
 *     tags={"payment"},
 *     summary="Get a structured purchase history for a user",
 *     description="Returns an array of receipts (bills), each containing purchased items, their quantities, unit and total prices, the full purchase total, and the formatted date of purchase.",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user whose purchase history is to be retrieved",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of purchase receipts for the user",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="name", type="string", example="Zlatna narukvica"),
 *                         @OA\Property(property="unit_price", type="number", format="float", example=150.00),
 *                         @OA\Property(property="quantity", type="integer", example=2),
 *                         @OA\Property(property="total_price", type="number", format="float", example=300.00)
 *                     )
 *                 ),
 *                 @OA\Property(property="created_at", type="string", example="29.04.2025. 13:46"),
 *                 @OA\Property(property="full_total_price", type="number", format="float", example=1020.00)
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /purchase_history/@user_id', function($user_id) {
    Flight::json(Flight::paymentService()->get_purchase_history_for_user($user_id));
});

/**
 * @OA\Post(
 *     path="/payment/add_generic",
 *     tags={"payment"},
 *     summary="Add a new payment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "user_id": 1,
 *                 "total_price": 1500
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment added successfully"
 *     )
 * )
 */
Flight::route('POST /payment/add_generic', function() {
    $data = Flight::request()->data->getData();
    Flight::paymentService()->add($data);
});

/**
 * @OA\Get(
 *     path="/payment/get_generic",
 *     tags={"payment"},
 *     summary="Get all payments",
 *     @OA\Response(
 *         response=200,
 *         description="List of all payments"
 *     )
 * )
 */
Flight::route('GET /payment/get_generic', function() {
    Flight::json(Flight::paymentService()->get());
});

/**
 * @OA\Get(
 *     path="/payment/get_generic/{id}",
 *     tags={"payment"},
 *     summary="Get a payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the payment",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment retrieved successfully"
 *     )
 * )
 */
Flight::route('GET /payment/get_generic/@id', function($id) {
    Flight::json(Flight::paymentService()->get_by_id($id));
});

/**
 * @OA\Put(
 *     path="/payment/update_generic/{id}",
 *     tags={"payment"},
 *     summary="Update a payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the payment to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "user_id": 1,
 *                 "total_price": 1600
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment updated successfully"
 *     )
 * )
 */
Flight::route('PUT /payment/update_generic/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::paymentService()->update($data, $id);
});

/**
 * @OA\Delete(
 *     path="/payment/delete_generic/{id}",
 *     tags={"payment"},
 *     summary="Delete a payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the payment to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /payment/delete_generic/@id', function($id) {
    Flight::paymentService()->delete($id);
});

/**
 * @OA\Get(
 *     path="/purchase_history_for_all",
 *     tags={"payment"},
 *     summary="Get purchase history for all users",
 *     description="Returns a list of all purchase history entries from the system.",
 *     @OA\Response(
 *         response=200,
 *         description="List of all purchase history entries",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 example={
 *                     "id": 1,
 *                     "user_id": 5,
 *                     "total": 299.99,
 *                     "payment_date": "2025-05-13 14:35:22",
 *                     "items": {
 *                         {
 *                             "product_id": 12,
 *                             "quantity": 2,
 *                             "price": 49.99
 *                         },
 *                         {
 *                             "product_id": 8,
 *                             "quantity": 1,
 *                             "price": 199.99
 *                         }
 *                     }
 *                 }
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /purchase_history_for_all', function() {
    Flight::json(Flight::paymentService()->get_purchase_history_for_all());
});
?>