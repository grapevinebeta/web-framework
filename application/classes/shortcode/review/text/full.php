<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:27 AM
 */

class Shortcode_Review_Text_Full extends Shortcode_Base
{

    public function execute($document = null)
    {
        if (is_array($document) && $content = Arr::get($document, 'content')) {
            return $content;
        }
        return 'no_content';
    }
}
