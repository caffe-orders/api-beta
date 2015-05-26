<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of installModel
 *
 * @author Broff
 */
class installModel
{
    public function start($route = 'resources/api.sql')
    {
        if(file_exists($route))
        {
            $myConnect = mysql_connect(DB_HOST, DB_USER, DB_PASS); 
            mysql_select_db(DB_NAME, $myConnect) or die();
            $query = file_get_contents($route);    
            mysql_query($query);
            mysql_close();        
        }
    }
}
