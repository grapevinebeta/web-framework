<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:50 AM
 */

    class Api_Filters_Completed extends Api_Filters_Base
    {

        public function test($doc)
        {
            return $doc['status'] == 'CLOSED';
        }

        public function key($doc)
        {
            return "completed";
        }

        public function name($doc)
        {
            return "Completed";
        }
          public function kind()
        {
            return "status";
        }
    }
