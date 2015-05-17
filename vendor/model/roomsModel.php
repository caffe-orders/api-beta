<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of roomsModel
 *
 * @author Broff
 */
class RoomsModel {
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function GetInfoList($placeId)
    {
        $query = $this->connection->prepare(
            'SELECT 
                 * 
             FROM 
                 rooms 
             WHERE
                placeId = :placeId'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function GetPublicInfoList($placeId)
    {
        $query = $this->connection->prepare(
            'SELECT 
                 * 
             FROM 
                 rooms 
             WHERE
                placeId = :placeId
            AND
                deleted = 0'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    //
    //$id - int
    //return array if data exists, false if no data
    //
    public function GetInfo($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                rooms
            WHERE
                id = ?'
        );
        $query->execute(array($id));
        return $query->fetch();
    }
    
    public function AddRoom($placeId, $capacity)
    {
        $roomsList = $this->GetInfoList($placeId);
        $number = 0;
        $id = null;
        if($roomsList != null)
        {
            foreach($roomsList as $room)
            {
                if($room['number'] > $number)
                {
                    $number = $room['number'];
                }
            }
        }
        $number++;
        $placeModel = new PlacesModel();
        $place = $placeModel->GetFullInfo($placeId);
        if($place != null)
        {
            $query = $this->connection->prepare(
                'INSERT
                    rooms(
                        placeId,
                        number,
                        capacity,
                        deleted
                        )
                VALUES(
                        :placeId,
                        :number,
                        :capacity,
                        0
                        )'
                    );
            $queryArgsList = array(
                ':placeId' => $placeId,
                ':number' => $number,
                ':capacity' => $capacity
            );
            if($query->execute($queryArgsList))
            {
                $id = $this->connection->lastInsertId();
            }
        }
        return $id;
    }
    
    public function DeleteRoom($roomId)
    {
        $state = false;
        $query = $this->connection->prepare(
            'UPDATE
                rooms
            SET
                deleted = 1
            WHERE
                id = :id'
        );
        $queryArgsList = array(':id' => $roomId);
        if($query->execute($queryArgsList))
        {
            $state = true;
        }
        
        return $state;
    }
    
    public function ReestablishRoom($roomId)
    {
        $state = false;
        $query = $this->connection->prepare(
            'UPDATE
                rooms
            SET
                deleted = 0
            WHERE
                id = :id'
        );
        $queryArgsList = array(':id' => $roomId);
        if($query->execute($queryArgsList))
        {
            $state = true;
        }
        
        return $state;
    }
    
    public function UpdateRoom($id, $placeId, $number, $capacity)
    {
        $state = false;
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                rooms
            WHERE
                placeId = :placeId
            AND
                number = :number'
        );
        $queryArgsList = array(
            ':placeId' => $placeId,
            ':number' => $number
                );
        $query->execute($queryArgsList);
        $room = $query->fetch();
        
        if($room == null)        
        {
            $query = $this->connection->prepare(
                'UPDATE
                    rooms
                SET
                    placeId = :placeId,
                    number = :number,
                    capacity = :capacity
                WHERE
                    id = :id'
            );
            $queryArgsList = array(
                ':id' => $id,
                ':placeId' => $placeId,
                ':number' => $number,
                ':capacity' => $capacity
                );
            if($query->execute($queryArgsList))
            {
                $state = true;
            }
        }
        return $state;
    }
}
