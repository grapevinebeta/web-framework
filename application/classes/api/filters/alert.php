<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:47 AM
 */

    class Api_Filters_Alert extends Api_Filters_Base
    {

        public function test($doc)
        {
            return $doc['status'] == 'alert';
        }

        public function key($doc)
        {
            return "alert";
        }

        public function name($doc)
        {
            return "Alert";
        }

        public function kind()
        {
            return "status";
        }
    }
