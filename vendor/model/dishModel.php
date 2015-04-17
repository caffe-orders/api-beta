<?php
/**
 * Last amended | 17.04.2015 14.03 |
 *
 * @author Broff
 */
class DishModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    //
    //$name             - string
    //$description      - string
    //$cost             - int
    //$imgSrc           - string
    //$dishCategoryId   - int
    //
    public function AddDish($name, $description, $cost, $imgSrc, $dishCategoryId)
    {
        $state = false;
        
        $query1 = $this->connection->prepare(
            'SELECT * FROM dish_category
                WHERE id = :id'
        );
        $query1->bindValue('id', (int)$dishCategoryId, PDO::PARAM_INT); 
        $query1->execute();
        if($query1->fetchAll() != null)
        {
            $query = $this->connection->prepare(
                'INSERT
                    dish(
                        name,
                        description,
                        cost,
                        imgSrc,
                        dishCategoryId,
                        deleted
                    )
                VALUES(
                    :name,
                    :description,
                    :cost,
                    :imgSrc,
                    :dishCategoryId,
                    0
                )'
            );
            $queryArgsList = array(
                ':name' => $name,
                ':description' => $description,
                ':cost' => $cost,
                ':imgSrc' => $imgSrc,
                ':dishCategoryId' => $dishCategoryId
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            } 
        }
        return $state;
    }
    
    public function UpdateDish($id, $name, $description, $cost, $imgSrc, $dishCategoryId)
    {
        $state = false;
        
        $query1 = $this->connection->prepare(
            'SELECT * FROM dish
                WHERE id = :id'
        );
        $query1->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query1->execute();
        
        $query2 = $this->connection->prepare(
            'SELECT * FROM dish_category
                WHERE id = :id'
        );
        $query2->bindValue('id', (int)$dishCategoryId, PDO::PARAM_INT); 
        $query2->execute();
        
        if($query1->fetchAll() != null && $query2->fetchAll() != null)
        {
            $query = $this->connection->prepare(
                'UPDATE dish SET
                    name = :name,
                    description = :description,
                    cost = :cost,
                    imgSrc = :imgSrc,
                    dishCategoryId = :dishCategoryId
                    WHERE
                    id = :id
                '
            );
            $queryArgsList = array(
                ':id' => $id,
                ':name' => $name,
                ':description' => $description,
                ':cost' => $cost,
                ':imgSrc' => $imgSrc,
                ':dishCategoryId' => $dishCategoryId
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            } 
        }
        return $state;
    }
    //
    //$id  - int
    //
    public function DeleteDish($id)
    {
        $state = false;
        
        $queryCheckIsset = $this->connection->prepare(
            'SELECT * FROM dish
                WHERE id = :id'
        );
        $queryCheckIsset->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $queryCheckIsset->execute();
        
        
        if($queryCheckIsset->fetchAll() != null)
        {
            $query = $this->connection->prepare(
                'UPDATE dish SET
                    deleted = 1
                    WHERE
                    id = :id
                '
            );
            $queryArgsList = array(
                ':id' => $id
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            } 
        }
        return $state;
    }
    //
    //$limit - int
    //$offset - int
    //
    public function GetFullListDish($limit, $offset)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                dish
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
    //
    public function GetFullListDish($limit, $offset)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                dish
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
    //$dishId - int
    //
    public function GetDish($dishId)
    {
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                dish
            WHERE
                id = :id'
        );
        $query->bindValue(':id', (int)$dishId, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll();
    }
    
    //
    //$name - string
    //
    public function SearchDish($name)
    {
        $name = '%'.$name.'%';
        $query = $this->connection->prepare(
           'SELECT
                *
            FROM
                dish
            WHERE
                name
            LIKE 
                :name'
        ); 
        $query->bindValue(':name', $name, PDO::PARAM_STR); 
        $query->execute();
        return $query->fetchAll();
    }
    //
    //$id  - int
    //
    public function ReestablishDish($id)
    {
        $state = false;
        
        $queryCheckIsset = $this->connection->prepare(
            'SELECT * FROM dish
                WHERE id = :id'
        );
        $queryCheckIsset->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $queryCheckIsset->execute();
        
        
        if($queryCheckIsset->fetchAll() != null)
        {
            $query = $this->connection->prepare(
                'UPDATE dish SET
                    deleted = 0
                    WHERE
                    id = :id
                '
            );
            $queryArgsList = array(
                ':id' => $id
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
            } 
        }
        return $state;
    }
}
