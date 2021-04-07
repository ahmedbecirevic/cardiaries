<?php

require_once dirname(__FILE__) . '/BaseService.class.php';

require_once dirname(__FILE__) . '/../dao/CarDao.class.php';


class PostService extends BaseService
{

    public function __construct()
    {
        $this->dao = new PostsDao();
    }
}
