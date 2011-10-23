<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/17/11
 * Time: 12:33 PM
 */

class SiteFinder_Query
{

    public $zip;
    public $name;
    public $city;
    public $state;
    public $address;
    public $industry;

    public function __toString()
    {
        $location = $this->name;

        $location .= ' ' . $this->address;


        $location .= ' ' . $this->city;


        $location .= ', ' . strtoupper($this->state);


        $location .= ', ' . $this->zip;
        return $location;
    }
}
