<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class PaymentItemDao extends BaseDao {
    public function __construct(){
        parent::__construct("payment_item");
    }

    public function insert_payment_item($payment_id, $product_id, $quantity, $unit_price, $total_price) {
        $query = $this -> connection -> prepare("INSERT INTO " . $this -> table . "(payment_id, product_id, quantity, unit_price, total_price)
        VALUES(:payment_id, :product_id, :quantity, :unit_price, :total_price)");
        $query->bindParam(":payment_id", $payment_id);
        $query->bindParam(":product_id", $product_id);
        $query->bindParam(":quantity", $quantity);
        $query->bindParam(":unit_price", $unit_price);
        $query->bindParam(":total_price", $total_price);
        $query->execute();
    }
}
?>