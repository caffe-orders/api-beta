<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of albumsModel
 *
 * @author Broff
 */
class albumsModel {
        
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function AddImg($placeId, $url, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $query = $this->connection->prepare(
                'INSERT
                    albums(
                        placeId,
                        url
                        )
                VALUES(
                        :placeId,
                        :url
                        )'
                    );
            $queryArgsList = array(
                ':placeId' => $placeId,
                ':url' => $url
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function DeleteImg($placeId, $url, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $query = $this->connection->prepare(
                'DELETE
            FROM
                albums
            WHERE
                placeId = :placeId
            AND
                url = :url');
            $queryArgsList = array(
                ':placeId' => $placeId,
                ':url' => $url
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            }
        }
        return $state;
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
