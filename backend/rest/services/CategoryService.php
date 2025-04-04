<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/CategoryDao.class.php';

class CategoryService extends BaseService{

    public function __construct(){
        parent::__construct(new CategoryDao());
    }

    public function get_all_products_by_category($category_name, $size, $page) {
        return $this -> dao -> get_all_products_by_category($category_name, $size, $page);
    }

    public function get_all_categories() {
        return $this -> dao -> get_all_categories();
    }

    public function get_category_by_id($id) {
        return $this -> dao -> get_category_by_id($id);
    }

    public function add_category($entity) {
        return $this -> dao -> add_category($entity);
    }

    public function delete_category($id) {
        return $this -> dao -> delete_category($id);
    }

    public function update_category($entity, $id) {
        return $this -> dao -> update_category($entity, $id);
    }
}
?>