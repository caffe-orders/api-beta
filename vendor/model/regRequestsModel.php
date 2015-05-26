<?php
/**
 * Description of regRequestsModel
 *
 * @author Broff
 * status
 * 0 - не подтвержден
 * 1 - подтвержден
 * 2 - удален
 */
class regRequestsModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function PrivateList($limit, $offset)
    {
        $query = $this->connection->prepare(
            'SELECT
                    *
            FROM
                registration_requests
            WHERE
                status = 0
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
    
    public function PrivateFullList($limit, $offset)
    {
        $query = $this->connection->prepare(
            'SELECT
                    *
            FROM
                registration_requests
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
    
    public function AddRequest(
        $name,
        $placeType,
        $city ,
        $commentary,
        $userId
    )
    {
        $state = false;
        $queryCheck = $this->connection->prepare(
            'SELECT
                    *
            FROM
                registration_requests
            WHERE
                userId = :userId
            AND
                status = 0'
        );
        $queryCheck->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $queryCheck->execute();
        $requests = $queryCheck->fetchAll();
        if($requests == null)
        {
            $query = $this->connection->prepare(
                'INSERT
                registration_requests
                (

                    userId,
                    name,
                    placeType,
                    city,
                    commentary,                        
                    status
                )
                VALUES
                (
                    :userId,
                    :name,
                    :placeType,
                    :city,
                    :commentary,                    
                    0
                )'
            );
            $queryArgsList = array(
                ':name' => $name,
                ':placeType' => $placeType,
                ':city' => $city,
                ':commentary' => $commentary,
                ':userId' => $userId
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            } 
        }
        return $state;
    }
    
    public function Confirm($requestId)
    {
        return $this->setStatus($requestId, 1);
    }
    
    public function Delete($requestId)
    {
       return $this->setStatus($requestId, 2);
    }
    
    private function setStatus($requestId, $status)
    {
        $state = false;
        $updateOrder = $this->connection->prepare(
            'UPDATE
                registration_requests
            SET
                status = :status
            WHERE
                id = :requestId'
        );
        $updateOrder->bindValue(':requestId',   (int)$requestId , PDO::PARAM_INT);
        $updateOrder->bindValue(':status',      (int)$status , PDO::PARAM_INT);
        if($updateOrder->execute())
        {
            $state = true;
        }
        return $state;
    }
}
