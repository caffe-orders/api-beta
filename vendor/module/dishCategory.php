<?php
class DishCategory extends Module
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
        DishCategory::$_accessLevel = $accessLevel;
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
                'name' => ''
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishCategoryModel();
                $categoryName = $args['name'];
                
                if($model->AddDishCategory(
                    DishCategory::$_accessLevel,
                    $categoryName
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to create dish category (are you logged in?)');
                    $response->SetJsonContent($_SESSION);
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(name) or Incorrect argument type');
            }
            
            return $response;       
        });
        
        $this->get('list', 0, function($args)
        {
            $response = new Response();
           
            $model = new DishCategoryModel();
            if($dishCategoryList = $model->GetDishCategoryList(DishCategory::$_accessLevel)
            )
            {
                $response->SetJsonContent($dishCategoryList);
                $response->SetStatusCode(200, 'OK');
            }
            else
            {
                $response->SetStatusCode(204, 'No content');
            }
            
            return $response;
        });
      
        $this->get('delete', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishCategoryModel();
                $id = $args['id'];
                if($model->DeleteDishCategory(
                    DishCategory::$_accessLevel,
                    $id
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to delete dish category (are you logged in?)');
                    $response->SetJsonContent($_SESSION);
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
