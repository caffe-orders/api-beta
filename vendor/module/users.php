<?php
class Users extends Module
{    
    //
    //return void
    //
    public function __construct()
    {        
        $this->model = new UsersModel();
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
        $this->get('infolist', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new UsersModel();
                $limit = $args['limit'];
                $offset = $args['offset'];
                if($usersInfoList = $model->GetPublicInfoList($limit, $offset))
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
        //return all user info GET responce type
        //
        $this->get('fullinfo', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new UsersModel();
                $id = $args['id'];
                if($userInfo = $model->GetFullInfo($id))
                {
                    $response->SetJsonContent($userInfo);
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
        $this->get('info', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new UsersModel();
                $id = $args['id'];
                if($userInfo = $model->GetPublicInfo($id))
                {
                    $response->SetJsonContent($userInfo);
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
        $this->get('fullinfolist', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'limit' => 'int',
                'offset' => 'int'
            );
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new UsersModel();
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
    }
    
    public function SetPostFunctions()
    {
        //
        //
        //
        $this->get('new', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'email' => 'email',
                'password' => 'password',
                'phone' => 'int',
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $email = $args['email'];
                $password = $args['password'];
                $phone = $args['phone'];
                $model = new UsersModel();
                if($model->AddNewUser($email, $password, $phone))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to add new user(already exists)');
                }
            }
            else
            {                
                $response->SetStatusCode(400, 'Arguments not found(email, password, phone) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->get('edit', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'id' => 'int',
                'firstname' => '', 
                'lastname' => '', 
                'email' => 'email', 
                'phone' => 'int',
                'access' => 'int'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $email = $args['email'];
                $id = $args['id'];
                $access = $args['access'];
                $firstname = $args['firstname'];
                $lastname = $args['lastname'];
                $phone = $args['phone'];
                $model = new UsersModel();
                if($model->EditUserInfo($id,
                                        $email,
                                        $phone,
                                        $access,
                                        $firstname,
                                        $lastname))
                {
                    $response->SetStatusCode(200, 'OK');
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to edit user data');
                }
            }
            else
            {                
                $queryResponseData = array('err_code' => '602');
            }
            
            return $response;
        });
    }
}