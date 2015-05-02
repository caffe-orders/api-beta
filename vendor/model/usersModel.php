<?php
class UsersModel
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    //$limit - int
    //$offset - int
    //return array if data exists, false if no data
    //
    public function GetPublicInfoList($limit, $offset)
    {
        $query = $this->connection->prepare(
            'SELECT 
                 id,
                 firstName,
                 lastName 
             FROM 
                 users 
             ORDER BY 
                 id 
             DESC 
             LIMIT 
                 :offset,
                 :limit'
        );
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    //
    //$id - int
    //return array if data exists, false if no data
    //
    public function GetFullInfo($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                users
            WHERE
                id = ?'
        );
        $query->execute(array($id));
        return $query->fetch();
    }
    
    //
    //$id - int
    //return array if data exists, false if no data
    //
    public function GetId($sessionHash)
    {
        $query = $this->connection->prepare(
           'SELECT
                id, access, isActive 
            FROM
                users
            WHERE
                sessionHash = ?'
        );
        $query->execute(array($sessionHash));
        return $query->fetch();
    }
    //
    //$id - int
    //return array if data exists, false if no data
    //
    public function GetPublicInfo($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                id,
                firstName,
                lastName
            FROM
                users
            WHERE
                id = :id'
        );
        $query->execute(array(':id' => $id));
        return $query->fetch();
    }
    //
    //$limit - int
    //$offset - int
    //return array if data exists, false if no data
    //
    public function GetFullInfoList($limit, $offset)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                users
            ORDER BY
                id
            DESC
            LIMIT
                :offset, 
                :limit'
        );
        $query->bindValue(':offset',(int)$offset , PDO::PARAM_INT); 
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll();
    }
    //
    //$email - email
    //$password - password
    //$phone - int
    //$access - int
    //$firstname - string
    //$lastname - string
    //return bool
    //
    private function addNew($email, $password, $phone, $access, $firstname, $lastname)
    {
        $state = false;
        $query = $this->connection->prepare('SELECT id FROM users WHERE email = :email OR phone = :phone');
        $query->execute(array(':email' => $email, ':phone' => $phone));
        $result = $query->fetch();
        if(!$result)
        {
            $query = 
               'INSERT INTO
                    users(
                        firstName,
                        lastName,
                        email,
                        phone,
                        pwdHash,
                        access,
                        regDate,
                        isActive
                    ) 
                VALUES
                    (
                    :firstName,
                    :lastName,
                    :email,
                    :phone,
                    :pwdHash,
                    :access,
                    :regDate,
                    :isActive
                    )';
            $query = $this->connection->prepare($query);
            $queryArgsList = array(
                ':firstName' => $firstname,
                ':lastName' => $lastname,
                ':email' => $email,
                ':phone' => $phone, 
                ':pwdHash' => md5($password),
                ':access' => 1,                             
                ':regDate' => date('Y.m.d'),
                ':isActive' => 0
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            }      
        }
        return $state;
    }
    //
    //
    //
    public function AddNewUser($email, $password, $phone)
    {
        $access = 1;
        $firstname = '';
        $lastname = '';
        return $this->addNew($email, $password, $phone, $access, $firstname, $lastname);
    }
    //
    //
    //
    public function AddNewOwner($email, $password, $phone)
    {
        $access = 2;
        $firstname = '';
        $lastname = '';
        return $this->addNew($email, $password, $phone, $access, $firstname, $lastname);
    }
    //
    //
    //
    public function EditUserInfo($id, $email, $phone, $access, $firstname, $lastname)
    {
        $state = false;
        $str = 
           'UPDATE
                users
            SET
                firstName = :firstname,
                lastName = :lastname 
                email = :email,
                phone = :phone,
                access = :access
            WHERE
                id =:id';
        $query =  $this->connection->prepare($str);
        $queryArgsList = array(
            ':id' => $id, 
            ':email' => $email, 
            ':phone' => $phone, 
            ':access' => $access, 
            ':firstname' => $firstname, 
            ':lastname' => $lastname
        ); 
                
        if($query->execute($queryArgsList))
        {
           $state = true;
        }
        return $state;
    }
    //
    //
    //
    public function ChangePassword($oldPass, $newPass, $userId)
    {
        $getPassQuery = $this->connection->prepare(
           'SELECT
                *
            FROM
                users
            WHERE
                id = ?'
        );
        $getPassQuery->execute(array($userId));
        $state = false;
        if($userData = $getPassQuery->fetch())
        {
            if($userData['pwdHash'] == md5($oldPass))
            {
                $updatePassQuery = $this->connection->prepare(
                    'UPDATE
                        users
                     SET
                        pwdHash = ?
                     WHERE
                        id = ?'
                );
                if($updatePassQuery->execute(array(md5($newPass), $userId)))
                {
                    $state = true;
                }
            }
        }
        return $state;          
    }
    //
    //
    //
    public function ChangeName($firstName, $lastName, $id)
    {
        $updateUnameQuery = $this->connection->prepare(
            'UPDATE
                users
             SET
                firstName = ?,
                lastName = ?
             WHERE
                id = ?'
        );
        if($updateUnameQuery->execute(array($firstName, $lastName, $id)))
        {
            return true;
        }
        else return false;
    }
    //
    //
    //
    public function ChangePhone($oldPhone, $newPhone, $userId)
    {
        $getPhoneQuery = $this->connection->prepare(
           'SELECT
                *
            FROM
                users
            WHERE
                id = ?'
        );
        $getPhoneQuery->execute(array($userId));
        $state = false;
        if($userData = $getPhoneQuery->fetch())
        {
            if($userData['phone'] == $oldPhone)
            {
                $updatePhoneQuery = $this->connection->prepare(
                    'UPDATE
                        users
                     SET
                        phone = ?
                     WHERE
                        id = ?'
                );
                if($updatePhoneQuery->execute(array($newPhone, $userId)))
                {
                    $state = true;
                }
            }
        }
        return $state; 
    }
}
?>