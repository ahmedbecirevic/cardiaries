<?php

require_once dirname(__FILE__) . '/BaseService.class.php';
require_once dirname(__FILE__) . '/../dao/AccountDao.class.php';
require_once dirname(__FILE__) . '/../dao/UserDao.class.php';
require_once dirname(__FILE__) . '/../clients/SMTPClient.class.php';


class UserService extends BaseService
{
    private $accountDao;
    private $smtpClient;

    public function __construct()
    {
        $this->dao = new UserDao();
        $this->accountDao = new AccountDao();
        $this->smtpClient = new SMTPClient();
    }

    public function login($user)
    {
        $dbUser = $this->dao->get_user_by_email($user['email']);

        if (!isset($dbUser['id'])) throw new Exception("User does not exist :(", 400);

        if ($dbUser['status'] != 'ACTIVE') throw new Exception("Your account is not active!", 400);

        $account = $this->accountDao->get_by_id($dbUser['account_id']);
        if (!isset($account['id']) || $account['status'] != 'ACTIVE') throw new Exception("Account not active", 400);

        if ($dbUser['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);

        return $dbUser;
    }

    public function register($user)
    {
        if (!isset($user['account'])) throw new Exception("Account field required");

        try {
            // open transaction here 
            $this->dao->beginTransaction();

            $account = $this->accountDao->add([
                "name" => $user['account'],
                "status" => "PENDING",
                "created_at" => date(Config::DATE_FORMAT)

            ]);

            $user = parent::add([
                "account_id" => $account['id'],
                "username" => $user['username'],
                "first_name" => $user['first_name'],
                "last_name" => $user['last_name'],
                "email" => $user['email'],
                "password" => md5($user['password']),
                "status" => "PENDING",
                "created_at" => date(Config::DATE_FORMAT),
                "role" => "USER",
                "token" => md5(random_bytes(16))
            ]);
            // commit here:
            $this->dao->commit();
        } catch (\Exception $e) {
            //rollback on database
            $this->dao->rollBack();

            if (str_contains($e->getMessage(), "users.uq_user_email")) {
                throw new Exception("Account with same email already exists in the database!", 400, $e);
            } else {
                throw $e;
            }
        }


        //send email with token to verify user
        $this->smtpClient->send_register_user_token($user);

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