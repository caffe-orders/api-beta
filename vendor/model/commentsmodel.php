<?php
class CommentsModel
{
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    //
    //$senderId - int
    //$placeid - int
    //$state - bool (like or dislike place)
    //text - string
    //return true if OK, false if something went wrong (f.e double comment from one user)
    //
    public function AddComment($senderId, $placeId, $state, $text) //FIXFIXFIXFIXFIXFIX (check the user for sending comemnt)
    {
        $queryState = false;
        $query = $this->connection->prepare(
           'INSERT
                comments(
                    senderId,
                    placeId,
                    state,
                    text,
                    pubDate,
                    deleted
                )
            VALUES(
                :senderId,
                :placeId,
                :state,
                :text,
                :pubDate,
                :deleted
            )'
        );
        $queryArgsList = array(
            ':senderId' => $senderId,
            ':placeId' => $placeId,
            ':state' => ($state == 'true') ? true : false,
            ':text' => $text,
            ':pubDate' => date('Y.m.d'),
            ':deleted' => false
        );
        if($query->execute($queryArgsList))
        {
            $queryState = true;
        } 
        return $queryState;
    }
    //
    //$id - int
    //return list of comments or false if no data
    //
    public function GetCommentsList($id)
    {
        $query = $this->connection->prepare(
           'SELECT
                Comment.senderId,
                Comment.state,
                Comment.text,
                Comment.pubDate,
                User.id,
                User.firstName,
                User.lastName
            FROM
                comments Comment,
                users User
            WHERE
                Comment.deleted = false
            AND
                Comment.placeId = :id
            AND
                Comment.senderId = User.id'
        );
        $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll();
    }
    //
    //$senderId - int
    //return true if comment deleted, false if s.w.w FIX FIX FIX FIX need to check hwo is owner BUG BUG BUG
    //
    public function DeleteComment($senderId)
    {
        $query = $this->connection->prepare(
           'UPDATE
                comments
            SET
                deleted = true
            WHERE
                senderId = :id'
        );
        $query->bindValue('id', (int)$senderId, PDO::PARAM_INT); 
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
    