<?php
class Auth extends Module
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
    
    public function SetGetFunctions()
    {   
        $this->post('login', 0, function($args)
        {
            $response = new Response();
            $parametersArray = array(
                'email' => 'email',
                'password' => 'password'
            ); 
            if(Module::CheckArgs($parametersArray, $args))
            {
                $model = new AuthModel();
                $email = $args['email'];
                $password = $args['password'];
                if($model->Login($email, $password))
                {
                    $response->SetStatusCode(200, 'OK');
                    $usersModel = new UsersModel();
                    $response->SetJsonContent($usersModel->GetFullInfo($_SESSION['id']));
                }
                else
                {
                    $response->SetStatusCode(400, 'Failed to auth');
                }
            }
            else
            {
                $response->SetStatusCode(400, 'Arguments not found(email, password) or Incorrect arguments type');
            }
            return $response;
        });
        //
        //
        //
        $this->post('logout', 1, function($args) {
            $response = new Response();
            $response->SetStatusCode(200, 'OK');
            $authModel = new AuthModel();
            $authModel->logOut();
            
            return $response;
        });
    }
    
    public function SetPostFunctions()
    {
    }
}