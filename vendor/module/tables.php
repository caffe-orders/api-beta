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
        
        $this->get('info', 0, function($args) {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $model = new TablesModel();
                if ($table = $model->GetTable($id))
                {
                    $response->setJsonContent($table);
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
        
        $this->get('publiclist', 0, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'roomId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $roomId = $args['roomId'];
                $model = new TablesModel();
                if ($listTables = $model->GetPublicList($placeId, $roomId))
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
        
        $this->get('list', 2, function($args) {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'roomId' => 'int'
            );
            if (Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $roomId = $args['roomId'];
                $model = new TablesModel();
                if ($listTables = $model->GetList($placeId, $roomId))
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
        
        $this->post('add', 2, function($args) {
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
                if (isset($_SESSION['id']) && $table = $model->AddTable(
                        $placeId,
                        $roomId,
                        $type,
                        $posX,
                        $posY,
                        $_SESSION['id']
                ))
                {
                    $response->SetJsonContent($table);
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
        
        $this->post('update', 2, function($args) {
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

        $this->post('delete', 2, function($args) {
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
        
        $this->post('reestablish', 2, function($args) {
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
