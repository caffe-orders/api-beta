<?php
class LogSystem
{
    //
    //return void
    //
    public static function LogRequest($request)
    {
        $connection = DatabaseProvider::GetLogDbConnection();
        $queryString = 'INSERT INTO request_logs(ip, request_type, requested_module, requested_function, access_level, uid, datetime)
            VALUES(:ip, :request_type, :requested_module, :requested_function, :access_level, :uid, :datetime)';
        $requestData = $request->GetData();
        $query = $connection->prepare($queryString);
        $queryArgsList = array(
            ':ip' => $requestData['IP'], 
            ':request_type' => $requestData['REQUEST_METHOD'], 
            ':requested_module' => $requestData['MODULE_NAME'], 
            ':requested_function' => $requestData['FUNCTION_NAME'],
            ':access_level' => $requestData['ACCESS_LEVEL'],
            ':uid' => isset($_SESSION['UID']) ? $_SESSION('UID') : -1,
            ':datetime' => date('Y-m-d H:i:s')
        ); 
        $query->execute($queryArgsList);
    }
    //
    //
    //
    public static function CheckRequestsPerSecondByIp($ip)
    {
        $queryString = 'SELECT datetime FROM request_logs WHERE ip=:ip';
        $query = $dbConnection->prepare($queryString);
        $queryArgsList = array(':ip' => $ip); 
        $query->execute($queryArgsList);
        $lastActivityFromIp = $query->fetchAll();
        foreach($lastActivityFromIp as $datetime)
        {

        }
    }
    //
    //return void
    //
    public static function RebootLogs()
    {
        $connection = DatabaseProvider::GetLogDbConnection();
        $dropTableQuery = 'DROP TABLE request_logs';
        $query = $conection->exec($dropTableQuery);
        $createTableQuery = 
           'CREATE TABLE IF NOT EXISTS 
                request_logs (
                    id INTEGER PRIMARY KEY, 
                    ip TEXT, 
                    request_type TEXT, 
                    requested_module TEXT,
                    requested_function TEXT,
                    access_level TEXT,
                    uid INTEGER,
                    datetime TEXT)
        ';
        $query = $conection->exec($dropTableQuery);
    }
}
?>