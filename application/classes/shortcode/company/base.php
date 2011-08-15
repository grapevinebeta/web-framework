<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:02 PM
 */

class Shortcode_Company_Base extends Shortcode_Base
{

    protected function location_id($document)
    {
        if (is_null($document)) {
            return 0;
        }
        if (is_int($document)) {
            return $document;
        }

        if (is_array($document) && isset($document['loc'])) {
            return $document['loc'];
        }
        return 0;

    }

    /**
     * @param $document
     * @return ORM
     */
    protected function location($document)
    {
        $id = $this->location_id($document);
        if ($id && is_int($id)) {
            $location = ORM::factory('location', $id);
            if ($location->loaded) {
                return $location;
            }
        }
        return null;
    }
}
