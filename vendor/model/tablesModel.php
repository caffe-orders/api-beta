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
    
    public function GetList($placeId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                tables
            WHERE
                placeId = :placeId
            AND
                deleted = 0'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
        
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
        $state = false;
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
                $state = true;
            } 
        }
        return $state;
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
            $setRateQuery = $this->connection->prepare(
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
            $setRateQuery->bindValue(':id',(int)$id , PDO::PARAM_INT);
            $setRateQuery->bindValue(':placeId',(int)$placeId , PDO::PARAM_INT);
            $setRateQuery->bindValue(':roomId',(int)$roomId , PDO::PARAM_INT);
            $setRateQuery->bindValue(':type',(int)$type , PDO::PARAM_INT);
            $setRateQuery->bindValue(':posX',(int)$posX , PDO::PARAM_INT);
            $setRateQuery->bindValue(':posY',(int)$posY , PDO::PARAM_INT);
            if($setRateQuery->execute())
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function DeleteTable($id, $userId)
    {
        $state = false;
        ///need check user access
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
    
    public function ReestablisTable($id, $userId)
    {
        $state = false;
        ///need check user access
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
        
        if($place!= null && $place['ownerId'] = $userId)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
