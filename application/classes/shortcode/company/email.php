<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:00 PM
 */

class Shortcode_Company_Email extends Shortcode_Company_Base
{

    public function execute($document = null)
    {

        $location = $this->location($document);
        if ($location) {
            $email = $location->owner_email;
            if ($email == 'dummy@grapevinebeta.com') {
                return null;
            }
        }
        return null;

    }
}
