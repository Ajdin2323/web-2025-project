<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/PaymentItemDao.class.php';

class PaymentItemService extends BaseService{

    public function __construct(){
        parent::__construct(new PaymentItemDao());
    }

    public function add($entity) {
        return $this -> dao -> add_payment_item($entity);
    }

    public function get() {
        return $this -> dao -> get_payment_item();
    }

    public function get_by_id($id) {
        return $this -> dao -> get_payment_item_by_id($id);
    }

    public function update($entity, $id) {
        return $this -> dao -> update_entity($entity, $id);
    }

    public function delete($id) {
        return $this -> dao -> delete_payment_item($id);
    }
}
?>