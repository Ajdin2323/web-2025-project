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
}
?>