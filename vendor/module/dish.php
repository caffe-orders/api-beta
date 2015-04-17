<?php
/**
 * Last amended | 17.04.2015 14.03 |
 *
 * @author Broff
 * Class to perform operations with the dishes in the database
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
        $this->get('search', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'name' => ''               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $name = $args['name'];
                $searchList = $model->SearchDish($name);
                if($searchList!=null)
                {
                    $response->SetJsonContent($searchList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to show serched dish list');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit[str], offset[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('info', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'dishId' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $dishId = $args['dishId'];
                
                if($dishInfo = $model->GetDish($dishId))
                {
                    $response->SetJsonContent($dishInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to show dish');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(dishId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('infolist', 3, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $limit = $args['limit'];
                $offset = $args['offset'];
                
                if($dishInfoList = $model->GetFullListDish(
                        $limit,
                        $offset
                ))
                {
                    $response->SetJsonContent($dishInfoList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to show dish list');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit[str], offset[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->get('list', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'               
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $limit = $args['limit'];
                $offset = $args['offset'];
                
                if($dishInfoList = $model->GetPreviewListDish(
                        $limit,
                        $offset
                ))
                {
                    $response->SetJsonContent($dishInfoList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to show dish list');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit[str], offset[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
    }
    //
    //
    //
    public function SetPostFunctions()
    {
        $this->post('new', 2, function($args)
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
                    $response->SetStatusCode(400, 'Failed to create dish');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(name[str],description[str],cost[int],imgSrc[str],dishCategoryId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->post('update', 2, function($args)
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
                    $response->SetStatusCode(400, 'Failed to update dish');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int],name[str],description[str],cost[int],imgSrc[str],dishCategoryId[int]) or Incorrect arguments type');
            }
            
            return $response;       
        });
        
        $this->post('reestablis', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $senderId = $args['id'];
                if($model->ReestablisDish($senderId))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                    
                {
                    $response->SetStatusCode(400, 'Failed to reestablis dish');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(id[int]) or Incorrect arguments type');
            }
            return $response;
        });
      
        $this->post('delete', 2, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new DishModel();
                $senderId = $args['id'];
                if($model->DeleteDish($senderId))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to delete dish');
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