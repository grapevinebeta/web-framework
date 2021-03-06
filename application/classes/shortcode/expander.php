<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 12:31 AM
 */

class Shortcode_Expander
{


    public function expand($template, $document)
    {
        $this->_document = $document;


        return preg_replace_callback('/\$\$\$(\w+)\$\$\$/', array($this, '_process'), $template);
    }

    function _process($matches)
    {

        $ShortcodeClass = 'Shortcode_' . join('_', array_map('ucfirst', explode('_', $matches[1])));
        if (class_exists($ShortcodeClass)) {

            /**
             * @var $shortcode Shortcode_Base
             */
            $shortcode = new $ShortcodeClass();
            $content = $shortcode->execute($this->_document);
            if ($shortcode->bold) {
                return '<strong>' . $content . '</strong>';
            }
            return $content;


        }
        return $matches[0];
    }
}
