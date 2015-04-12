<?php
class DataHandler
{
    private $response;
    private $request;
    private $api;
    //
    //return void
    //
    public function __construct()
    {
        $this->request = $this->initRequest();
        $this->logRequestState($this->request);
        $this->api = $this->initApi();
        $this->sendResponse();
    }
    //
    //return void
    //
    private function logRequestState($request)
    {
        //LogSystem::LogRequest($request);
    }
    //
    //return new Request()
    //
    private function initRequest()
    {
      if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
      {
        $rawPost = json_decode(file_get_contents("php://input"));
        foreach($rawPost as $key => $value)
        {
          $_POST[$key] = $value;
        }
      }
      return new Request($_SERVER['REQUEST_URI'], $_GET, $_POST);
    }
    //
    //return new Api()
    //
    private function initApi()
    {
        return new Api($this->request);
    }
    //
    //return void
    //
    private function sendResponse()
    {
        $response = $this->api->GetResponse();
        $response->Send();
    }
}
?>