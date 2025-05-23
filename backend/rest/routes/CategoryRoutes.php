<?php

/**
 * @OA\Get(
 *     path="/products-by-category/{category_name}",
 *     tags={"categories"},
 *     summary="Get products by category name (no pagination)",
 *     @OA\Parameter(
 *         name="category_name",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Category name to filter products"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of products in the specified category"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/products-by-category/{category_name}/{size}",
 *     tags={"categories"},
 *     summary="Get products by category name with size",
 *     @OA\Parameter(
 *         name="category_name",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Category name to filter products"
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
 *         description="List of products in the specified category"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/products-by-category/{category_name}/{size}/{page}",
 *     tags={"categories"},
 *     summary="Get products by category name with pagination",
 *     @OA\Parameter(
 *         name="category_name",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="Category name to filter products"
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
 *         description="List of products in the specified category"
 *     )
 * )
 */
Flight::route('GET /products-by-category/@category_name(/@size(/@page))', function($category_name, $size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::categoryService()->get_all_products_by_category($category_name, $size, $page));
});

/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of all product categories"
 *     )
 * )
 */
Flight::route('GET /categories', function() {
    Flight::json(Flight::categoryService()->get_all_categories());
});

/**
 * @OA\Get(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Get a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the category"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category data"
 *     )
 * )
 */
Flight::route('GET /category/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::json(Flight::categoryService()->get_category_by_id($id));
});

/**
 * @OA\Post(
 *     path="/category",
 *     tags={"categories"},
 *     summary="Create a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"name": "Drinks", "description": "All types of beverages"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category created successfully"
 *     )
 * )
 */
Flight::route('POST /category', function(){
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::categoryService()->add_category($data);
});

/**
 * @OA\Delete(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Delete a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the category to delete"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /category/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    Flight::categoryService()->delete_category($id);
});

/**
 * @OA\Put(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Update an existing category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="ID of the category to update"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             example={"name": "Updated Drinks", "description": "Updated category description"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated successfully"
 *     )
 * )
 */
Flight::route('PUT /category/@id', function($id) {
    Flight::authMiddleware()->authorize_role(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::categoryService()->update_category($data, $id);
});
?>
