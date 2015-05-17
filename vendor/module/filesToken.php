<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of filesToken
 *
 * @author Broff
 */
class FilesToken extends Module
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
        //FilesToken::$_accessLevel = $accessLevel;
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
    
    
   
    public function SetPostFunctions()
    {
        $this->post('add', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'lifeTime' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new FilesTokenModel();
                if($args['lifeTime'] >= 5 || $args['lifeTime'] <= 0)
                {
                    $lifeTime = 10;//minutes
                }
                else
                {
                    $lifeTime = $args['lifeTime'];
                }
                
                if(isset($_SESSION['id']) && $tokenInfo = $model->AddToken(
                        $_SESSION['id'],
                        $lifeTime
                ))
                {
                    $response->SetJsonContent($tokenInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to add file token. Sure that you have the right to add tokens?');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(lifeTime[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });    
        
        $this->get('get', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'token' => '',
                'sessionHash' => ''
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new FilesTokenModel();
                $token = $args['token'];
                $sessionHash = $args['sessionHash'];
                if($tokenInfo = $model->GetToken( 
                        $token,
                        $sessionHash
                ))
                {                    
                    $response->SetJsonContent($tokenInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                    
                {
                    $response->SetStatusCode(400, 'Failed to find token');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(token[string], sessionHash[string]) or Incorrect arguments type');
            }
            return $response;
        });
      
        $this->get('delete', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'token' => '',
                'sessionHash' => ''
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new FilesTokenModel();
                $token = $args['token'];
                $sessionHash = $args['sessionHash'];
                if($model->DeleteToken(
                        $token,
                        $sessionHash
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to delete token');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(token[string], sessionHash[string]) or Incorrect arguments type');
            }
            return $response;
        });
    }
    
    public function SetGetFunctions()
    {
    
    }
    
}
