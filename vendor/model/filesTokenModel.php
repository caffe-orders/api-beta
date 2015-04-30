<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of filesTokenModel
 *
 * @author Broff
 */
class FilesTokenModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }    
    
    public function AddToken($userId, $lifeTime)
    {
        $state = null;
        
        $userModel = new UsersModel();
        $user = $userModel->GetFullInfo($userId);
        $sessionHash = $user['sessionHash'];
        unset($userModel);
        if($sessionHash != null)
        {
            $dateDeleted = date("Y-m-d H:i:s", mktime(date("H"), date("i") + $lifeTime, date("s"), date("m"), date("d"), date("Y")));
           
            $token = md5($sessionHash . $dateDeleted . $lifeTime);
            
            $tokenArray = array();
            $tokenArray['token'] = $token;
            $tokenArray['sessionHash'] = $sessionHash;
            
            $query = $this->connection->prepare(
                'INSERT
                    files_token
                    (
                        token,
                        sessionHash,
                        deleteDate
                    )
                VALUES
                    (
                        :token,
                        :sessionHash,
                        :deleteDate
                    )'
            );
            $queryArgsList = array(
                ':token' => $token,
                ':sessionHash' => $sessionHash,
                ':deleteDate' => $dateDeleted
            );
            if($query->execute($queryArgsList))
            {
                return $tokenArray;
            } 
            
        }
        
        return $state;
    }
    
    
    public function GetToken($token, $sessionHash)
    {
        $this->deleteOldTokens();
        
        $query = $this->connection->prepare(
            'SELECT *
            FROM
                files_token
            WHERE
                token = :token
            AND
                sessionHash = :sessionHash
            '
        );
        $queryArgsList = array(
            ':token' => $token,
            ':sessionHash' => $sessionHash
        );
        $query->execute($queryArgsList);
        $tokenArr = $query->fetch(PDO::FETCH_ASSOC);
        if($tokenArr != null)
        {
            return $tokenArr['token'];
        }
        else
        {
            return null;
        }        
    }   
    
        
    public function DeleteToken($token, $sessionHash)
    {             
        $this->deleteOldTokens();
        
        $query = $this->connection->prepare(
            'DELETE
            FROM
                files_token
            WHERE
                token = :token
            AND
                sessionHash = :sessionHash
            '
        );
        $queryArgsList = array(
            ':token' => $token,
            ':sessionHash' => $sessionHash
        );
           
        if($query->execute($queryArgsList))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    private function deleteOldTokens()
    {
        $dateDelete = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
           
        $query = $this->connection->prepare(
            'DELETE
            FROM
                files_token
            WHERE
                deleteDate <= :dateDelete            
            '
        );
        $queryArgsList = array(
            ':dateDelete' => $dateDelete
        );
           
        if($query->execute($queryArgsList))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}

