<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:00 PM
 */

class Shortcode_Company_Email extends Shortcode_CompanyBase
{

    public function execute($document = null)
    {

        $location = $this->location($document);
        if ($location) {
            return $location->owner_email;
        }
        return null;

    }
}
