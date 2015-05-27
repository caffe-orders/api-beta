<?php

class BackupModel extends Model
{    
    public function Start()
    {
        $backupDatabase = new BackupDatabase(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $backupDatabase->backupTables('*', 'backups');
    }
}

