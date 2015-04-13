<?php
/**
 * Description of dishModel
 *
 * @author Broff
 */
class dishModel {
    
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
                        dishCategoryId
                    )
                VALUES(
                    :name,
                    :description,
                    :cost,
                    :imgSrc,
                    :dishCategoryId
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
}
