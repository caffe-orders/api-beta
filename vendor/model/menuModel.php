<?php
/**
 * Description of menuModel
 *
 * @author Broff
 */

class MenuModel {
    
    public function __construct()
    {
        $this->connection = DatabaseProvider::GetConnection();
    }
}
