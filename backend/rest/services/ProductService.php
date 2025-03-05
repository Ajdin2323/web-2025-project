<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/ProductDao.class.php';

class ProductService extends BaseService{

    public function __construct(){
        parent::__construct(new ProductDao());
    }

    public function get_all_products($size, $page) {
        return $this -> dao -> get_all_products($size, $page);
    }

    public function get_product_by_id($id) {
        return $this -> dao -> get_product_by_id($id);
    }

}
?>