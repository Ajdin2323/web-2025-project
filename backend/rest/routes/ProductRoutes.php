<?php

Flight::route('GET /products/@size/@page', function($size, $page){
    Flight::json(Flight::productService()->get_all_products($size, $page));
});