<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/19/11
 * Time: 8:26 AM
 */

class Api_Filters_Site extends Api_Filters_Base
{

    private $_sites;

    function __construct(array $sites, array $filters)
    {
        $this->_sites = $sites;
        $this->_filters = $filters;
    }

    public function test($doc)
    {

        return in_array($doc['site'], $this->_filters);

    }

    public function key($doc)
    {
        return $doc['site'];
    }

    public function kind()
    {
        return "source";
    }

    public function name($doc)
    {
        return ucfirst($doc['site']);
    }
}
