<?php
class DatabaseProvider
{
    private static $instance = null;
    private static $logInstance = null;
    //
    //return void
    //
    private function __construct()
    {
        //You shall not pass!
    }
    //
    //return void
    //
    private function __clone()
    {
        //Me not like clones! Me smash clones!
    }
    //
    //return new PDO()
    //
    public static function GetConnection()
    {
        if (!isset(self::$instance)) 
        {
            $dsn =  DB_TYPE.":dbname=" . DB_NAME . ";host=" . DB_HOST;
            
            try
            {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS);                
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->query("set names utf8");
            }
            catch (PDOException $e)
            {            
                echo 'Error : '.$e->getMessage();
                exit();            
            }
        }
        return self::$instance;
    }
    //
    //return new PDO()
    //
    public static function GetLogDbConnection()
    {
        if (!isset(self::$logInstance)) 
        {
            $dsn = 'sqlite:' . LOG_PATH . 'log.sqlite3';
            
            try
            {
                self::$logInstance = new PDO($dsn);                
                self::$logInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$logInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {            
                echo 'Error : '.$e->getMessage();
                exit();            
            }
        }
        return self::$logInstance;
    }
    //
    //return int
    //
    public static function LastInsertedId() 
    {
       return self::$instance->lastInsertId();
    }
}
?>