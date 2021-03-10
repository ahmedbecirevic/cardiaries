<?php

require_once dirname(__FILE__) . "/BaseDao.class.php";

class UserDao extends BaseDao
{

    public function get_user_by_email($email)
    {
        return $this->query("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }

}
