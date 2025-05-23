<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class ProductDao extends BaseDao {
    public function __construct(){
        parent::__construct("product");
    }

    public function get_all_products($size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size);
        $limit = $size + 1;
    
        $query = $this->connection->prepare("SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $has_more = count($results) > $size;
        $products = array_slice($results, 0, $size);

        return [
            'products' => $products,
            'has_more' => $has_more
        ];
    }

    public function search_products($keyword, $size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size);
        $limit = $size + 1;
    
        $query = $this->connection->prepare("
            SELECT * FROM " . $this->table . " 
            WHERE (name LIKE :start_match OR name LIKE :word_match)
               OR color = :keyword 
               OR material = :keyword 
               OR size = :keyword 
            LIMIT :limit OFFSET :offset
        ");
    
        $startMatch = $keyword . '%';       
        $wordMatch = '% ' . $keyword . '%';  
    
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        $query->bindValue(":start_match", $startMatch);
        $query->bindValue(":word_match", $wordMatch);
        $query->bindValue(":keyword", $keyword);
    
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $has_more = count($results) > $size;
        $products = array_slice($results, 0, $size);

        return [
            'products' => $products,
            'has_more' => $has_more
        ];
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