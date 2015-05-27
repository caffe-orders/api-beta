<?php
/**
 * Description of statisticsModel
 *
 * @author Broff
 */
class StatisticsModel extends Model {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function GetGeneral($placeId, $userId)
    {
        $statistics = null;
        
        if($this->UserIsOwner($placeId, $userId))
        {
            $query = $this->connection->prepare(
            'SELECT
                 *
             FROM
                 statistics_place
             WHERE
                 placeId = :placeId');
            $queryArgsList = array(':placeId' => $placeId); 
            $query->execute($queryArgsList);

            $statistics = $query->fetch();
            unset($statistics['placeId']);
        }
        
        return $statistics;
    }    
    
    public function OneView($placeId)
    {
        $state = false;
        
        $query = $this->connection->prepare(
        'SELECT
             *
         FROM
             statistics_place
         WHERE
             placeId = :placeId');
        $queryArgsList = array(':placeId' => $placeId); 
        $query->execute($queryArgsList);
        
        if($query->fetch()!=null)
        {        
            $query =  $this->connection->prepare('
                UPDATE
                    statistics_place
                SET
                    views = views + 1
                WHERE
                    placeId = :placeId');
            $queryArgsList = array(':placeId' => $placeId); 

            if($query->execute($queryArgsList))
            {
               $state = true;
            }
        }
        else
        {
            $query = 
               'INSERT INTO
                    statistics_place(
                        placeId,
                        views,
                        orders,
                        corporates
                    ) 
                VALUES
                    (
                        :placeId,
                        1,
                        0,
                        0
                    )';
            $queryStatistics = $this->connection->prepare($query);
            $queryArgsList = array(':placeId' => $placeId); 
            if($queryStatistics->execute($queryArgsList))
            {
                $state = true;
            }      
        }
        return $state;
    }
    
    public function OneOrder($placeId)
    {
         $state = false;
        
        $query = $this->connection->prepare(
        'SELECT
             *
         FROM
             statistics_place
         WHERE
             placeId = :placeId');
        $queryArgsList = array(':placeId' => $placeId); 
        $query->execute($queryArgsList);
        
        if($query->fetch()!=null)
        {        
            $query =  $this->connection->prepare('
                UPDATE
                    statistics_place
                SET
                    orders = orders + 1
                WHERE
                    placeId = :placeId');
            $queryArgsList = array(':placeId' => $placeId); 

            if($query->execute($queryArgsList))
            {
               $state = true;
            }
        }
        else
        {
            $query = 
               'INSERT INTO
                    statistics_place(
                        placeId,
                        views,
                        orders,
                        corporates
                    ) 
                VALUES
                    (
                        :placeId,
                        1,
                        1,
                        0
                    )';
            $queryStatistics = $this->connection->prepare($query);
            $queryArgsList = array(':placeId' => $placeId); 
            if($queryStatistics->execute($queryArgsList))
            {
                $state = true;
            }      
        }
        return $state;
    }
    
    public function OneCorporate($placeId)
    {
        $state = false;
        
        $query = $this->connection->prepare(
        'SELECT
             *
         FROM
             statistics_place
         WHERE
             placeId = :placeId');
        $queryArgsList = array(':placeId' => $placeId); 
        $query->execute($queryArgsList);
        
        if($query->fetch()!=null)
        {        
            $query =  $this->connection->prepare('
                UPDATE
                    statistics_place
                SET
                    corporates = corporates + 1
                WHERE
                    placeId = :placeId');
            $queryArgsList = array(':placeId' => $placeId); 

            if($query->execute($queryArgsList))
            {
               $state = true;
            }
        }
        else
        {
            $query = 
               'INSERT INTO
                    statistics_place(
                        placeId,
                        views,
                        orders,
                        corporates
                    ) 
                VALUES
                    (
                        :placeId,
                        1,
                        0,
                        1
                    )';
            $queryStatistics = $this->connection->prepare($query);
            $queryArgsList = array(':placeId' => $placeId); 
            if($queryStatistics->execute($queryArgsList))
            {
                $state = true;
            }      
        }
        return $state;
    }
    
    public function UserIsOwner($placeId, $userId)
    {
        $state = false;
        $placeModel = new PlacesModel();
        $place = $placeModel->GetFullInfo($placeId);
        unset($placeModel);
        if($place['ownerId'] == $userId)
        {
            $state = true;
        }
        else
        {
            $usersModel = new UsersModel();
            $user = $usersModel->GetFullInfo($userId);
            if($user['access'] > 2)
            {
                $state = true;
            }
        }
        return $state;
    }
}
