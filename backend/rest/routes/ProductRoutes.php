<?php

/**
 * @OA\Get(
 *     path="/products",
 *     tags={"products"},
 *     summary="Get all products (no pagination)",
 *     @OA\Response(
 *         response=200,
 *         description="List of products"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/products/{size}",
 *     tags={"products"},
 *     summary="Get all products with size",
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of products per page"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of products"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/products/{size}/{page}",
 *     tags={"products"},
 *     summary="Get all products with pagination",
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of products per page"
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
 *         description="List of products"
 *     )
 * )
 */
Flight::route('GET /products(/@size(/@page))', function($size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;
    Flight::json(Flight::productService()->get_all_products($size, $page));
});

/**
 * @OA\Get(
 *     path="/search/{keyword}",
 *     tags={"products"},
 *     summary="Search products by keyword (no pagination)",
 *     @OA\Parameter(
 *         name="keyword",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Keyword to search for"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Filtered list of products"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/search/{keyword}/{size}",
 *     tags={"products"},
 *     summary="Search products with size",
 *     @OA\Parameter(
 *         name="keyword",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Keyword to search for"
 *     ),
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of products per page"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Filtered list of products"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/search/{keyword}/{size}/{page}",
 *     tags={"products"},
 *     summary="Search products with pagination",
 *     @OA\Parameter(
 *         name="keyword",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Keyword to search for"
 *     ),
 *     @OA\Parameter(
 *         name="size",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Number of products per page"
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
 *         description="Filtered list of products"
 *     )
 * )
 */
Flight::route('GET /search/@keyword(/@size(/@page))', function($keyword, $size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;
    Flight::json(Flight::productService()->search_products($keyword, $size, $page));
});

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Get a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the product"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product data"
 *     )
 * )
 */
Flight::route('GET /product/@id', function($id) {
    Flight::json(Flight::productService()->get_product_by_id($id));
});

/**
 * @OA\Post(
 *     path="/product",
 *     tags={"products"},
 *     summary="Create a new product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"name": "Pizza", "price": 10.99, "description": "Delicious cheese pizza"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product created successfully"
 *     )
 * )
 */
Flight::route('POST /product', function() {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::productService()->add_product($data);
});

/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Delete a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the product to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /product/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::productService()->delete_product($id);
});

/**
 * @OA\Put(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Update an existing product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the product to update"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"name": "Updated Pizza", "price": 11.99, "description": "Updated description"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully"
 *     )
 * )
 */
Flight::route('PUT /product/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::productService()->update_product($data, $id);
});
?>