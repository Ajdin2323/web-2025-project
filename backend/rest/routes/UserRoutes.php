<?php

Flight::route('GET /users(/@size(/@page))', function($size = null, $page = null) {
    $size = $size ?? 10;
    $page = $page ?? 1;

    Flight::json(Flight::userService()->get_all_users($size, $page));
});

Flight::route('GET /user/@id', function($id) {
    Flight::json(Flight::userService() -> get_user_by_id($id));
});

Flight::route('DELETE /user/@id', function($id) {
    Flight::userService() -> delete_user($id);
});
?>