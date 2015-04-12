<?php
class DishCategoryModel
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    // $sessionId - int
    // $senderId - int
    //
    public function AddDishCategory($acessLevel, $name)
    {
        $queryState = false;
        if($acessLevel >= 3)
        {
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
        }
        return $queryState;
    }
    //
    //$sessionId - int
    //return list of dish category or false if no data
    //
    public function GetDishCategoryList($sessionId) // NEED ADDED check access level 
    {
        $queryString = 'SELECT id, name 
                        FROM dish_category
                        WHERE deleted = 0';
        if($sessionId < 8)                        //FIX HERE!!!
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
    //$id - int
    //return true if dish category deleted, false
    //
    public function DeleteDishCategory($sessionId, $id)// NEED FIX access level check
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
        return $state;
    }
}

