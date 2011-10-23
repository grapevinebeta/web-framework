<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:00 PM
 */

class Shortcode_Company_Name extends Shortcode_Company_Base
{

    public function execute($document = null)
    {

        $location = $this->location($document);
        if ($location) {

            return $location->name;

        }
        return null;

    }
}
