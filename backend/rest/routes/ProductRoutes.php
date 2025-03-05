<?php

Flight::route('GET /products(/@size(/@page))', function($size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::productService()->get_all_products($size, $page));
});


Flight::route('GET /product/@id', function($id) {
    Flight::json(Flight::productService() -> get_product_by_id($id));
});