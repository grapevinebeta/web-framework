<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/21/11
 * Time: 12:06 PM
 */

    class Controller_Api_DataProvider_Socials extends Controller_Api_DataProvider_Content
    {

        protected $collection = "socials";
        protected $default_fields = array('status' => 1, 'date' => -1, 'site' => 1, 'network' => 1, 'title' => 1);
        protected $expanded_fields = array('content' => 1, 'notes' => 1, 'identity' => 1);

        protected function setFilters()
        {
            $this->filters = array();
        }
    }
