<?php

require 'vendor/autoload.php';

//middleware
require 'middleware/AuthMiddleware.php';
Flight::register('authMiddleware', 'AuthMiddleware');

Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/user/login') === 0 ||
       strpos(Flight::request()->url, '/user/register') === 0 ||
       strpos(Flight::request()->url, '/products') === 0 ||
       strpos(Flight::request()->url, '/product') === 0 ||
       strpos(Flight::request()->url, '/search') === 0 ||
       strpos(Flight::request()->url, '/categories') === 0 ||
       strpos(Flight::request()->url, '/products-by-category') === 0
   ) {
       return TRUE;
   } else {
       try {
           $headers = getallheaders();
           $token = $headers['Authentication'] ?? null;
            if($token == null) {
                Flight::halt(401, 'Forbidden');
            }
           if(Flight::authMiddleware()->verify_token($token))
               return TRUE;
       } catch (\Exception $e) {
           Flight::halt(401, $e->getMessage());
       }
   }
});

//services
require dirname(__FILE__).'/rest/services/ProductService.php';
require dirname(__FILE__).'/rest/services/UserService.php';
require dirname(__FILE__).'/rest/services/CategoryService.php';
require dirname(__FILE__).'/rest/services/FavouritesService.php';
require dirname(__FILE__).'/rest/services/CartService.php';
require dirname(__FILE__).'/rest/services/PaymentService.php';
require dirname(__FILE__).'/rest/services/PaymentItemService.php';


//routes
require_once dirname(__FILE__).'/rest/routes/ProductRoutes.php';
require_once dirname(__FILE__).'/rest/routes/UserRoutes.php';
require_once dirname(__FILE__).'/rest/routes/CategoryRoutes.php';
require_once dirname(__FILE__).'/rest/routes/FavouritesRoutes.php';
require_once dirname(__FILE__).'/rest/routes/CartRoutes.php';
require_once dirname(__FILE__).'/rest/routes/PaymentRoutes.php';
require_once dirname(__FILE__).'/rest/routes/PaymentItemRoutes.php';

//register
Flight::register('productService', 'ProductService');
Flight::register('userService', 'UserService');
Flight::register('categoryService', 'CategoryService');
Flight::register('favouritesService', 'FavouritesService');
Flight::register('cartService', 'CartService');
Flight::register('paymentService', 'PaymentService');
Flight::register('paymentItemService', 'PaymentItemService');

Flight::start();