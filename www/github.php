<?php

/**
 * script for automatical post receive github repository update
 */

$result = array();

if(isset($_POST['payload'])) {
   
    if(chdir('..')) {
        exec('git pull', $result);
        $result = var_export($result, true);
        $request = var_export($_POST['payload'], true);
        $date = date('Y-m-d H:i:s');
        $log = sprintf("%s : %s \n %s", $date, $request, $result);
        file_put_contents('application/logs/github.log', $log, FILE_APPEND);
        return;
    }
    
}
