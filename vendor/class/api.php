<?php
class Api
{
    private $requestData;
    private $module;
    private $response;
    //
    //$request - new Request()
    //return void
    //
    public function __construct($request)
    {;
        $this->requestData = $request->GetData();
        if($this->loadModule($this->requestData['MODULE_NAME']))
        {
            $this->response = $this->runRequestedFunction($this->requestData);
        }
        else
        {
            $response = new Response();
            $response->SetStatusCode(400, 'Not Found');
            $this->response = $response;
        }
    }
    //
    //$moduleName - string
    //return bool
    //
    private function loadModule($moduleName)
    {
        $fileExtension = '.php';
        if(file_exists(MODULE_PATH . $moduleName . $fileExtension))
        {
            $this->module = new $moduleName;
            return true;
        }
        return false;
    }
    //
    //$requestData - array from Request->GetData
    //return new Response()
    //
    private function runRequestedFunction($requestData)
    {
        $functionType = $requestData['REQUEST_METHOD'];
        $functionName = $requestData['FUNCTION_NAME'];
        $functionArgs = array();
        $functionArgs = $requestData[$requestData['REQUEST_METHOD']];
        $accessLevel = $requestData['ACCESS_LEVEL'];
        $module = $this->module;
        $response = $module->RunModuleFunction($functionType, $functionName, $functionArgs, $accessLevel);
        return $response;
    }
    //
    //return new Response()
    //
    public function GetResponse()
    {
        return $this->response;
    }
}
?>