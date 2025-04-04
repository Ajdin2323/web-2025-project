<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class CarttDao extends BaseDao {
    public function __construct(){
        parent::__construct("cart");
    }

    public function get_all_carts() {
        return $this -> get();
    }
    
    public function get_cart_by_id($id) {
        return $this -> get_by_id($id);
    }
    
    public function add_cart($entity) {
        return $this -> add($entity);
    }

    public function delete_cart($id) {
        return $this -> delete($id);
    }

    public function update_cart($entity, $id) {
        return $this -> update($entity, $id);
    }
}
?>