<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class CategoryDao extends BaseDao {
    public function __construct(){
        parent::__construct("category");
    }

    public function get_all_products_by_category($category_name, $size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size); 
        
        $query = $this->connection->prepare("
        SELECT 
            p.id AS product_id, 
            p.name AS product_name, 
            p.price, 
            p.availability, 
            p.sale_price, 
            p.image, 
            p.color, 
            p.material, 
            p.size, 
            p.category_id,
            c.id AS category_id, 
            c.name AS category_name
        FROM product p
        JOIN " . $this->table . " c
        ON p.category_id = c.id
        WHERE c.name = :category_name
        LIMIT :size OFFSET :offset
    ");
        $query->bindValue(":size", $size, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        $query -> bindParam(":category_name", $category_name);
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_category_by_id($id) {
        return $this -> get_by_id($id);
    }

}
?>