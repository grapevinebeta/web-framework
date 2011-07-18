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

        public function key()
        {
            return "alert";
        }

        public function name()
        {
            return "Alert";
        }
    }
