<?php
class Places extends Module
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
        $this->get('place', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new HitsModel();
                $id = $args['id'];
                if($hitsCount = $model->GetHitsCount($id))
                {
                    $response->SetJsonContent($hitsCount);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content or something went wrong');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int]) or Incorrect arguments type');
            }
            return $response;
        });
    }
    //
    //
    //
    public function SetPostFunction()
    {
        $this->post('place', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new HitsModel();
                $id = $args['id'];
                if($hitsCount = $model->HitPlace($id))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'Something went wrong');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int]) or Incorrect arguments type');
            }
            return $response;
        });
    }
}