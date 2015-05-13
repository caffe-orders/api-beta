<?php
class PlacesModel
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    //
    //
    public function AddNewPlace(
        $name,
        $ownerId,
        $gmap,
        $address,
        $phones,
        $workTime,
        $descr,
        $type,
        $outdoors,
        $cuisine,
        $parking,
        $smoking,
        $wifi,
        $avgBill
    )
    {
        $state = false;
        $query = $this->connection->prepare(
           'INSERT
                places(
                    name,
                    ownerId,
                    gmap,
                    address,
                    phones,
                    workTime,
                    descr,
                    type,
                    sumRating,
                    countRating,
                    outdoors,
                    cuisine,
                    parking,
                    smoking,
                    wifi,
                    avgBill
                )
            VALUES(
                :name,
                :ownerId,
                :gmap,
                :address,
                :phones,
                :workTime,
                :descr,
                :type,
                :sumRating,
                :countRating,
                :outdoors,
                :cuisine,
                :parking,
                :smoking,
                :wifi,
                :avgBill
            )'
        );
        $queryArgsList = array(
            ':name' => $name,
            ':ownerId' => $ownerId,
            ':gmap' => $gmap,
            ':address' => $address,
            ':phones' => $phones,
            ':workTime' => $workTime,
            ':descr' => $descr,
            ':type' => $type,
            ':sumRating' => 0,
            ':countRating' => 0,
            ':outdoors' => $outdoors,
            ':cuisine' => $cuisine,
            ':parking' => $parking,
            ':smoking' => $smoking,
            ':wifi' => $wifi,
            ':avgBill' => $avgBill
        );
        if($query->execute($queryArgsList))
        {
            $state = true;
        }
        return state;
    }
    //
    //
    //
    public function EditPlace(
        $placeId,
        $ownerId,
        $name,
        $gmap,
        $address,
        $phones,
        $workTime,
        $descr,
        $type,
        $outdoors,
        $cuisine,
        $parking,
        $smoking,
        $wifi,
        $avgBill
    )
    {
        $state = false;
        $query = $this->connection->prepare(
           'UPDATE
                places
            SET
                name = :name,
                gmap = :gmap,
                address = :address,
                phones = :phones,
                workTime = :workTime,
                descr = :descr,
                type = :type,
                outdoors = :outdoors,
                cuisine = :cuisine,
                parking = :parking,
                smoking = :smoking,
                wifi = :wifi,
                avgBill = :avgBill
            WHERE
                id = :placeId
            AND
                ownerId = :ownerId'
        );
        $queryArgsList = array(
            ':placeId' => $placeId,
            ':name' => $name,
            ':ownerId' => $ownerId,
            ':gmap' => $gmap,
            ':address' => $address,
            ':phones' => $phones,
            ':workTime' => $workTime,
            ':descr' => $descr,
            ':type' => $type,
            ':outdoors' => $outdoors,
            ':cuisine' => $cuisine,
            ':parking' => $parking,
            ':smoking' => $smoking,
            ':wifi' => $wifi,
            ':avgBill' => $avgBill
        );
        if($query->execute($queryArgsList))
        {
            $state = true;
        }
        return state;
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
                places
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
    //$limit - int
    //$offset - int
    //return array if data exists, false if no data
    //
    public function GetPreviewInfoList($limit, $offset)
    {
        $query = $this->connection->prepare(
           'SELECT
                id,
                name,
                address,
                phones,
                type,
                sumRating,
                countRating,
                cuisine,
                wifi,
                avgBill
            FROM
                places
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
    //$id - int
    //return data if data exists, false if no data
    //
    public function GetFullInfo($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                places
            WHERE
                id = :id'
        );
        $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetch();
    }
  //
    //$limit - int
    //$offset - int
    //return array if data exists, false if no data
    //
    public function Search($wifi, $outdoors, $parking, $type, $smoking, $cuisine)
    {
        $query = $this->connection->prepare(
           'SELECT
                id,
                name,
                address,
                phones,
                type,
                sumRating,
                countRating,
                cuisine,
                wifi,
                avgBill
            FROM
                places
            WHERE
                wifi = :wifi
            AND
                outdoors = :outdoors
            AND
                parking = :parking
            OR
                type = :type
            AND
                smoking = :smoking
            OR
                cuisine = :cuisine
            ORDER BY
                id
            DESC'
        );
        $queryArgsList = array(
            ':type' => $type,
            ':outdoors' => $outdoors,
            ':cuisine' => $cuisine,
            ':parking' => $parking,
            ':smoking' => $smoking,
            ':wifi' => $wifi
        );
        return $query->fetchAll();
    }
    //
    //
    //
    public function GetOwned($userId)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                places
            WHERE
                ownerId = :ownerId'
        );
        $query->bindValue(':ownerId',(int)$userId , PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    //
    //
    //
    public function Rate($placeId, $userId, $mark)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                place_rated            
            WHERE 
                userId = :userId
            AND
                placeId = :placeId'
        );
        $query->bindValue(':placeId',(int)$placeId , PDO::PARAM_INT);
        $query->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $query->execute();
        if($isRated = $query->fetchAll())
        {
            return false;
        }
        else
        {
            $setRateQuery = $this->connection->prepare(
                'UPDATE
                    places
                 SET
                    sumRating = sumRating + :mark,
                    countRating = countRating + 1
                 WHERE
                    id = :placeId'
            );
            $setRateQuery->bindValue(':placeId',(int)$placeId , PDO::PARAM_INT);
            $setRateQuery->bindValue(':mark',(int)$mark , PDO::PARAM_INT);
            if($setRateQuery->execute())
            {
                $addPlaceRateDataQuery = $this->connection->prepare(
                    'INSERT
                        place_rated(
                            userId,
                            placeId,
                            mark
                        )
                     VALUES(
                        :userId,
                        :placeId,
                        :mark)'
                );
                $addPlaceRateDataQuery->bindValue(':placeId',(int)$placeId , PDO::PARAM_INT);
                $addPlaceRateDataQuery->bindValue(':mark',(int)$mark , PDO::PARAM_INT);
                $addPlaceRateDataQuery->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
                $addPlaceRateDataQuery->execute();
                return true;
            }
            else
            {
                return false;
            }
        }
    }
  
}