<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:27 AM
 */

class Shortcode_Review_Text_Keyword extends Shortcode_Base
{

    public function execute($document = null)
    {
        $rtf = new Shortcode_Review_Text_Full();
        $full = $rtf->execute($document);
        $keywords = new Shortcode_Review_Keywords_All();
        $stop_words = $keywords->execute($document);
        return str_replace(
            array_map(array($this, '_map_search'), $stop_words),
            array_map(array($this, '_map_bold'), $stop_words)
            , $full
        );
    }

    public function _map_search($word)
    {
        return " $word ";
    }

    public function _map_bold($word)
    {
        return "<strong>$word</strong>";
    }
}
