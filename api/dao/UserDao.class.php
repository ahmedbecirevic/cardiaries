<?php

require_once dirname(__FILE__) . "/BaseDao.class.php";

class UserDao extends BaseDao
{

    public function get_user_by_email($email)
    {
        return $this->query_unique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }


    public function get_user_by_id ($id) 
    {
        return $this->query_unique("SELECT * FROM users WHERE id = :id", ["id" => $id]);
    }


    public function add_user($user)
    {
        $sql = "INSERT INTO users (username, email, password, account_id) VALUES (:username, :email, :password, :account_id)";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute($user);
        $user["id"] = $this->connection->lastInsertId();

        return $user;
    }

    public function update_user($id, $user) 
    {

        //generating automated query
        $query = "UPDATE users SET ";
        
        foreach ($user as $column => $value) {
            $query.= $column." = :".$column.", ";
        }
        
        $query = mb_substr($query, 0, -2);
        $query .= " WHERE id = :id";

        //executing the query
        $stmt= $this->connection->prepare($query);
        $user["id"] = $id;
        $stmt->execute($user);

        return $user;

        /*
        $sql = "UPDATE users 
                SET username = :username, email = :email, password = :password, account_id = :account_id
                WHERE id = :id";
        */
    }
}
