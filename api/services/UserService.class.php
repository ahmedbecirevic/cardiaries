<?php
require_once dirname(__FILE__) . '/BaseService.class.php';
require_once dirname(__FILE__) . '/../dao/AccountDao.class.php';
require_once dirname(__FILE__) . '/../dao/UserDao.class.php';
require_once dirname(__FILE__) . '/../clients/SMTPClient.class.php';
require_once dirname(__FILE__) . '/../clients/DOSpacesClient.class.php';


use \Firebase\JWT\JWT;

class UserService extends BaseService
{
    private $accountDao;
    private $smtpClient;
    private $DOSpacesClient;
    private $PostDao;

    public function __construct()
    {
        $this->dao = new UserDao();
        $this->accountDao = new AccountDao();
        $this->smtpClient = new SMTPClient();
        $this->postDao = new PostDao();
        $this->DOSpacesClient = new DOSpacesClient;
    }

    public function reset($user)
    {
        $dbUser = $this->dao->get_user_by_token($user['token']);

        if (!isset($dbUser['id'])) throw new Exception("Invalid token", 400);

        if (strtotime(date(Config::DATE_FORMAT)) - strtotime($dbUser['token_created_at']) > 300) throw new Exception("Token has expired!", 400);

        $this->dao->update($dbUser['id'], ["password" => md5($user['password']), "token" => NULL]);

        return $dbUser;
    }

    public function forgot($user)
    {
        $dbUser = $this->dao->get_user_by_email($user['email']);

        if (!isset($dbUser['id'])) throw new Exception("User does not exist :(", 400);

        if (strtotime(date(Config::DATE_FORMAT)) - strtotime($dbUser['token_created_at']) < 300) throw new Exception("Be patient, token is on its way!", 400);

        // genretate new token and save it to the DB
        $dbUser = $this->update($dbUser['id'], ["token" => md5(random_bytes(16)), "token_created_at" => date(Config::DATE_FORMAT)]);
        // send the recovery email    
        $this->smtpClient->send_user_recovery_token($dbUser);
    }

    public function login($user)
    {
        $dbUser = $this->dao->get_user_by_email($user['email']);

        if (!isset($dbUser['id'])) throw new Exception("User does not exist :(", 400);

        if ($dbUser['status'] != 'ACTIVE') throw new Exception("Your account is not active!", 400);

        // $account = $this->accountDao->get_by_id($dbUser['account_id']);
        // if (!isset($account['id']) || $account['status'] != '') throw new Exception("Account not active", 400);

        if ($dbUser['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);

        return $dbUser;
    }

    public function register($user)
    {
        // if (!isset($user['account'])) throw new Exception("Account field required");

        try {
            // open transaction here 
            $this->dao->beginTransaction();

            $user = parent::add([
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

        if (!isset($user['id'])) throw new Exception("Invalid token", 400);

        $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);
        // $this->accountDao->update($user['account_id'], ["status" => "ACTIVE"]);
        // send email to customer that their account is now confirmed
        //$this->smtpClient->send_user_confirmed_notice($user);
        return $user;
    }

    public function uploadImage ($imageName, $content) {
        return $this->DOSpacesClient->uploadImage($imageName, $content);
    }

    public function get_user_by_id ($id) {
        return $this->dao->get_user_by_id($id);
    }
}
