<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/CartDao.class.php';

class CartService extends BaseService{

    public function __construct(){
        parent::__construct(new CartDao());
    }

    public function add_to_cart_for_user($entity) {
        return $this -> dao -> add_to_cart_for_user($entity);
    }

    public function delete_from_cart_for_user($user_id, $product_id) {
        return $this -> dao -> delete_from_cart_for_user($user_id, $product_id);
    }

    public function get_all_cart_products_for_user($user_id) {
        return $this -> dao -> get_all_cart_products_for_user($user_id);
    }

    public function add($entity) {
        return $this -> dao -> add_cart($entity);
    }

    public function get() {
        return $this -> dao -> get_cart();
    }

    public function get_by_id($id) {
        return $this -> dao -> get_cart_by_id($id);
    }

    public function update($entity, $id) {
        return $this -> dao -> update_entity($entity, $id);
    }

    public function delete($id) {
        return $this -> dao -> delete_cart($id);
    }
}
?>