<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:29 AM
 */

class Shortcode_Review_Site_Source extends Shortcode_Base
{

    public function execute($document = null)
    {
        if ($site = Arr::get((array)$document, 'site')) {
            return $site;
        }
        return 'unknown_source';
    }
}
