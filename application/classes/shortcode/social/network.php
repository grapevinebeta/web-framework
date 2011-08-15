<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:22 AM
 */

class Shortcode_Social_Network extends Shortcode_Base
{

    public function execute($document)
    {

        if (is_array($document) && ($network = Arr::get($document, 'network'))) {
            return $network;
        }
        return null;
    }
}
