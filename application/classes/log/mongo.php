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
            $internal_db = $mongo->selectDB('logs');
            $logs = $internal_db->selectCollection('dashboard');
            $logs->batchInsert($messages);
            if (Kohana::config("global.send_alerts")) {
                $mailer = new Model_Mailer();
                $sent = $mailer->send(
                    'alerts@pickgrapevine.com', 'New Alert',
                        '<div>' . print_r($messages, true) . '</div>',
                    null, 'app@pickgrapevine.com'
                );
            }
           
        }

        // TODO : Send out email for logs to alerts@grapevinebeta.com
    }
}
