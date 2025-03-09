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

    public function search_products($keyword, $size, $page) {
        return $this -> dao -> search_products($keyword, $size, $page);
    }

    public function get_product_by_id($id) {
        return $this -> dao -> get_product_by_id($id);
    }
    
    public function add_product($entity) {
        return $this -> dao -> add_product($entity);
    }

    public function delete_product($id) {
        return $this -> dao -> delete_product($id);
    }

    public function update_product($entity, $id) {
        return $this -> dao -> update_product($entity, $id);
    }

}
?>