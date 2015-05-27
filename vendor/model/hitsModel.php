<?php
class HitsModel extends Model
{
    //
    //
    //
    public function GetHitsCount($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                hits 
            FROM
                hits
            WHERE
                placeId = ?'
        );
        $query->execute(array($id));
        return $query->fetch();
    }
    //
    //
    //
    public function GetOrdersCount($id)
    {
        
    }
    //
    //
    //
    public function HitPlace($id)
    {
        $query = $this->connection->prepare(
           'UPDATE
                hits
            SET
                hits = hits + 1
            WHERE
                placeId = ?'
        );
        $query->execute(array($id));
        return $query->fetch();
    }
}