<?php

/**
 * Description of complexDinner
 *
 * @author Broff
 */
class complexDinner extends Module {

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
        
        $this->get('list', 0, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $model = new complexDinnerModel();
                if ($listComplexDinner = $model->PublicList($placeId))
                {
                    $response->setJsonContent($listComplexDinner);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Adding error');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->get('fulllist', 0, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $model = new complexDinnerModel();
                if ($listComplexDinner = $model->PrivateList($placeId))
                {
                    $response->setJsonContent($listComplexDinner);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Adding error');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->post('add', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'name' => '',
                'description' => '',
                'cost' => 'int',
                'day' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $name = $args['name'];
                $description = $args['description'];
                $cost = $args['cost'];
                $day = $args['day'];
                if($day>= 8 || $day<=0)
                {
                    $day = 1;
                }
                $model = new complexDinnerModel();
                if (isset($_SESSION['id']) && $id = $model->AddComplexDinner(
                        $placeId,
                        $name,
                        $description,
                        $cost,
                        $day,
                        $_SESSION['id']
                ))
                {
                    $response->SetJsonContent($id);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Adding error');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], name[str],description[str],cost[int],day[int]) or Incorrect arguments type');
            }
            return $response;
        });

        $this->post('edit', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'placeId' => 'int',
                'name' => '',
                'description' => '',
                'cost' => 'int',
                'day' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args)) 
            {
                $id = $args['id'];
                $placeId = $args['placeId'];
                $name = $args['name'];
                $description = $args['description'];
                $cost = $args['cost'];
                $day = $args['day'];
                if($day >= 8 || $day<=0)
                {
                    $day = 1;
                }
                $model = new ComplexDinnerModel();
                if (isset($_SESSION['id']) && $model->UpdateComplexDinner(
                        $id,
                        $placeId,
                        $name,
                        $description,
                        $cost,
                        $day,
                        $_SESSION['id']
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Update false');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(id[int],placeId[int], name[str],description[str],cost[int],day[int]) or Incorrect arguments type');
            }
            return $response;
        });
      
        $this->post('delete', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'placeId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $placeId = $args['placeId'];
                $model = new ComplexDinnerModel();
                if (isset($_SESSION['id']) && $model->DeleteComplexDinner($id, $placeId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Delete error');
                }
            }
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(id[int], placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->post('reestablish', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'placeId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $placeId = $args['placeId'];
                $model = new ComplexDinnerModel();
                if (isset($_SESSION['id']) && $model->ReestablisComplexDinner($id, $placeId, $_SESSION['id']))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Reestablis error');
                }
            }
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(id[int], placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
    }

    public function SetPostFunctions() {
        
    }

}
