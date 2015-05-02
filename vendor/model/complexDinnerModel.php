<?php
/**
 * Description of complexDinnerModel
 *
 * @author Broff
 */
class complexDinnerModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function AddComplexDinner($placeId, $name, $description, $cost, $imgSrc, $day, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $placeModel = new PlacesModel();
            if($placeModel->GetFullInfo($placeId) != null)
            {
                $query = $this->connection->prepare(
                    'INSERT
                        complex_dinner(
                            placeId,
                            deleted,
                            name,
                            description,
                            cost,
                            imgSrc,
                            day
                        )
                    VALUES(
                        :placeId,
                        0,
                        :name,
                        :description,
                        :cost,
                        :imgSrc,
                        :day
                    )'
                );
                $queryArgsList = array(
                    ':placeId' => $placeId,
                    ':name' => $name,
                    ':description' => $description,
                    ':cost' => $cost,
                    ':imgSrc' => $imgSrc,
                    ':day' => $day
                );
                if($query->execute($queryArgsList))
                {
                    $state = true;
                } 
            }
        }
        return $state;
    }
    
    public function UpdateComplexDinner($id,$placeId,$name,$description,$cost,$imgSrc,$day, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $placeModel = new PlacesModel();
            if($placeModel->GetFullInfo($placeId) != null)
            {
                $query = $this->connection->prepare(
                    'UPDATE
                        complex_dinner
                    SET
                        placeId = :placeId,
                        name = :name,
                        description = :description,
                        cost = :cost,
                        imgSrc = :imgSrc,
                        day = :day
                    WHERE
                        id = :id'
                );
                $queryArgsList = array(
                    ':id' => $id,
                    ':placeId' => $placeId,
                    ':name' => $name,
                    ':description' => $description,
                    ':cost' => $cost,
                    ':imgSrc' => $imgSrc,
                    ':day' => $day
                );
                if($query->execute($queryArgsList))
                {
                    $state = true;
                } 
            }
        }
        return $state;
    }
    
    public function DeleteComplexDinner($id, $placeId, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $query = $this->connection->prepare(
                'UPDATE 
                    complex_dinner
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
    
    public function ReestablisComplexDinner($id, $placeId, $userId)
    {
        $state = false;
        if($this->userOwnedPlaces($placeId, $userId))
        {
            $query = $this->connection->prepare(
                'UPDATE 
                    complex_dinner
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