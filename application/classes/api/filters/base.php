<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 2:41 AM
 */

    class Api_Filters_Base
    {

        /**
         * @param $doc
         * @return bool
         */
        public function test($doc)
        {
            return true;
        }

        public function key($doc)
        {
            return null;
        }

        public function kind()
        {
            return null;
        }

        public function name($doc)
        {
            return null;
        }

    }
