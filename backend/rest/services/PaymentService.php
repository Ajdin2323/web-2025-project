<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/PaymentDao.class.php';
require_once dirname(__FILE__).'/../dao/ProductDao.class.php';
require_once dirname(__FILE__).'/../dao/CartDao.class.php';
require_once dirname(__FILE__).'/../dao/PaymentItemDao.class.php';

class PaymentService extends BaseService {

    private $productDao;
    private $cartDao;
    private $paymentItemDao;

    public function __construct() {
        parent::__construct(new PaymentDao());

        $this->productDao = new ProductDao();
        $this->cartDao = new CartDao();
        $this->paymentItemDao = new PaymentItemDao();
    }

    public function checkout_user($user_id) {
        $grouped = $this -> cartDao -> get_product_id_quantity_from_cart_for_user($user_id);

        $total = 0;
        $payment_id = $this -> dao -> insert_payment($user_id, 0);
        
        foreach ($grouped as $product_id => $quantity) {
            $unit_price = $this -> productDao -> get_price($product_id);
            $total_price = $unit_price * $quantity;

            $this -> paymentItemDao -> insert_payment_item($payment_id, $product_id, $quantity, $unit_price, $total_price);
            $total += $total_price;
        }

        $this -> dao -> update_payment($payment_id, $total);
        $this -> cartDao -> clear_cart_for_user($user_id);

        return $payment_id;
    }

    public function get_total_spent_for_user($user_id) {
        return $this -> dao -> get_total_spent_for_user($user_id);
    }

    public function get_bill_for_user($payment_id, $user_id) {
        $items = $this->dao->get_bill_for_user($payment_id, $user_id);
    
        if (empty($items)) return null;
    
        $createdAt = date("d.m.Y. H:i", strtotime($items[0]["created_at"]));
        $fullTotal = $items[0]["full_total_price"];
    
        $cleanItems = array_map(function($item) {
            return [
                "name" => $item["name"],
                "unit_price" => $item["unit_price"],
                "quantity" => $item["quantity"],
                "total_price" => $item["total_price"]
            ];
        }, $items);
    
        return [
            "items" => $cleanItems,
            "created_at" => $createdAt,
            "full_total_price" => $fullTotal
        ];
    }      
}
?>
