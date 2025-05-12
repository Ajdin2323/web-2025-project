<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class PaymentDao extends BaseDao {
    public function __construct(){
        parent::__construct("payment");
    }

    public function insert_payment($user_id, $total_price) {
        $query = $this->connection->prepare("INSERT INTO " . $this->table . " (user_id, total_price) VALUES (:user_id, :total_price)");
        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":total_price", $total_price);
        $query->execute();
        return $this->connection->lastInsertId();
    }    

    public function update_payment($payment_id, $total_price) {
        $query = $this -> connection -> prepare("UPDATE " . $this -> table . " SET total_price = :total_price WHERE id = :payment_id");
        $query->bindParam(":payment_id", $payment_id);
        $query->bindParam(":total_price", $total_price);
        $query->execute();
    }
    
    public function get_total_spent_for_user($user_id) {
        $query = $this->connection->prepare("SELECT SUM(total_price) AS total_price FROM " . $this->table . " WHERE user_id = :user_id");
        $query->bindParam(":user_id", $user_id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return ["total_price" => $result ? (float) $result['total_price'] : 0];
    }   
    
    public function get_bill_for_user($payment_id, $user_id) {
        $query = $this->connection->prepare("SELECT p.name, pi.unit_price, pi.quantity, pi.total_price, pay.created_at, pay.total_price as full_total_price
                                            FROM payment_item pi
                                            JOIN product p ON pi.product_id = p.id
                                            JOIN payment pay ON pi.payment_id = pay.id
                                            WHERE pay.id = :payment_id AND pay.user_id = :user_id");
        $query->bindParam(":payment_id", $payment_id);
        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_purchase_history_for_user($user_id) {
        $query = $this->connection->prepare("SELECT p.name, pi.unit_price, pi.quantity, pi.total_price, pay.created_at, pay.total_price as full_total_price, pay.id as payment_id
                                            FROM payment_item pi
                                            JOIN product p ON pi.product_id = p.id
                                            JOIN payment pay ON pi.payment_id = pay.id
                                            WHERE pay.user_id = :user_id");
        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_payment($entity) {
        return $this -> add($entity);
    }

    public function get() {
        return $this -> get();
    }
    
    public function get_by_id($id) {
        return $this -> get_by_id($id);
    }

    public function update_entity($entity, $id) {
        return $this -> update($entity, $id);
    }

    public function delete($id) {
        return $this -> delete($id);
    }
}
?>