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
}