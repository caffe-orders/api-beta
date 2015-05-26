<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tablesModel
 *
 * @author Broff
 */
class tablesModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function GetTable($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                tables
            WHERE
                id = :id'
        );
        $query->bindValue(':id', (int)$id, PDO::PARAM_INT);  
        $query->execute();
        return $query->fetch();
    }
    
    public function GetList($placeId,$roomId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                tables
            WHERE
                placeId = :placeId
            AND
                roomId = :roomId'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);        
        $query->bindValue(':roomId', (int)$roomId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    
    
    public function GetPublicList($placeId, $roomId)
    {
        $query = $this->connection->prepare(
           'SELECT
                type,
                posX,
                posY,               
                status 
            FROM
                tables
            WHERE
                placeId = :placeId
            AND
                roomId = :roomId
            AND
                deleted = 0'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
        $query->bindValue(':roomId', (int)$roomId, PDO::PARAM_INT);
        
        $query->execute();
        return $query->fetchAll();
    }
    
    public function AddTable(
        $placeId,
        $roomId,
        $type,
        $posX,
        $posY,
        $userId
    )
    {
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $query = $this->connection->prepare(
               'INSERT
                   tables(
                        placeId,
                        roomId,
                        type,
                        posX,
                        posY,
                        status,
                        deleted
                    )
                VALUES(
                        :placeId,
                        :roomId,
                        :type,
                        :posX,
                        :posY,
                        0,
                        0
                )'
            );
            $queryArgsList = array(
                ':placeId' => $placeId,
                ':roomId' => $roomId,
                ':type' => $type,
                ':posX' => $posX, 
                ':posY' => $posY
            );
            if($query->execute($queryArgsList))
            {
                $id = $this->connection->lastInsertId();                
                return array(
                    'id' => $id,
                    'placeId' => $placeId,
                    'roomId' =>$roomId,
                    'type' => $type,
                    'posX' => $posX,
                    'posY' => $posY,
                    'status' => 0,
                    'deleted' => 0
                );
            } 
        }
        return null;
    }
    
    public function UpdateTable(
        $id,
        $placeId,
        $roomId,
        $type,
        $posX,
        $posY,
        $userId
    )
    {
        $state = false;
        if($this->userOwnedRooms($placeId, $roomId, $userId))
        {
            $updateTable = $this->connection->prepare(
                'UPDATE
                    tables
                 SET
                    placeId = :placeId,
                    roomId = :roomId,
                    type = :type,
                    posX = :posX,
                    posY = :posY
                 WHERE
                    id = :id'
            );
            $updateTable->bindValue(':id',(int)$id , PDO::PARAM_INT);
            $updateTable->bindValue(':placeId',(int)$placeId , PDO::PARAM_INT);
            $updateTable->bindValue(':roomId',(int)$roomId , PDO::PARAM_INT);
            $updateTable->bindValue(':type',(int)$type , PDO::PARAM_INT);
            $updateTable->bindValue(':posX',(int)$posX , PDO::PARAM_INT);
            $updateTable->bindValue(':posY',(int)$posY , PDO::PARAM_INT);
            if($updateTable->execute())
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function OrderTable($id)
    {
         $Query = $this->connection->prepare(
            'UPDATE
                tables
             SET
               status = 1
             WHERE
                id = :id'
        );
        $Query->bindValue(':id',(int)$id , PDO::PARAM_INT);
        if($Query->execute())
        {
            return true;
        }
        return false;
    }
    
    public function ActivateTable($id)
    {
         $Query = $this->connection->prepare(
            'UPDATE
                tables
             SET
               status = 2
             WHERE
                id = :id'
        );
        $Query->bindValue(':id',(int)$id , PDO::PARAM_INT);
        if($Query->execute())
        {
            return true;
        }
        return false;
    }
    
    public function FreeTable($id)
    {
         $setRateQuery = $this->connection->prepare(
            'UPDATE
                tables
             SET
               status = 0
             WHERE
                id = :id'
        );
        $setRateQuery->bindValue(':id',(int)$id , PDO::PARAM_INT);
        if($setRateQuery->execute())
        {
            return true;
        }
        return false;
    }
    
    public function DeleteTable($id, $userId)
    {
        $state = false;
        if($this->userOwnedTablle($id, $userId))
        {
            $query = $this->connection->prepare(
                'UPDATE 
                    tables
                SET
                    deleted = 1
                WHERE
                    id = :id
                '
                );
            $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
            if($query->execute())
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function ReestablishTable($id, $userId)
    {
        $state = false;
        if($this->userOwnedTablle($id, $userId))
        {
            $query = $this->connection->prepare(
                'UPDATE 
                    tables
                SET
                    deleted = 0
                WHERE
                    id = :id
                '
                );
            $query->bindValue(':id', (int)$id, PDO::PARAM_INT);
            if($query->execute())
            {
                $state = true;
            }
        }
        return $state;
    }
    
    private function  userOwnedTablle($id, $userId)
    {
        $table = $this->GetTable($id);
        if($table != null)
        {
            return $this->userOwnedPlaces($table['placeId'], $userId);
        }
    }
    
    private function userOwnedRooms($placeId, $roomId, $userId)
    {
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $roomModel = new RoomsModel();
            $room = $roomModel->GetInfo($roomId);
            if($room['placeId'] == $placeId)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    private function userOwnedPlaces($placeId, $userId)
    {
        $placeModel = new PlacesModel();
        $place = $placeModel->GetFullInfo($placeId);
        
        if($place!= null && $place['ownerId'] == $userId)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
