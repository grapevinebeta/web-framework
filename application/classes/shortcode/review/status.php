<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:24 AM
 */

class Shortcode_Review_Status extends Shortcode_Base
{

    public function execute($document = null)
    {

        if ($status = Arr::get((array)$document, 'status')) {
            return ucfirst($status);
        }
        return "unknown_status";
    }
}
