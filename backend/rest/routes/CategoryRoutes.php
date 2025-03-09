<?php

Flight::route('GET /category/@category_name(/@size(/@page))', function($category_name, $size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::categoryService()->get_all_products_by_category($category_name, $size, $page));
});