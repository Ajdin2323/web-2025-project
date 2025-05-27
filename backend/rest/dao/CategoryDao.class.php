<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class CategoryDao extends BaseDao {
    public function __construct(){
        parent::__construct("category");
    }

    public function get_all_products_by_category($category_name, $size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size);
        $limit = $size + 1; 
        
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
        LIMIT :limit OFFSET :offset
    ");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        $query -> bindParam(":category_name", $category_name);
        
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $has_more = count($results) > $size;
        $products = array_slice($results, 0, $size);

        return [
            'products' => $products,
            'has_more' => $has_more
        ];
    }

    public function get_all_categories() {
        return $this -> get();
    }

    public function get_category_by_id($id) {
        return $this -> get_by_id($id);
    }

    public function add_category($entity) {
        return $this -> add($entity);
    }

    public function delete_category($id) {
        return $this -> delete($id);
    }

    public function update_category($entity, $id) {
        return $this -> update($entity, $id);
    }
}
?>