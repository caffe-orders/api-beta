<?php
class DishCategoryModel
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    // $name    - string
    //
    public function AddDishCategory($name)
    {
        $queryState = false;
        
            $query = $this->connection->prepare(
                'INSERT
                    dish_category(
                        name,
                        deleted
                    )
                VALUES(
                    :name,
                    :deleted
                )'
            );
            $queryArgsList = array(
                ':name' => $name,
                ':deleted' => 0
            );
            if($query->execute($queryArgsList))
            {
                $queryState = true;
            } 
        
        return $queryState;
    }
    
    //
    //$accessLevel - int
    //return list of dish category or false if no data
    //
    public function GetDishCategoryList($accessLevel)
    {
        $queryString = 'SELECT id, name 
                        FROM dish_category
                        WHERE deleted = 0';
        if($accessLevel < 3)                        
        {
           $queryString = 'SELECT id, name FROM dish_category
                            WHERE deleted = 0';
        }
        else
        {
            $queryString = 'SELECT * FROM dish_category';
        }
        $query = $this->connection->prepare($queryString);
        $query->execute();
        return $query->fetchAll();
    }
    
    //
    //$id           - int
    //$name         - string
    //return true if dish category Reestablish
    //
    public function UpdateDishCategory($id, $name)
    {
        $query = $this->connection->prepare(
            'UPDATE
                dish_category
            SET
                name = :name
            WHERE
                id = :id'
        );
        $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query->bindValue('name', (string)$name, PDO::PARAM_STR); 
        if($query->execute())
        {
            $state = true;
        }  
        else
        {
            $state = false;
        }
        
        return $state;        
    }
    
    //
    //$id           - int
    //return true if dish category deleted
    //
    public function DeleteDishCategory($id)//not finished
    {
        $state = false;
        $query1 = $this->connection->prepare(
            'SELECT * FROM dish
                WHERE dishCategoryId = :id'
        );
        $query1->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query1->execute();
        if($query1->fetchAll() == null)
        {
            $query = $this->connection->prepare(
                'UPDATE
                    dish_category
                SET
                    deleted = 1
                WHERE
                    id = :id'
            );
            $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
            
            if($query->execute())
            {
                $state = true;
            }  
            else
            {
                $state = false;
            }
        }
        return $state;
    }
    
    //
    //$id           - int
    //return true if dish category Reestablish
    //
    public function ReestablishDishCategory($id)
    {
        $query = $this->connection->prepare(
            'UPDATE
                dish_category
            SET
                deleted = 0
            WHERE
                id = :id'
        );
        $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
        if($query->execute())
        {
            $state = true;
        }  
        else
        {
            $state = false;
        }
        
        return $state;        
    }
}

