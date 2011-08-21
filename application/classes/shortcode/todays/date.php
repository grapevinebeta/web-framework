<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 10:56 PM
 */

class Shortcode_Todays_Date extends Shortcode_Base
{

    public function execute($document = null)
    {
        return date('M d,Y h:i A T');
    }
}
