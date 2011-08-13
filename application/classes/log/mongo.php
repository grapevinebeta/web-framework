<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 5:33 PM
 */

class Log_Mongo extends Log_Writer
{

    public function write(array $messages)
    {
        if (count($messages)) {
            $mongo = new Mongo();
            $log = Log::instance();
            $internal_db = $mongo->selectDB('internal');
            $logs = $internal_db->selectCollection('logs');
            $logs->batchInsert($messages);
        }

        // TODO : Send out email for logs to alerts@grapevinebeta.com
    }
}
