<?php

require 'vendor/autoload.php';

//services
require dirname(__FILE__).'/rest/services/ProductService.php';
require dirname(__FILE__).'/rest/services/UserService.php';
require dirname(__FILE__).'/rest/services/CategoryService.php';
require dirname(__FILE__).'/rest/services/FavouritesService.php';
require dirname(__FILE__).'/rest/services/CartService.php';
require dirname(__FILE__).'/rest/services/PaymentService.php';

//routes
require_once dirname(__FILE__).'/rest/routes/ProductRoutes.php';
require_once dirname(__FILE__).'/rest/routes/UserRoutes.php';
require_once dirname(__FILE__).'/rest/routes/CategoryRoutes.php';
require_once dirname(__FILE__).'/rest/routes/FavouritesRoutes.php';
require_once dirname(__FILE__).'/rest/routes/CartRoutes.php';
require_once dirname(__FILE__).'/rest/routes/PaymentRoutes.php';

//register
Flight::register('productService', 'ProductService');
Flight::register('userService', 'UserService');
Flight::register('categoryService', 'CategoryService');
Flight::register('favouritesService', 'FavouritesService');
Flight::register('cartService', 'CartService');
Flight::register('paymentService', 'PaymentService');

Flight::start();