<?php
require_once dirname(__FILE__) . '/BaseDao.class.php';

class FavouritesDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("favourites");
    }

    public function add_to_favourites_for_user($entity)
    {
        return $this->add($entity);
    }

    public function delete_from_favourites_for_user($user_id, $product_id)
    {
        $query = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE user_id = :user_id AND product_id = :product_id");
        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":product_id", $product_id);
        $query->execute();
        return Flight::json(["message" => $this->table . " deleted successfully!"]);
    }

    public function get_all_favourites_for_user($user_id) 
    {
        $query = $this->connection->prepare("SELECT p.id, p.name, p.price, p.availability, p.sale_price, p.image, p.color, p.material, p.size
                                                    FROM product p 
                                                    JOIN favourites f ON p.id = f.product_id
                                                    JOIN user u ON f.user_id = u.id
                                                    WHERE user_id = :user_id");

        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
