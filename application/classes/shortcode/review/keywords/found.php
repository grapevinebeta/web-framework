<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 1:32 AM
 */

class Shortcode_Review_Keywords_Found extends Shortcode_Review_Keywords_All
{

    public function execute($document = null)
    {

        $content_words = Arr::get((array)$document, 'content');
        if ($content_words) {
            $words = parent::execute($document);
            $content_words = array_map('trim', explode(' ', $content_words));
            // find all the stop words in the content
            $found = array_intersect($content_words, $words);
            return join(',', $found);
        }
        return 'none_found';

    }
}
