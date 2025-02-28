<?php

Flight::route('GET /products', function(){
    Flight::json(Flight::productService()->get_all_products());
});