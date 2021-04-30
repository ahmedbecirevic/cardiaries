<?php

require_once dirname(__FILE__) . '/BaseService.class.php';
require_once dirname(__FILE__) . '/../dao/CarDao.class.php';
require_once dirname(__FILE__) . '/../dao/ImageDao.class.php';


class PostService extends BaseService
{
    private $imageDao;

    public function __construct()
    {
        $this->dao = new PostDao();
        $this->imageDao = new ImageDao();
    }

    public function add($post)
    {
        if (!isset($post['body'])) throw new Exception("Post body is missing!!!");
        $post['created_at'] = date(Config::DATE_FORMAT);
        $post['user_id'] = Flight::get('user')['id'];
        return parent::add($post);
    }

    public function get_posts_by_id($id)
    {
        return $this->dao->get_posts_by_id($id);
    }
}
