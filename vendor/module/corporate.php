<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of corporate
 *
 * @author Broff
 */
class corporate extends Module {
    
     public function __construct()
    {
        $this->SetGetFunctions();
        $this->SetPostFunctions();
    }

    //
    //return new Response()
    //
    public function RunModuleFunction($functionType, $functionName, $functionArgs, $accessLevel) {
            $functionName = strtolower($functionName);
            $functionType = strtolower($functionType);
            $outputData = function($args) {
            $response = new Response();
            $response->SetStatusCode(400, 'Not found, or low access level');
            return $response;
        };

        switch ($functionType) {
            case "get":
                foreach ($this->_getFunctionsList as $functionData) {
                    if ($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName) {
                        $outputData = $functionData['function'];
                        break;
                    }
                }
                break;
            case "post":
                foreach ($this->_postFunctionsList as $functionData) {
                    if ($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName) {
                        $outputData = $functionData['function'];
                        break;
                    }
                }
                break;
        }

        return $outputData($functionArgs);
    }

    //
    //
    //
    public function SetGetFunctions() {
        //пользователь подает заявку на бронирование кафе
        $this->get('new', 1, function($args) {
            $response = new Response();
            $parametersArray = array(                
                'roomId' => 'int',
                'dateStart' => '',
                'dateFinish' => ''
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $roomId = $args['roomId'];
                $dateStart = date("Y-m-d H:i:s",$args['dateStart']);
                $dateFinish = date("Y-m-d H:i:s",$args['dateFinish']);  
                
                $model = new CorporateModel();
                
                if(isset($_SESSION['id']) && $dateStart < $dateFinish && $model->NewCorporate($roomId, $dateStart, $dateFinish, $_SESSION['id']) )
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error creating new corporate');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(roomId[int], dateStart[date], dateFinish[date]) or Incorrect arguments type');
            }
            return $response;
        });
        //пользователь подтверждает свою заявку вводом кода из смс
        $this->get('confirm', 1, function($args) {
            $response = new Response();
            $parametersArray = array(
                'code' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $code = $args['code'];
                $model = new OrdersModel();
                if (isset($_SESSION['id']))
                {
                    $result = $model->Confirm($code, $_SESSION['id']);
                    $response->SetStatusCode(200, 'Corporate confirmed');
                }
                else
                {
                    $response->SetStatusCode(300, 'Please authorize');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(code[int]) or Incorrect arguments type');
            }
            return $response;
        });
        //администратор заведения подтверждает заказ
        $this->get('activate', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'corporateId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $corporateId = $args['corporateId'];
                $model = new CorporateModel();
                if (isset($_SESSION['id']) && $model->ActivateOrder($corporateId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error activate order');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(corporateId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        //администратор заведения обновляет информацию о корпоративе
        $this->get('update', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'corporateId' => 'int',
                'data' => ''
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $corporateId = $args['corporateId'];
                $data = $args['data'];
                $model = new CorporateModel();
                if (isset($_SESSION['id']) && $model->UpdateOrder($corporateId, $data, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error update order');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(corporateId[int], data[str]) or Incorrect arguments type');
            }
            return $response;
        });
        // администратор кафе удаляет заявку на корпоратив
        $this->get('reset', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'corporateId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $orporateId = $args['orporateId'];
                $model = new CorporateModel();
                if (isset($_SESSION['id']) && $model->ResetOrder($orporateId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error reset order');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(tableId[int]) or Incorrect arguments type');
            }
            return $response;
        });
                
        //фция сообщает о том, есть ли у пользователя не подтвержденные заявки
        $this->get('notconfirmed', 1, function($args) {
            $response = new Response();
            $model = new CorporateModel();
            if (isset($_SESSION['id']))
            {
                if($model->NotConfirmed($_SESSION['id']))
                {
                    $response->SetJsonContent(array(true));
                    $response->SetStatusCode(200, 'Order found'); 
                }
                else
                {
                    $response->SetJsonContent(array(false));
                    $response->SetStatusCode(200, 'Orders not found');        
                }
            }
            else
            {
                $response->SetStatusCode(300, 'Please authorize');
            }            
            return $response;
        });
    }

    public function SetPostFunctions() {
                 
    }

}
