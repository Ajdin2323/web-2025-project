<?php

require 'vendor/autoload.php';

//services
require dirname(__FILE__).'/rest/services/ProductService.php';
require dirname(__FILE__).'/rest/services/UserService.php';
require dirname(__FILE__).'/rest/services/CategoryService.php';

//routes
require_once dirname(__FILE__).'/rest/routes/ProductRoutes.php';
require_once dirname(__FILE__).'/rest/routes/UserRoutes.php';
require_once dirname(__FILE__).'/rest/routes/CategoryRoutes.php';

//register
Flight::register('productService', 'ProductService');
Flight::register('userService', 'UserService');
Flight::register('categoryService', 'CategoryService');

Flight::start();