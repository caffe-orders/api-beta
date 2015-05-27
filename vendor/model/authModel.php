<?php
class AuthModel extends Model
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    //
    //
    public function Login($email, $password)
    {
        $state = false;
        $query = $this->connection->prepare(
           'SELECT
                id,
                email,
                pwdHash
            FROM
                users
            WHERE
                email = ?'
        );
        $query->execute(array($email));
        if($response = $query->fetch())
        {
            if($response['pwdHash'] === md5($password))
            {
                //session_start();
                $_SESSION['id'] = $response['id'];
                $addHashQuery = $this->connection->prepare(
                   'UPDATE
                        users
                    SET
                        sessionHash = :hash
                    WHERE
                        id = :id'
                );
                $hash = md5($response['email'] . date('Y-m'));
                $_SESSION['hash'] = $hash;
                $id = $response['id'];
                $_SESSION['id'] = $id;
                $addHashQuery->execute(array(
                    ':hash' => $hash,
                    ':id' => $id
                ));
                $state = true;
            }
        }
        return $state;
    }
    //
    //
    //
    public function LogOut()
    {
        unset($_SESSION['id']);
        unset($_SESSION['hash']);
        session_destroy();
    }
}
?>