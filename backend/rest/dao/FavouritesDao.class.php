<?php
require_once dirname(__FILE__).'/BaseDao.class.php';

class FavouritesDao extends BaseDao {
    public function __construct(){
        parent::__construct("favourites");
    }

    public function get_all_favourites() {
        return $this -> get();
    }
    
    public function get_favourites_by_id($id) {
        return $this -> get_by_id($id);
    }
    
    public function add_favourites($entity) {
        return $this -> add($entity);
    }

    public function delete_favourites($id) {
        return $this -> delete($id);
    }

    public function update_favourites($entity, $id) {
        return $this -> update($entity, $id);
    }
}
?>