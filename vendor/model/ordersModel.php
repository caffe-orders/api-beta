<?php
/**
 * Description of ordersModel
 *
 * @author Broff
* Статусы заказа
 * 1 - не подтвержден
 * 2 - подтвержден пользователем
 * 3 - был проведен
 * 5 - отменен
 */
class ordersModel extends Model {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
    
    public function NewOrder($tableId, $userId)
    {
        $state = false;
        $table = $this->CheckParams($tableId, $userId);
        if($table != null)
        {
            $query = $this->connection->prepare(
               'INSERT
                   table_orders(
                        userId,
                        placeId,
                        roomId,    
                        tableId,
                        status,
                        activateCode,
                        attempts,
                        dateOrder
                    )
                VALUES(
                        :userId,
                        :placeId,
                        :roomId,  
                        :tableId,
                        1,
                        0,
                        3,
                        :dateOrder
                )'
            );            
            $date = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
            $queryArgsList = array(
                ':userId' => $userId,
                ':placeId' => $table['placeId'],
                ':roomId' => $table['roomId'],
                ':tableId' => $tableId,
                ':dateOrder' => $date
            );
            if($query->execute($queryArgsList))
            {
                $state = true;
                $tableModel = new tablesModel();
                $tableModel->OrderTable($tableId);
                $this->sendCode($userId);
                unset($tableModel);
            } 
        }
        return $state;
    }
    
    public function ResetOrder($tableId, $userId)
    {
        $state = false;
        $tableModel = new tablesModel();
        $table = $tableModel->GetTable($tableId);
        if($table != null)
        {
            $placeModel = new PlacesModel();
            $place = $placeModel->GetFullInfo($table['placeId']);
            unset($placeModel);
            if($place != null && $place['ownerId'] = $userId)
            {
                $tableModel = new tablesModel();
                $tableModel->FreeTable($tableId);
                
                $updateOrder = $this->connection->prepare(
                    'UPDATE
                        table_orders
                    SET
                        status = 3
                    WHERE
                        tableId = :tableId
                    AND
                        status = 2
                    OR 
                        status = 1'
                );
                $updateOrder->bindValue(':tableId',(int)$tableId , PDO::PARAM_INT);
                $updateOrder->execute();
                $state = true;
            }
        }
        return $state;
    }
    
    public function Activate($code, $enterCodeTime, $userId)
    {
        $date = date("Y-m-d H:i:s", mktime(date("H"), date("i")- $enterCodeTime, date("s"), date("m") , date("d"), date("Y")));
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                table_orders
            WHERE
                userId = :userId
            AND
                status = 1'
        );
        $query->bindValue(':userId', (int)$userId, PDO::PARAM_INT);      
        $query->execute();
        $order = $query->fetch();
        if($order != null)
        {
            if($order['dateOrder'] >= $date )
            {
                if($order['activateCode'] == $code)
                {
                    $statistic = new StatisticsModel();
                    $statistic->OneOrder($order['placeId']);
                    
                    $table = new tablesModel();
                    $table->ActivateTable($order['tableId']);
                    $this->SetStatus(2, $userId);
                    $result = array(
                        'code' => 200,
                        'message' => 'Table is ordered');
                    return $result;
                }
                else
                {
                    if($order['attempts'] == 1)
                    {
                        $table = new tablesModel();
                        $table->FreeTable($order['tableId']);
                        $this->SetStatus(5, $userId);
                        $result = array(
                            'code' => 400,
                            'message' => 'Attempts is over, order deleted');
                        return $result;
                    }
                    else
                    {
                        $attempts = $order['attempts'] - 1;
                        $this->setAttempts($attempts, $userId);
                        $result = array(
                            'code' => 400,
                            'message' => 'Wrong code, you have '. $attempts .' attempts');
                        return $result;
                    }
                }
            }
            else
            {
                $table = new tablesModel();
                $table->FreeTable($order['tableId']);
                $this->SetStatus(5, $userId);
                $result = array(
                    'code' => 400,
                    'message' => 'Time is over order deleted');
                return $result;
            }
        }
        else
        {
            $result = array(
                    'code' => 300,
                    'message' => 'OrderNotFound');
            return $result;
        }
    } 
    
    public function ListOrders($placeId, $userId)
    {
        $orders = null;
        $placeModel = new PlacesModel();
        $place = $placeModel->GetFullInfo($placeId);
        if($place['ownerId'] == $userId)
        {
            $query = $this->connection->prepare(
                'SELECT
                    * 
                FROM
                    table_orders
                WHERE
                    placeId = :placeId
                AND
                    status < 3'
            );
            $query->bindValue(':placeId', (int)$placeId, PDO::PARAM_INT);      
            $query->execute();
            $orders = $query->fetchAll();
        }
        return $orders;
    }
    
    public function NotConfirmed($userId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                table_orders
            WHERE
                userId = :userId
            AND
                status = 1'
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
    
    public function SetStatus($status, $userId)
    {
        $updateOrder = $this->connection->prepare(
            'UPDATE
                table_orders
            SET
                status = :status
            WHERE
                userId = :userId
            AND
                status = 1'
        );
        $updateOrder->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $updateOrder->bindValue(':status',(int)$status , PDO::PARAM_INT);
        $updateOrder->execute();
    }
    
    public function SetAttempts($attempts, $userId)
    {
        $updateOrder = $this->connection->prepare(
            'UPDATE
                table_orders
            SET
                attempts = :attempts
            WHERE
                userId = :userId
            AND
                status = 1'
        );
        $updateOrder->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $updateOrder->bindValue(':attempts',(int)$attempts , PDO::PARAM_INT);
        $updateOrder->execute();
    }
    
    public function CheckParams($tableId, $userId)
    {
        $table = $this->CheckTable($tableId);
        $user = $this->CheckTable($userId);
        
        if($user && $table != null)
        {           
            return $table;           
        }
        return null;        
    }        
    
    //проверяем, свободен ли столик
    public function CheckTable($id)
    {
        $tableModel = new tablesModel();
        $table = $tableModel->GetTable($id);
        if($table == null)
        {
            return null;
        }
        else
        {
            if($table['status'] == 0)
            {
                return $table;
            }
            else
            {
                $query = $this->connection->prepare(
                   'SELECT
                        * 
                    FROM
                        table_orders
                    WHERE
                        tableId = :tableId
                    AND
                        status < 3'
                );
                $query->bindValue(':tableId', (int)$table['id'], PDO::PARAM_INT);      
                $query->execute();
                $order = $query->fetch();
                if($order == null)
                {
                    $tableModel->FreeTable($order['tableId']);
                    $table['status'] = 0;
                    return $table;
                }
                else
                {
                    return null;
                }
            }
        }
    }    
    
    //проверяем, нет ли у пользователя других заказов
    public function CheckUser($userId)
    {
        $query = $this->connection->prepare(
           'SELECT
                * 
            FROM
                table_orders
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
    
    private function sendCode($userId)
    {
        $code = rand(1000, 9999);
        
        $updateOrder = $this->connection->prepare(
            'UPDATE
                table_orders
            SET
                activateCode = :code
            WHERE
                userId = :userId
            AND
                status = 1'
        );
        $updateOrder->bindValue(':userId',(int)$userId , PDO::PARAM_INT);
        $updateOrder->bindValue(':code',(int)$code , PDO::PARAM_INT);
        $updateOrder->execute();
        
        $userModel = new UsersModel();
        $user = $userModel->GetFullInfo($userId);
        
        Sms::send($code, $user['phone']);
    }
}
