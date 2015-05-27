<?php
/**
 * Description of menuModel
 *
 * @author Broff
 */

class MenuModel extends Model {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function GetListMenu($placeId)
    {
         $query = $this->connection->prepare(
            'SELECT
                dishId
            FROM
                menu
            WHERE
                placeId = :placeId
            AND
                deleted = 0'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
        $query->execute();
        $dishList = $query->fetchAll();
        if($dishList != null)
        {
            $dishMenuList = array();            
            foreach($dishList as $dish) //ОЧЕНЬ ОЧЕНЬ УЗКОЕ МЕСТО, МНОГО МЕЛКИХ ЗАПРОСОВ ФИКС :D
            {
                $query = $this->connection->prepare(
                    'SELECT
                        id,
                        name,
                        description,
                        cost,
                        dishCategoryId
                    FROM
                        dish
                    WHERE
                        id = :id
                    AND
                        deleted = 0'
                );
                $query->bindValue(':id', (int)$dish['dishId'], PDO::PARAM_INT); 
                $query->execute();                
                if($dishItem = $query->fetch(PDO::FETCH_ASSOC))
                {
                    $dishMenuList[$dish['dishId']] = $dishItem;
                }
            }
            
            $dishModel = new DishCategoryModel();
            $dishCategoryList = $dishModel->GetDishCategoryList(0);
            if($dishCategoryList != null)
            {
                $dishArray = array();
                foreach($dishCategoryList as $dishCategory)
                {
                    $dishArray[$dishCategory['id']] = array(
                        'categoryName' => $dishCategory['name'],
                        'dishList' => array()
                    );
                    foreach($dishMenuList as $dishItem)
                    {
                        if($dishCategory['id'] == $dishItem['dishCategoryId'])
                        {
                            $dishArray[$dishCategory['id']]['dishList'][$dishItem['id']] = $dishItem;
                            unset($dishMenuList[$dishItem['id']]);                          
                        }
                    }
                    if($dishArray[$dishCategory['id']]['dishList'] == null)
                    {
                        unset($dishArray[$dishCategory['id']]); 
                    }
                }
            }
            return $dishArray;
        }
        else
        {
            return null;
        }
    }   
    
    
    public function GetListDish($placeId)
    {
         $query = $this->connection->prepare(
            'SELECT
                dishId
            FROM
                menu
            WHERE
                placeId = :placeId
            AND
                deleted = 0'
        );
        $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
        $query->execute();
        $dishList = $query->fetchAll();
        if($dishList != null)
        {
            $dishMenuList = array();            
            foreach($dishList as $dish) //ОЧЕНЬ ОЧЕНЬ УЗКОЕ МЕСТО, МНОГО МЕЛКИХ ЗАПРОСОВ ФИКС :D
            {
                $query = $this->connection->prepare(
                    'SELECT
                        id,
                        name,
                        description,
                        cost,
                        dishCategoryId
                    FROM
                        dish
                    WHERE
                        id = :id
                    AND
                        deleted = 0'
                );
                $query->bindValue(':id', (int)$dish['dishId'], PDO::PARAM_INT); 
                $query->execute();                
                if($dishItem = $query->fetch(PDO::FETCH_ASSOC))
                {
                    $dishMenuList[$dish['dishId']] = $dishItem;
                }
            }
            
            return $dishMenuList;
        }
        else
        {
            return null;
        }
    }   
    
    public function AddDishInMenu($userId, $accessLevel, $placeId, $dishId)
    {
        $state = false;
        if($accessLevel == 2)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :id
                AND
                    ownerId = :ownerId'
            );
            $query->bindValue(':id', (int)$placeId, PDO::PARAM_INT); 
            $query->bindValue(':ownerId', (int)$userId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);
        }
        else if ($accessLevel == 3)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :placeId'
            );
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);            
        }
        
        if($place != null)
        {
            $query = $this->connection->prepare(
                'SELECT
                    *
                FROM
                    dish
                WHERE
                    id  = :dishId'
            );
            $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT); 
            $query->execute();
            $dish = $query->fetch(PDO::FETCH_ASSOC);
            if($dish == null)
            {
                return false;
            }
            else
            {
                unset($dish);
            }
            
            $query = $this->connection->prepare(
                'SELECT
                    *
                FROM
                    menu
                WHERE
                    dishId  = :dishId
                AND
                    placeId = :placeId'
            );
            $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT); 
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);
            if($place == null)
            {
                $query = $this->connection->prepare(
                    'INSERT
                        menu(
                            placeId,
                            dishId,
                            deleted
                        )
                    VALUES(
                        :placeId,
                        :dishId,
                        0
                    )'
                );
                $queryArgsList = array(
                    ':placeId' => $placeId,
                    ':dishId' => $dishId
                );
                if($query->execute($queryArgsList))
                {
                    $state = true;
                }
            }
            else
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function ReestablishDishInMenu($userId, $accessLevel, $placeId, $dishId)
    {
        $state = false;
        if($accessLevel == 2)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :id
                AND
                    ownerId = :ownerId'
            );
            $query->bindValue(':id', (int)$placeId, PDO::PARAM_INT); 
            $query->bindValue(':ownerId', (int)$userId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);
        }
        else if ($accessLevel == 3)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :placeId'
            );
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);            
        }
        
        if($place != null)
        {
            $query = $this->connection->prepare(
                'SELECT
                    *
                FROM
                    menu
                WHERE
                    dishId = :dishId
                AND
                    placeId = :placeId
                '
            );
            $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT); 
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
            $query->execute();
            $menu = $query->fetch(PDO::FETCH_ASSOC);
            if($menu != null)
            {
                $query = $this->connection->prepare(
                'UPDATE menu SET
                    deleted = 0
                    WHERE
                    placeId = :placeId
                    AND
                    dishId = :dishId
                '
                );
                $query->bindValue(':placeId', (int)$menu['placeId'], PDO::PARAM_INT);
                $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT);
                $query->execute();
                $state = true;
            }
        }
        return $state;
    }
    
    public function DeleteDishFromMenu($userId, $accessLevel, $placeId, $dishId)
    {
        $state = false;
        if($accessLevel == 2)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :id
                AND
                    ownerId = :ownerId'
            );
            $query->bindValue(':id', (int)$placeId, PDO::PARAM_INT); 
            $query->bindValue(':ownerId', (int)$userId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);
        }
        else if ($accessLevel == 3)
        {
            $query = $this->connection->prepare(
                'SELECT
                    id
                FROM
                    places
                WHERE
                    id = :placeId'
            );
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT); 
            $query->execute();
            $place = $query->fetch(PDO::FETCH_ASSOC);            
        }
        
        if($place != null)
        {
            $query = $this->connection->prepare(
                'SELECT
                    *
                FROM
                    menu
                WHERE
                    dishId = :dishId
                AND
                    placeId = :placeId
                '
            );
            $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT); 
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);
            $query->execute();
            $menu = $query->fetch(PDO::FETCH_ASSOC);
            if($menu != null)
            {
                $query = $this->connection->prepare(
                'UPDATE menu SET
                    deleted = 1
                    WHERE
                    placeId = :placeId
                    AND
                    dishId = :dishId
                '
                );
                $query->bindValue(':placeId', (int)$menu['placeId'], PDO::PARAM_INT);
                $query->bindValue(':dishId', (int)$dishId, PDO::PARAM_INT);
                $query->execute();
                $state = true;
            }
        }
        return $state;
    }
}
