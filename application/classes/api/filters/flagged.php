<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:49 AM
 */

    class Api_Filters_Flagged extends Api_Filters_Base
    {

        public function test($doc)
        {
            return $doc['status'] == 'TODO';
        }

        public function key($doc)
        {
            return "flagged";
        }

        public function name($doc)
        {
            return "Flagged";
        }
          public function kind()
        {
            return "status";
        }
    }
