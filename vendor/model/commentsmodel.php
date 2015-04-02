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
        $state = false;
        $query = $this->connection->prepare(
           'INSERT
                comments(
                    senderId,
                    placeId,
                    state,
                    text,
                    pubDate
                )
            VALUES(
                :senderId,
                :placeId,
                :state,
                :text,
                :pubDate
            )'
        );
        $queryArgsList = array(
            ':senderId' => $senderId,
            ':placeId' => $placeId,
            ':state' => $state,
            ':text' => $text,
            ':pubDate' => date('Y.m.d')
        );
        if($query->execute($queryArgsList))
        {
            $state = true;
        } 
        return state;
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
                User.firstname,
                User.Lastname
            FROM
                comments Comment,
                users User
            WHERE
                Comment.placeId = :id
            AND
                Comment.senderId = User.id'
        );
        $query->bindValue('id', (int)$id, PDO::PARAM_INT); 
        $query->execute();
        return $query->fetchAll();
    }
}
    