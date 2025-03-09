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
}
?>