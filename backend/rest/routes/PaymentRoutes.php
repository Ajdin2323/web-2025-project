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
?>