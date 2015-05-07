<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tables
 *
 * @author Broff
 */
class tables extends Module {
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
                'placeId' => 'int',
                'roomId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $model = new TablesModel();
                if ($listTables = $model->GetList($placeId))
                {
                    $response->setJsonContent($listTables);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Get list error');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], roomId[int]) or Incorrect arguments type');
            }
            return $response;
        });        
        
        $this->get('add', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'roomId' => 'int',
                'type' => 'int',
                'posX' => 'int',
                'posY' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $roomId = $args['roomId'];
                $type = $args['type'];
                $posX = $args['posX'];
                $posY = $args['posY'];
                if($posX < 0 || $posX > 100)
                {
                    $posX = 45;
                }
                if($posY < 0 || $posY > 100)
                {
                    $posY = 45;
                }
                $model = new TablesModel();
                if (isset($_SESSION['id']) && $model->AddTable(
                        $placeId,
                        $roomId,
                        $type,
                        $posX,
                        $posY,
                        $_SESSION['id']
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Adding table error');
                }
            } 
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int],roomId[int],type[int],posX[int],postY[int],status[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        $this->get('update', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'placeId' => 'int',
                'roomId' => 'int',
                'type' => 'int',
                'posX' => 'int',
                'posY' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args)) 
            {
                $id = $args['id'];
                $placeId = $args['placeId'];
                $roomId = $args['roomId'];
                $type = $args['type'];
                $posX = $args['posX'];
                $posY = $args['posY'];
                if($posX < 0 || $posX > 100)
                {
                    $posX = 45;
                }
                if($posY < 0 || $posY > 100)
                {
                    $posY = 45;
                }
                $model = new TablesModel();
                if (isset($_SESSION['id']) && $model->UpdateTable(
                        $id,
                        $placeId,
                        $roomId,
                        $type,
                        $posX,
                        $posY,
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
                $response->SetStatusCode(400, 'Arguments not found(id[int],placeId[int],roomId[int],type[int],posX[int],postY[int],status[int]) or Incorrect arguments type');
            }
            return $response;
        });

        $this->get('delete', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $model = new TablesModel();
                if (isset($_SESSION['id']) && $model->DeleteTable($id,$_SESSION['id']))
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
        
        $this->get('reestablish', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $model = new TablesModel();
                if (isset($_SESSION['id']) && $model->ReestablisTable($id, $_SESSION['id']))
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
