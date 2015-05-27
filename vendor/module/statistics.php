<?php
/**
 * Description of statistics
 *
 * @author Broff
 */
class statistics extends Module
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
        $this->get('general', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new StatisticsModel();
                $id = $args['id'];
                if(isset($_SESSION['id']) && $statistics = $model->GetGeneral($id, $_SESSION['id']))
                {
                    $response->SetJsonContent($statistics);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id) or Incorrect arguments type');
            }
            return $response;
        });
    }
    
    public function SetPostFunctions()
    {
        
    }
}