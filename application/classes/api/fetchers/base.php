<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/21/11
 * Time: 7:32 PM
 */

    class Api_Fetchers_Base
    {

        protected $_date;

        public function range(MongoDate $start, MongoDate $end = null)
        {
            if (is_null($end)) {
                $this->_date = $start;
            } else {
                $this->_date = array('$gte' => $start, '$lte' => $end);

            }
            return $this;
        }
    }
