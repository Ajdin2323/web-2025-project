<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class ProductDao extends BaseDao {
    public function __construct(){
        parent::__construct("product");
    }

    public function get_all_products($size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size); 
    
        $query = $this->connection->prepare("SELECT * FROM " . $this->table . " LIMIT :size OFFSET :offset");
        $query->bindValue(":size", $size, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search_products($keyword, $size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size);

        $query = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE name = :keyword OR color = :keyword OR material = :keyword OR size = :keyword LIMIT :size OFFSET :offset");
        $query->bindValue(":size", $size, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        $query -> bindParam(":keyword", $keyword);
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_product_by_id($id) {
        return $this -> get_by_id($id);
    }
    
    public function add_product($entity) {
        return $this -> add($entity);
    }

    public function delete_product($id) {
        return $this -> delete($id);
    }

    public function update_product($entity, $id) {
        return $this -> update($entity, $id);
    }

    public function get_price($product_id) {
        $query = $this -> connection -> prepare("SELECT price FROM " . $this -> table . " WHERE id = :product_id");
        $query->bindParam(":product_id", $product_id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['price'] : null;
    }
}
?>