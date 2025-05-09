<?php
class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this -> dao = $dao;
    }
}
?>