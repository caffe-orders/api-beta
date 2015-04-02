<?php
class Comments extends Module
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
        
    }
    //
    //
    //
    public function SetPostFunctions()
    {
        $this->get('new', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'state' => 'bool',
                'text' => '',
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new CommentsModel();
                $placeId = $args['placeId'];
                $state = $args['state'];
                $text = $args['text'];
                if(isset($_SESSION['id']) && $model->AddComment(
                    $_SESSION['id'],
                    $placeId,
                    $state,
                    $text
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to create comment (are you logged in?)');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(placeId, state, text, pubDate) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('list', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new CommentsModel();
                $id = $args['id'];
                if($commentsList = $model->GetCommentsList($id))
                {
                    $response->SetJsonContent($commentsList);
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
    
}