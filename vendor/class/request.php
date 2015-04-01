<?php
class Request
{
    private $requestedModuleName = '';
    private $requestedFunctionName = '';
    private $ip = '';
    private $getData = array();
    private $postData = array();
    private $requestMenthod = '';
    private $accessLevel = 0;
    //
    //
    //
    public function __construct($rawUrl, $rawGetData, $rawPostData)
    {
        $url = $this->normalizeUrl($rawUrl);
        $explodeUrl = $this->explodeUrl($url);
        $this->requestedModuleName = $this->getRequestedModuleName($explodeUrl);
        $this->requestedFunctionName = $this->getRequestedFunctionName($explodeUrl);
        $this->getData = $this->getGetData($rawGetData);
        $this->postData = $this->getPostData($rawPostData);
        $this->ip = $this->getRealIp();
        $this->requestMenthod = $this->getRequestMethod();
        $this->checkAccessLevel();
    }
    //
    //
    //
    private function explodeUrl($url)
    {
        $delimetersList = array('/', '?');
        $transUrl = str_replace($delimetersList, $delimetersList[0], $url);
        $urlNodesList = explode($delimetersList[0], $transUrl);
        $requestUrlNodes = array();
        foreach($urlNodesList as $val)
        {
            $requestUrlNodes[] = strtolower($val);
        }
        return $requestUrlNodes;
    }
    //
    //
    //
    private function normalizeUrl($rawUrl)
    {
        $normalizedUrl = strip_tags(htmlentities(trim($rawUrl), ENT_QUOTES));
        return $normalizedUrl;
    }
    //
    //
    //
    private function getRequestMethod()
    {
        return addslashes(htmlentities(strip_tags(trim($_SERVER['REQUEST_METHOD'])), ENT_QUOTES));;
    }
    //
    //
    //
    private function getRequestedModuleName($explodeUrl)
    {
        $requestedModuleName = isset($explodeUrl[1]) ? $explodeUrl[1] : null;
        return $requestedModuleName;
    }
    //
    //
    //
    private function getRequestedFunctionName($explodeUrl)
    {
        $requestedFunctionName = isset($explodeUrl[2]) ? $explodeUrl[2] : null;
        return $requestedFunctionName;
    }
    //
    //
    //
    private function getGetData($rawGetData)
    {
        $normalizedGetData = array();
        foreach($rawGetData as $key => $value)
        {
            $normalizedKey = addslashes(htmlentities(strip_tags(trim($key)), ENT_QUOTES));
            //$normalizedKey = mysqli_escape_string($normalizedKey); bug
            $normalizedValue = addslashes(htmlentities(strip_tags(trim($value)), ENT_QUOTES));
            //$normalizedValue = mysqli_escape_string($normalizedValue); bug
            $normalizedGetData[$normalizedKey] = $normalizedValue;
        }
        return $normalizedGetData;
    }
    //
    //
    //
    private function getPostData($rawPostData)
    {
        $normalizedPostData = array();
        foreach($rawPostData as $key => $value)
        {
            $normalizedKey =addslashes(htmlentities(strip_tags(trim($key)), ENT_QUOTES));
            //$normalizedKey = mysql_real_escape_string($normalizedKey); bug
            $normalizedValue = addslashes(htmlentities(strip_tags(trim($value)), ENT_QUOTES));
            //$normalizedValue = mysql_real_escape_string($normalizedValue); bug
            $normalizedPostData[$normalizedKey] = $normalizedValue;
        }
        return $normalizedPostData;
    }
    //
    //
    //
    public function GetData()
    {
        $normalizedRequestData = array('MODULE_NAME' => $this->requestedModuleName,
                                       'FUNCTION_NAME' => $this->requestedFunctionName,
                                       'REQUEST_METHOD' => $this->requestMenthod,
                                       'IP' => $this->ip,
                                       'GET' => $this->getData,
                                       'POST' => $this->postData,
                                       'ACCESS_LEVEL' => $this->accessLevel);
        return $normalizedRequestData;
    }
    //
    //
    //
    private function getRealIp()
    {
        $headersList = array('HTTP_CLIENT_IP',
                             'HTTP_X_FORWARDED_FOR',
                             'HTTP_X_FORWARDED',
                             'HTTP_X_CLUSTER_CLIENT_IP',
                             'HTTP_FORWARDED_FOR',
                             'HTTP_FORWARDED',
                             'REMOTE_ADDR');
        foreach ($headersList as $key)
        {
            if (array_key_exists($key, $_SERVER) === true)
            {
                foreach (explode(',', $_SERVER[$key]) as $ip)
                {
                    $ip = addslashes(htmlentities(strip_tags(trim($ip)), ENT_QUOTES));; // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                    {
                        return $ip;
                    }
                }
            }
        }
    }
    //
    //
    //
    private function checkAccessLevel()
    {
        if(isset($_SESSION['hash']) && isset($_SESSION['id']))
        {
            $connection = DatabaseProvider::GetConnection();
            $queryString = 
               'SELECT
                    access 
                FROM
                    users
                WHERE
                    id = :id
                AND
                    sessionHash = :hash
                LIMIT 
                    1';
            $query = $connection->prepare($queryString);
            $queryArgsList = array(':id' => $_SESSION['id'],
                                   ':hash' => $_SESSION['hash']); 
            $query->execute($queryArgsList);
            if($userData = $query->fetch())
            {
                $this->accessLevel = (int)$userData['access'];
            }
        }
    }
}
?>