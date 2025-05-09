<?php
require_once dirname(__FILE__).'/BaseService.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

    public function __construct(){
        parent::__construct(new UserDao());
    }

    public function get_all_users($size, $page) {
        return $this -> dao -> get_all_users($size, $page);
    }

    public function get_user_by_id($id) {
        return $this -> dao -> get_user_by_id($id);
    }
    
    public function delete_user($id) {
        return $this -> dao -> delete_user($id);
    }

    public function add($entity) {
        return $this -> dao -> add($entity);
    }

    public function update($entity, $id) {
        return $this -> dao -> update_entity($entity, $id);
    }
}
?>