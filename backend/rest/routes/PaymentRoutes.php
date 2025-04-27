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
?>