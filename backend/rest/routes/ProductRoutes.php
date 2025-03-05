<?php

Flight::route('GET /products(/@size(/@page))', function($size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::productService()->get_all_products($size, $page));
});


Flight::route('GET /product/@id', function($id) {
    Flight::json(Flight::productService() -> get_product_by_id($id));
});

Flight::route('POST /product', function(){
    $data = Flight::request() -> data -> getData();
    Flight::productService() -> add_product($data);
});

Flight::route('DELETE /product/@id', function($id) {
    Flight::productService() -> delete_product($id);
});