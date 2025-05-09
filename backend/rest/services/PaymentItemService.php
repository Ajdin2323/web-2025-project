<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/PaymentItemDao.class.php';

class PaymentItemService extends BaseService{

    public function __construct(){
        parent::__construct(new PaymentItemDao());
    }

    public function add($entity) {
        return $this -> dao -> add($entity);
    }

    public function get() {
        return $this -> dao -> get();
    }

    public function get_by_id($id) {
        return $this -> dao -> get_by_id($id);
    }

    public function update($entity, $id) {
        return $this -> dao -> update_entity($entity, $id);
    }

    public function delete($id) {
        return $this -> dao -> delete($id);
    }
}
?>