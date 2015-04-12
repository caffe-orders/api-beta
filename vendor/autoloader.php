<?php
function autoload($className)
{
    $className = strtolower($className);
    $className = str_replace('_', '', $className);
    $className = str_replace('-', '', $className);
    $pathMap = array(VENDOR_PATH, CLASS_PATH, INTERFACE_PATH, MODEL_PATH, MODULE_PATH, EXTENTION_PATH);
    $fileExtension = '.php';
    foreach($pathMap as $path)
    {
        $fullPath = $path . $className . $fileExtension;
        if(file_exists($fullPath))
        {
            require $fullPath;
        }
    }
}
spl_autoload_register('autoload');
?>