<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/FavouritesDao.class.php';

class FavouritesService extends BaseService{

    public function __construct(){
        parent::__construct(new FavouritesDao());
    }

    public function add_to_favourites_for_user($entity) {
        return $this -> dao -> add_to_favourites_for_user($entity);
    }

    public function delete_from_favourites_for_user($user_id, $product_id) {
        return $this -> dao -> delete_from_favourites_for_user($user_id, $product_id);
    }

    public function get_all_favourites_for_user($user_id) {
        return $this -> dao -> get_all_favourites_for_user($user_id);
    }
}
?>