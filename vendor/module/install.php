<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of install
 *
 * @author Broff
 */
class install extends Module
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
    public function SetGetFunctions()
    {   
        $this->get('start', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'firstKey' => ''
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $firstKey = $args['firstKey'];
                if($firstKey == 'XrLReftGS6c6YZ2s' )
                {
                    $model = new InstallModel();
                    $model->Start();
                }
            }
            return $response;
        });        
    }
    
    public function SetPostFunctions()
    {
        
    }    
}
