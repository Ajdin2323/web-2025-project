<?php
require_once dirname(__FILE__) . '/BaseDao.class.php';

class CartDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("cart");
    }

    public function add_to_cart_for_user($entity)
    {
        return $this->add($entity);
    }

    public function delete_from_cart_for_user($user_id, $product_id)
    {
        $query = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE user_id = :user_id AND product_id = :product_id");
        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":product_id", $product_id);
        $query->execute();
        return Flight::json(["message" => $this->table . " deleted successfully!"]);
    }

    public function get_all_cart_products_for_user($user_id)
    {
        $query = $this->connection->prepare("SELECT p.id, p.name, p.price, p.availability, p.sale_price, p.image, p.color, p.material, p.size, c.quantity
                                                    FROM product p 
                                                    JOIN cart c ON p.id = c.product_id
                                                    JOIN user u ON c.user_id = u.id
                                                    WHERE user_id = :user_id");

        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clear_cart_for_user($user_id) 
    {
        $query = $this->connection->prepare("DELETE FROM " . $this -> table . " WHERE user_id = :user_id");
        $query->bindParam(":user_id", $user_id);
        $query->execute();
    }

    public function get_product_id_quantity_from_cart_for_user($user_id) {
        $cart_items = $this->get_all_cart_products_for_user($user_id);
        $product_quantities = [];
    
        foreach ($cart_items as $item) {
            $product_quantities[$item['id']] = $item['quantity'];
        }
    
        return $product_quantities;
    }

    public function add_cart($entity) {
        return $this -> add($entity);
    }

    public function get_cart() {
        return $this -> get();
    }
    
    public function get_cart_by_id($id) {
        return $this -> get_by_id($id);
    }

    public function update_entity($entity, $id) {
        return $this -> update($entity, $id);
    }

    public function delete_cart($id) {
        return $this -> delete($id);
    }
}
