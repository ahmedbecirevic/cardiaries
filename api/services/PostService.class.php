<?php

require_once dirname(__FILE__) . '/BaseService.class.php';
require_once dirname(__FILE__) . '/../dao/CarDao.class.php';
require_once dirname(__FILE__) . '/../dao/PostDao.class.php';

class PostService extends BaseService
{
    private $carDao;
    public function __construct()
    {
        $this->dao = new PostDao();
        $this->carDao = new CarDao();
    }

    public function addPost($post, $userID)
    {

        $car = $this->carDao->get_car_by_vin($post['vin']);
        if (!isset($post['body'])) throw new Exception("Post body is missing!!!");
        if (!isset($car['id']) || $car['user_id'] != $userID) throw new Exception("This car does not exist or belong to you!", 401);
        $post['car_id'] = $this->carDao->get_car_by_vin($post['vin'])['id'];
        $post['created_at'] = date(Config::DATE_FORMAT);
        $post['user_id'] = $userID;
        unset($post['vin']);
        return parent::add($post);
    }

    public function get_posts_by_id($id)
    {
        return $this->dao->get_posts_by_id($id);
    }

    public function get_posts_by_car_id($id)
    {
        return $this->dao->get_posts_by_car_id($id);
    }
}
