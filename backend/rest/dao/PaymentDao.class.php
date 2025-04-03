<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class PaymentDao extends BaseDao {
    public function __construct(){
        parent::__construct("payment");
    }

    public function get_all_payments() {
        return $this -> get();
    }
    
    public function get_payment_by_id($id) {
        return $this -> get_by_id($id);
    }
    
    public function add_payment($entity) {
        return $this -> add($entity);
    }

    public function delete_payment($id) {
        return $this -> delete($id);
    }

    public function update_payment($entity, $id) {
        return $this -> update($entity, $id);
    }
}
?>