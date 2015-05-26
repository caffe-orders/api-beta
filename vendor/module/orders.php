<?php
/**
 * Description of orders
 *
 * @author Broff
 */
class orders extends Module {
    //
    //return void
    //
    public function __construct() {
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
        
        $this->get('list', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $model = new OrdersModel();
                if (isset($_SESSION['id']) && $model->ListOrders($placeId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error creating new order');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(tableId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->get('new', 1, function($args) {
            $response = new Response();
            $parametersArray = array(
                'tableId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $tableId = $args['tableId'];
                $model = new OrdersModel();
                if (isset($_SESSION['id']) && $model->NewOrder($tableId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error creating new order');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(tableId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->get('reset', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'tableId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $tableId = $args['tableId'];
                $model = new OrdersModel();
                if (isset($_SESSION['id']) && $model->ResetOrder($tableId, $_SESSION['id']))
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
                    $result = $model->Activate($code, 3, $_SESSION['id']);
                    $response->SetStatusCode($result['code'], $result['message']);
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
        
        $this->get('notconfirmed', 1, function($args) {
            $response = new Response();
            $model = new OrdersModel();
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

