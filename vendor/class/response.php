<?php
class Response
{
    private $jsonContent = '';
    private $headers = array();
    //
    //newermind
    //
    public function __construct()
    {
    }
    //
    //return void
    //
    public function SetJsonContent($data)
    {
        $this->jsonContent = json_encode($data);
    }
    //
    //return array
    //
    public function GetJsonContent()
    {
        return json_decode($this->jsonContent);
    }
    //
    //$name - string
    //$value - string
    //return void
    //
    public function SetHeader($name, $value)
    {
        $this->headers[] = $name . ': ' . $value;
    }
    //
    //$rawHeader - string
    //return void
    //
    public function SetRawHeader($rawHeader)
    {
        $this->headers[] = $rawHeader;
    }
    //
    //$code - int
    //$message - string
    //return void
    //
    public function setStatusCode($code, $message)
    {
        $this->SetRawHeader('HTTP/1.0' . ' ' . $code . ' ' . $message);
    }
    //
    //$etag - string or int
    //return void
    //
    public function SetEtag($etag)
    {
        $this->SetHeader('Etag', $etag);
    }
    //
    //$statusCode - int
    //$location - string
    //return void
    //
    public function Redirect($location, $statusCode)
    {
        $this->SetHeader('Location', $location);
    }
    //
    //return array
    //
    public function GetHeaders()
    {
        return $this->headers;
    }
    //
    //return void
    //
    public function Send()
    {
        //we use only json output
        $this->SetHeader('Access-Control-Allow-Origin', '*'); //FIX FIXF XFIXFIXFIXI
        $this->SetHeader('Content-Type', 'application/javascript; charset=utf8');
        //send headers
        foreach($this->headers as $header)
        {
            header($header);
        }
        //send json content
        echo $this->jsonContent;
        flush();
    }
}
?>