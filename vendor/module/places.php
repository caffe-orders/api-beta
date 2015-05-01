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
        //
        //return users list GET responce type
        //
        $this->get('list', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new PlacesModel();
                $limit = $args['limit'];
                $offset = $args['offset'];
                if($usersInfoList = $model->GetFullInfoList($limit, $offset))
                {
                    $response->SetJsonContent($usersInfoList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //return users list GET responce type
        //
        $this->get('shortlist', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new PlacesModel();
                $limit = $args['limit'];
                $offset = $args['offset'];
                if($usersInfoList = $model->GetPreviewInfoList($limit, $offset))
                {
                    $response->SetJsonContent($usersInfoList);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->get('info', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $id = $args['id'];
                $model = new PlacesModel();
                if($placeInfo = $model->GetFullInfo($id))
                {
                    $response->SetJsonContent($placeInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(limit,offset) or Incorrect arguments type');
            }
            
            return $response;
        });
        //
        //
        //
        $this->get('owned', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'userId' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $userId = $args['userId'];
                $model = new PlacesModel();
                if($placeInfo = $model->GetOwned($userId))
                {
                    $response->SetJsonContent($placeInfo);
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(204, 'No content');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(userId[int]) or Incorrect arguments type');
            }
            
            return $response;
        });
    }
    //
    //
    //
    public function SetPostFunctions()
    {
        //
        //
        // POSSIBLE BUG IN GMAP (NOT CHECK CORRECT GMAP)
        $this->get('new', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'name' => '',
                'ownerId' => 'int',
                'gmap' => '',
                'address' => '',
                'phones' => '',
                'workTime' => '',
                'descr' => '',
                'type' => 'place',
                'outdoors' => 'bool',
                'cuisine' => '',
                'parking' => 'bool',
                'smoking' => 'bool',
                'wifi' => 'bool',
                'avgBill' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new PlacesModel();
                $name = $args['name'];
                $ownerId = $args['ownerId'];
                $gmap = $args['gmap'];
                $address = $args['address'];
                $phones = $args['phones'];
                $workTime = $args['workTime'];
                $descr = $args['descr'];
                $type = $args['type'];
                $outdoors = $args['outdoors'];
                $cuisine = $args['cuisine'];
                $parking = $args['parking'];
                $smoking = $args['smoking'];
                $wifi = $args['wifi'];
                $avgBill = $args['avgBill'];
                if($model->AddNewPlace(
                    $name,
                    $ownerId,
                    $gmap,
                    $address,
                    $phones,
                    $workTime,
                    $descr,
                    $type,
                    $outdoors,
                    $cuisine,
                    $parking,
                    $smoking,
                    $wifi,
                    $avgBill)
                )
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to add new place');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(name, ownerId, address, phones, workTime, descr, type, sumRating, countRating, outdoors, cuisine, parking, smoking, wifi, avgBill) or Incorrect arguments type');
            }
            
            return $response;
        });
        //
        //
        //
        $this->post('rate', 1, function($args) 
        {
            $response = new Response();
            $parametersArray = array(
                'placeId' => 'int',
                'mark' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new PlacesModel();
                $placeId = $args['placeId'];
                $mark = $args['mark'];
                $userId = $_SESSION['id'];
                if($isRated = $model->Rate($placeId, $userId, $mark))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Something went wrong (api error or vote already exists)');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(placeId[int], mark[int]) or Incorrect arguments type');
            }
            return $response;
        });
    }
}