<?php
/**
 * Last amended | 17.04.2015 16.33 |
 *
 * @author Broff
 * Class to perform operations with the dishes in the database
 */
class Menu extends Module
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
        Menu::$_accessLevel = $accessLevel;
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
    //return
    //
    //array( 
    //      id = array( categoryName = "name" ,
    //                  dishlist     = array( id = array(id
    //                                                   name,
    //                                                   description,
    //                                                   cost,
    //                                                   imgSrc,
    //                                                   dishCategoryId
    //                                                   )
    //                                      )
    //                 )                                 
    //     )    
    public function SetGetFunctions()
    { 
        $this->get('list', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new MenuModel();
                $placeId = $args['placeId'];
                if($menuInfoList = $model->GetListMenu($placeId))
                {
                    $response->SetJsonContent($menuInfoList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to show menu list');
                }
            }
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(placeId[int]) or Incorrect arguments type');
            }
            return $response;       
        });
    }
    //
    //
    //
    public function SetPostFunctions()
    {
        $this->get('add', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'dishId' => 'int',
                'placeId' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new MenuModel();
                $dishId = $args['dishId'];
                $placeId = $args['placeId'];
                if(isset($_SESSION['id']) && $model->AddDishInMenu(
                        $_SESSION['id'],
                        Menu::$_accessLevel,
                        $placeId,
                        $dishId
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to add dish in menu. Sure that you have the right to add meals in this cafe?');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(dishId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });    
        
        $this->get('reestablish', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'dishId' => 'int',
                'placeId' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new MenuModel();
                $dishId = $args['dishId'];
                $placeId = $args['placeId'];
                if(isset($_SESSION['id']) && $model->ReestablisDishInMenu(
                        $_SESSION['id'], 
                        Menu::$_accessLevel,
                        $placeId,
                        $dishId
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                    
                {
                    $response->SetStatusCode(400, 'Failed to reeestablis dish in menu');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(dishId[int]) or Incorrect arguments type');
            }
            return $response;
        });
      
        $this->get('delete', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'dishId' => 'int',
                'placeId' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new MenuModel();
                $dishId = $args['dishId'];
                $placeId = $args['placeId'];
                if(isset($_SESSION['id']) && $model->DeleteDishFromMenu(
                        $_SESSION['id'], 
                        Menu::$_accessLevel,
                        $placeId,
                        $dishId
                ))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to delete dish from menu');
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
