<?php

/**
 * Description of albums
 *
 * @author Broff
 */
class albums extends Module
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
        $this->get('addimg', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'url' => ''
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $placeId = $args['placeId'];
                $url = $args['url'];
                $model = new AlbumsModel();
                if(isset($_SESSION['id']) && $model->AddImg($placeId, $url, $_SESSION['id']))
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
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], url[string]) or Incorrect arguments type');
            }
            return $response;
        });
        
        
        $this->get('deleteimg', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'url' => ''
            );
            if(Module::CheckArgs($parametersArray, $args))
            {                
                $placeId = $args['placeId'];
                $url = $args['url'];
                $model = new AlbumsModel();
                if(isset($_SESSION['id']) && $model->DeleteImg($placeId, $url, $_SESSION['id']))
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
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], url[string]) or Incorrect arguments type');
            }
            return $response;
        });         
    }
        
    public function SetPostFunctions()
    {
    
    }
    
}

