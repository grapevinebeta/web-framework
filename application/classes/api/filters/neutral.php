<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:41 AM
 */

    class Api_Filters_Neutral extends Api_Filters_Base
    {

        public function test($doc)
        {
            return $doc['score'] >= 3 && $doc['score'] < 4;
        }

        public function key($doc)
        {
            return "neutral";
        }

        public function name($doc)
        {
            return "Neutral";
        }
          public function kind()
        {
            return "status";
        }
    }
