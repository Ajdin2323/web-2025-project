<?php

require 'vendor/autoload.php';

//services
require dirname(__FILE__).'/rest/services/ProductService.php';

//routes
require_once dirname(__FILE__).'/rest/routes/ProductRoutes.php';

//register
Flight::register('productService', 'ProductService');


Flight::start();