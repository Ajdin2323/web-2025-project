<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class ProductDao extends BaseDao {
    public function __construct(){
        parent::__construct("product");
    }

    public function get_all_products() {
        return $this->get();
    }
}
?>