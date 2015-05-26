<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rooms
 *
 * @author Broff
 */
class Rooms extends Module
{    
    //
    //return void
    //
    public function __construct()
    {  
        $this->SetGetFunctions();
        $this->SetPostFunctions();
    }
    //
    //return new Response()
    //
    public function RunModuleFunction($functionType, $functionName,  $functionArgs,  $accessLevel)
    {
        $functionName = strtolower($functionName);
        $functionType = strtolower($functionType);
        $outputData = function($args)
        {
            $response = new Response();
            $response->SetStatusCode(400, 'Not found, or low access level');
            return $response;
        };
        
        switch($functionType)
        {
            case "get": 
                foreach($this->_getFunctionsList as $functionData)
                {
                    if($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName)
                    {
                        $outputData = $functionData['function'];
                        break;
                    }
                }
            break;
            case "post": 
                foreach($this->_postFunctionsList as $functionData)
                {
                    if($functionData['access'] <= $accessLevel && $functionData['name'] == $functionName)
                    {
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
    public function SetGetFunctions()
    {   
        //
        //return users list GET responce type
        //
        $this->get('publiclist', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $model = new RoomsModel();
                if($roomsList = $model->GetPublicInfoList($placeId))
                {
                    $response->SetJsonContent($roomsList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        
        
        $this->get('list', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {                
                $placeId = $args['placeId'];
                $model = new RoomsModel();
                if($roomsList = $model->GetInfoList($placeId))
                {
                    $response->SetJsonContent($roomsList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(placeId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->get('info', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $model = new RoomsModel();
                if($roomInfo = $model->GetInfo($id))
                {
                    $response->SetJsonContent($roomInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int]) or Incorrect arguments type');
            }
            return $response;
        });        
    }
    
    public function SetPostFunctions()
    {
        //
        //
        //
        $this->post('update', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'placeId' => 'int',
                'number' => 'int',
                'capacity' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $placeId = $args['placeId'];
                if($args['number'] >= 1)
                {
                    $number = $args['number'];
                }
                else
                {
                    $number = 1;
                }
                $capacity = $args['capacity'];
                $model = new RoomsModel();
                if($roomNumber = $model->UpdateRoom($id, $placeId, $number, $capacity))
                {         
                    $response->SetJsonContent($roomNumber);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Update can not be any room, the room is already occupied');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->post('delete', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'roomId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $roomId = $args['roomId'];
                $model = new RoomsModel();
                if($model->DeleteRoom($roomId))
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
                $response->SetStatusCode(400, 'Arguments not found(roomId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->post('reestablish', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'roomId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $roomId = $args['roomId'];
                $model = new RoomsModel();
                if($model->ReestablishRoom($roomId))
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
                $response->SetStatusCode(400, 'Arguments not found(roomId[int]) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->post('add', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'capacity' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $capacity = $args['capacity'];
                $model = new RoomsModel();
                if($roomInfo = $model->AddRoom($placeId, $capacity))
                {        
                    $response->SetJsonContent($roomInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Error added room');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], capacity[int]) or Incorrect arguments type');
            }
            return $response;
        });
    }    
}
