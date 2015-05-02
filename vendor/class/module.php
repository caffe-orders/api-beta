<?php
abstract class Module
{
    protected $_getFunctionsList = array();
    protected $_postFunctionsList = array();
    protected $_putFunctionsList = array();
    protected $_deleteFunctionsList = array();
    public static $_accessLevel;
    //
    //return void
    //
    public function __construct()
    {
    }
    //
    //return new Response()
    //
    abstract public function RunModuleFunction($functionType, $functionName, $functionArgs, $accessLevel);
    //
    //return void
    //
    protected function get($functionName, $accessLevel, $functionBody)
    {
        $this->_getFunctionsList[] = array('name' => $functionName,
                                           'access' => $accessLevel,
                                           'function' => $functionBody);
    }
    //
    //return void
    //
    protected function post($functionName, $accessLevel, $functionBody)
    {
        $this->_postFunctionsList[] = array('name' => $functionName,
                                            'access' => $accessLevel,
                                            'function' => $functionBody);
    }
    //
    //return bool
    //
    static public function CheckArgs($parametersArray, $args)
    {
        $argsIsCorrect = true;
        foreach($parametersArray as $key => $value)
        {
            if(!isset($args[$key]))            
            {
                $argsIsCorrect = false;
                break;
            }
            else
            {
                if($value === 'int' && !TypeChecker::IsInt($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
                elseif($value === 'nickname' && !TypeChecker::IsNickname($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
                elseif($value === 'password' && !TypeChecker::IsPassword($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
                elseif($value === 'place' && !TypeChecker::IsPlace($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
                elseif($value === 'string' && !TypeChecker::IsString($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
                elseif($value === 'phone' && !TypeChecker::IsPhone($args[$key]))
                {
                    $argsIsCorrect = false;
                    break;
                }
            }
        }
        return $argsIsCorrect;
    }
    //
    //return new Response();
    //
    static public function RunOtherModuleFunction($moduleName, $functionName, $functionType, $functionArgs, $accessLevel)
    {
        $module = new $moduleName;
        
        return $module->RunModuleFunction($functionType, $functionName, $functionArgs, $accessLevel);
    }
}
?>