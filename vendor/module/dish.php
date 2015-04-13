<?php

/*
 * Class for addition dishs in DB
 */

/**
 * Description of dish
 *
 * @author Broff
 */
class Dish extends Module
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
        Dish::$_accessLevel = $accessLevel;
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
        $this->get('new', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'name' => '',
                'description' => '',
                'cost' => 'int',
                'imgSrc' => '',
                'dishCategoryId' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $name = $args['name'];
                $description = $args['description'];
                $cost = $args['cost'];
                $imgSrc = $args['imgSrc'];
                $dishCategoryId = $args['dishCategoryId'];
                
                if(isset($_SESSION['id']) && $model->AddDish(
                        $name,
                        $description,
                        $cost, 
                        $imgSrc, 
                        $dishCategoryId 
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to create dish (are you logged in?)');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(name[str],description[str],cost[int],imgSrc[str],dishCategoryId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('update', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'name' => '',
                'description' => '',
                'cost' => 'int',
                'imgSrc' => '',
                'dishCategoryId' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $id = $args['id'];
                $name = $args['name'];
                $description = $args['description'];
                $cost = $args['cost'];
                $imgSrc = $args['imgSrc'];
                $dishCategoryId = $args['dishCategoryId'];
                
                if(isset($_SESSION['id']) && $model->UpdateDish(
                        $id,
                        $name,
                        $description,
                        $cost, 
                        $imgSrc, 
                        $dishCategoryId 
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to update dish (are you logged in?)');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int],name[str],description[str],cost[int],imgSrc[str],dishCategoryId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('list', 0, function($args)///awdawd
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
      
        $this->get('delete', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'senderId' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new CommentsModel();
                $senderId = $args['senderId'];
                if($model->DeleteComment($senderId))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to delete comment');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(senderId) or Incorrect arguments type');
            }
            return $response;
        });
    }
    
}