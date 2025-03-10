<?php

Flight::route('GET /products-by-category/@category_name(/@size(/@page))', function($category_name, $size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::categoryService()->get_all_products_by_category($category_name, $size, $page));
});

Flight::route('GET /categories', function() {
    Flight::json(Flight::categoryService() -> get_all_categories());
});

Flight::route('GET /category/@id', function($id) {
    Flight::json(Flight::categoryService() -> get_category_by_id($id));
});

Flight::route('POST /category', function(){
    $data = Flight::request() -> data -> getData();
    Flight::categoryService() -> add_category($data);
});

Flight::route('DELETE /category/@id', function($id) {
    Flight::categoryService() -> delete_category($id);
});

Flight::route('PUT /category/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::categoryService()->update_category($data, $id);
});