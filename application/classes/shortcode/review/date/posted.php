<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:26 AM
 */

class Shortcode_Review_Date_Posted extends Shortcode_Base
{

    public function execute($document = null)
    {
        if ($date = Arr::get((array)$document, 'date')) {
            return date('M d,Y h:i A T', strtotime($date));
        }
        return date('M d,Y h:i A T');

    }
}
