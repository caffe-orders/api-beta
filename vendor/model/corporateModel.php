<?php
/**
 * Description of corporateModel
 *
 * @author Broff
 * 
 * Статусы корпоратива
 * 0 - не подтвержден
 * 1 - подтвержден пользователем
 * 2 - подтвержден администратором
 * 3 - был проведен
 * 4 - отменен
 */
class corporateModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function Info($id)
    {
        $query = $this->connection->prepare(
            'SELECT
                 * 
            FROM
                corporate_orders
            WHERE
                id = :id'
        );
        $queryArr = array(':id' => $id);                  
        $query->execute($queryArr);
        return $query->fetch();
    }
    
    public function NewCorporate($roomId, $dateStart, $dateFinish , $userId)
    {
        $state = false;
        //есть возможность создавать несколько корпоративов возможно необходимо запретить
        if(!$this->NotConfirmed($userId))
        {
            $query = $this->connection->prepare(
                'SELECT
                     * 
                FROM
                    corporate_orders
                WHERE
                    roomId = :roomId
                AND
                    dateStart < :dateStart
                AND
                    dateFinish > :dateFinish
                AND
                    status < 3'
            );
            $queryArr = array(
                ':roomId' => $roomId,
                ':dateStart' => $dateStart,
                ':dateFinish' => $dateFinish                    
            );                  
            $query->execute($queryArr);
            $orders = $query->fetchAll();
            if($orders == null)
            {
                $roomModel = new RoomsModel();
                $room = $roomModel->GetInfo($roomId);
                if($room != null)
                {
                    $query = $this->connection->prepare(
                        'INSERT
                            corporate_orders(
                                userId,
                                placeId,
                                roomId,
                                status,
                                dateStart,
                                dateFinish,
                                code
                             )
                         VALUES(
                                :userId,
                                :placeId,
                                :roomId,
                                0,
                                :dateStart,
                                :dateFinish,
                                0
                         )'
                     );  
                     $queryArgsList = array(
                         ':userId' => $userId,
                         ':placeId' => $room['placeId'],
                         ':roomId' => $roomId,
                         ':dateStart' => $dateStart,
                         ':dateFinish' => $dateFinish
                     );
                     if($query->execute($queryArgsList))
                     {
                         $state = true;
                         $this->sendCode($userId, 'код для подтверждения брони заведения');
                     }
                }
            }
        }
        return $state;
    }
    
    public function Confirm($code, $userId)
    {
        $state = false;
        if($this->NotConfirmed($userId))
        {
            $query = $this->connection->prepare(
            'UPDATE
                corporate_orders
            SET
                status = 1
            WHERE
                userId = :userId
            AND
                status = 0
            AND
                code = :code'
            );
            $query->bindValue(':userId', (int)$userId, PDO::PARAM_INT); 
            $query->bindValue(':code', (int)$code, PDO::PARAM_INT); 
            if($query->execute())
            {
                $state = true;
            }
        }
        return $state;
    }
    
    public function ActivateOrder($corporateId, $userId)
    {
        $state = false;
        $corporate = $this->Info($corporateId);
        if($corporate != null)
        {
            $placeModel = new PlacesModel();
            $place = $placeModel->GetFullInfo($corporate['placeId']);
            if($place['ownerId'] == $userId)
            {
                $query = $this->connection->prepare(
                    'UPDATE
                        corporate_orders
                    SET
                        status = 2
                    WHERE
                        id = :id'
                );
                $query->bindValue(':id', (int)$corporateId, PDO::PARAM_INT); 
                if($query->execute())
                {
                    $state = true;
                }
            }
        }        
        return $state;
    }
    
    public function UpdateOrder($corporateId, $data, $userId)
    {
        $state = false;
        $corporate = $this->Info($corporateId);
        if($corporate != null)
        {
            $placeModel = new PlacesModel();
            $place = $placeModel->GetFullInfo($corporate['placeId']);
            if($place['ownerId'] == $userId)
            {
                $query = $this->connection->prepare(
                    'UPDATE
                        corporate_orders
                    SET
                        data = :data
                    WHERE
                        id = :id'
                );
                $query->bindValue(':id', (int)$corporateId, PDO::PARAM_INT); 
                $query->bindValue(':data', (int)$data, PDO::PARAM_STR); 
                if($query->execute())
                {
                    $state = true;
                }
            }
        }        
        return $state;
    }
    
    public function ResetOrder($corporateId, $userId)
    {
        $state = false;
        $corporate = $this->Info($corporateId);
        if($corporate != null)
        {
            $placeModel = new PlacesModel();
            $place = $placeModel->GetFullInfo($corporate['placeId']);
            if($place['ownerId'] == $userId)
            {
                $query = $this->connection->prepare(
                    'UPDATE
                        corporate_orders
                    SET
                        status = 4
                    WHERE
                        id = :id'
                );
                $query->bindValue(':id', (int)$corporateId, PDO::PARAM_INT); 
                if($query->execute())
                {
                    $state = true;
                }
            }
        }        
        return $state;
    }
    
    //проверяем, нет ли у пользователя других заказов
    public function CheckUser($userId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                corporate_orders
            WHERE
                userId = :userId
            AND
                status < 3'
        );
        $query->bindValue(':userId', (int)$userId, PDO::PARAM_INT);      
        $query->execute();
        $orders = $query->fetchAll();
        if($orders != null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    //проверяем есть ли у пользователя не активированные заказы
    public function NotConfirmed($userId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                corporate_orders
            WHERE
                userId = :userId
            AND
                status = 0'
        );
        $query->bindValue(':userId', (int)$userId, PDO::PARAM_INT);      
        $query->execute();
        $order = $query->fetch();
        if($order != null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }    
    
    //отправляет сообщение с кодом пользователю
    private function sendCode($userId, $message)
    {
        $code = rand(1000, 9999);
        
        $updateOrder = $this->connection->prepare(
            'UPDATE
                corporate_orders
            SET
                code = :code
            WHERE
                userId = :userId
            AND
                status = 0'
        );
        $updateOrder->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $updateOrder->bindValue(':code',(int)$code , PDO::PARAM_INT);
        $updateOrder->execute();
        
        $userModel = new UsersModel();
        $user = $userModel->GetFullInfo($userId);
        
        Sms::send($code.' '.$message, $user['phone']);
    }
}
