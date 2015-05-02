<?php
class Users extends Module
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
        $this->get('id', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'sessionHash' => ''
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new UsersModel();
                $sessionHash = $args['sessionHash'];
                if($userInfo = $model->GetId($sessionHash))
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
        $this->post('new', 0, function($args)
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
        $this->post('edit', 2, function($args)
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
                $response->SetStatusCode(400, 'Arguments not found(firstname[string],lastname[string]) or Incorrect arguments type');
            }
            
            return $response;
        });
        //
        //
        //
        $this->post('changeuname', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'firstname' => '', 
                'lastname' => '' 
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $firstname = $args['firstname'];
                $lastname = $args['lastname'];
                $userId = $_SESSION['id'];
                $model = new UsersModel();
                if($model->ChangeName($firstname,$lastname, $userId))
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
                $response->SetStatusCode(400, 'Arguments not found(firstname[string],lastname[string]) or Incorrect arguments type');
            }
            
            return $response;
        });
        //
        //
        //
        $this->post('changephone', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'oldphone' => 'phone', 
                'newphone' => 'phone' 
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $oldPhone = $args['oldphone'];
                $newPhone = $args['newphone'];
                $userId = $_SESSION['id'];
                $model = new UsersModel();
                if($tst = $model->ChangePhone($oldPhone, $newPhone, $userId))
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
                $response->SetStatusCode(400, 'Arguments not found(oldphone[phone],newphone[phone]) or Incorrect arguments type');
            }
            
            return $response;
        });
        //
        //
        //
        $this->post('changepass', 1, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'oldpass' => 'password', 
                'newpass' => 'password' 
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $oldPass = $args['oldpass'];
                $newPass = $args['newpass'];
                $userId = $_SESSION['id'];
                $model = new UsersModel();
                if($model->ChangePassword($oldPass, $newPass, $userId))
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
                $response->SetStatusCode(400, 'Arguments not found(oldpass[password],newpass[password]) or Incorrect arguments type');
            }
            
            return $response;
        });
    }
}