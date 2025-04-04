<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class UserDao extends BaseDao {
    public function __construct(){
        parent::__construct("user");
    }

    public function get_all_users($size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size); 
    
        $query = $this->connection->prepare("SELECT * FROM " . $this->table . " LIMIT :size OFFSET :offset");
        $query->bindValue(":size", $size, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_user($id) {
        return $this -> delete($id);
    }

    public function get_user_by_id($id) {
        return $this -> get_by_id($id);
    }
}
?>