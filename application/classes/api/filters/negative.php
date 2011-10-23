<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:46 AM
 */

    class Api_Filters_Negative
    {
        public function test($doc)
        {
            return $doc < 3;
        }

        public function key($doc)
        {
            return "negative";
        }

        public function name($doc)
        {
            return "Negative";
        }
          public function kind()
        {
            return "status";
        }
    }
