<?php

require_once dirname(__FILE__) . '/BaseService.class.php';
require_once dirname(__FILE__) . '/../dao/AccountDao.class.php';
require_once dirname(__FILE__) . '/../dao/UserDao.class.php';


class UserService extends BaseService
{
    private $accountDao;

    public function __construct()
    {
        $this->dao = new UserDao();
        $this->accountDao = new AccountDao();
    }

    public function register($user)
    {
        if (!isset($user['account'])) throw new Exception("Account field required");

        try {
            // open transaction here
            $account = $this->accountDao->add([
                "name" => $user['account'],
                "status" => "PENDING",
                "created_at" => date(Config::DATE_FORMAT)

            ]);

            $user = $this->add([
                "account_id" => $account['id'],
                "username" => $user['username'],
                "email" => $user['email'],
                "password" => $user['password'],
                "status" => "PENDING",
                "created_at" => date(Config::DATE_FORMAT),
                "role" => "USER",
                "token" => md5(random_bytes(16))
            ]);
            // commit here:
        } catch (\Throwable $th) {
            //rollback on database
            throw $th;
        }



        // TODO: send email with token to verify user

        return $user;
    }

    public function confirm($token)
    {
        $user = $this->dao->get_user_by_token($token);

        if (!isset($user['id'])) throw new Exception("Invalid token");

        $this->dao->update($user['id'], ["status" => "ACTIVE"]);
        $this->accountDao->update($user['account_id'], ["status" => "ACTIVE"]);

        // TODO send email to customer
    }
}
