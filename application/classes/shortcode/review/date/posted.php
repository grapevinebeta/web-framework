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
        if (is_array($document) && $date = Arr::get($document, 'date')) {
            return date('hh:i A', strtotime($date));
        }
        return date('hh:i A');

    }
}
