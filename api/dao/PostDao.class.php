<?php

require_once dirname(__FILE__) . "/BaseDao.class.php";

class PostDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("posts");
    }

    public function get_posts_by_id($id)
    {
        return $this->query("SELECT * FROM posts 
                             WHERE user_id = :id", ["id" => $id]);
    }

    public function get_posts_by_car_id($id)
    {
        return $this->query("SELECT * FROM posts 
                             WHERE car_id = :id", ["id" => $id]);
    }
}
