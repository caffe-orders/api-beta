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
    //
    //$limit - int
    //$offset - int
    //return array if data exists, false if no data
    //
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
}
