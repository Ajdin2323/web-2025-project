<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/ProductDao.class.php';

class ProductService extends BaseService{

    public function __construct(){
        parent::__construct(new ProductDao());
    }

    public function get_all_products() {
        return $this -> get();
    }
}
?>