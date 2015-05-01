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
        $this->model = new RoomsModel();
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
        $this->get('list', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new RoomsModel();
                $placeId = $args['placeId'];
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
        $this->get('info', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                if($roomInfo = $this->model->GetInfo($id))
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
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->get('update', 2, function($args)
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
                $number = $args['number'];
                $capacity = $args['capacity'];
                if($this->model->UpdateRoom($id, $placeId, $number, $capacity))
                {                    
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
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
        $this->get('delete', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'roomId' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $roomId = $args['roomId'];
                if($this->model->DeleteRoom($roomId))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
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
        $this->get('add', 2, function($args)
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
                $number = $args['number'];
                $capacity = $args['capacity'];
                if($this->model->AddRoom($id, $placeId, $number, $capacity))
                {                    
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            return $response;
        });
    }
    
    public function SetPostFunctions()
    {
        
    }    
}
