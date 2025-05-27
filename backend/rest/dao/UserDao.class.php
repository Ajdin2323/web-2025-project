<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class UserDao extends BaseDao {
    public function __construct(){
        parent::__construct("user");
    }

    public function get_all_users($size, $page) {
        $size = (int) $size;
        $offset = (int) (($page - 1) * $size);
        $limit = $size + 1; 
    
        $query = $this->connection->prepare("SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
        
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $has_more = count($results) > $size;
        $users = array_slice($results, 0, $size);

        return [
            'users' => $users,
            'has_more' => $has_more
        ];
    }   

    public function delete_user($id) {
        return $this -> delete($id);
    }

    public function get_user_by_id($id) {
        return $this -> get_by_id($id);
    }

    public function add_user($entity) {
        return $this -> add($entity);
    } 

    public function update_entity($entity, $id) {
        return $this -> update($entity, $id);
    }

    public function find_user_by_email($email) {
        $query = $this->connection->prepare("SELECT * FROM " . $this -> table . " WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function set_deleted_status_true($id) {
        $query = $this->connection->prepare("UPDATE " . $this -> table . " SET deleted = 1 WHERE id = :id");
        $query->bindValue(":id", $id);
        return $query->execute();
    }
}
?>