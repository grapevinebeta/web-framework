<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/14/11
 * Time: 1:32 AM
 */

class Shortcode_Review_Keywords_All extends Shortcode_Company_Base
{

    public function execute($document = null)
    {
        $id = $this->location_id($document);
        if ($id) {
            $alert = ORM::factory('alert')
                    ->where('location_id', '=', (int)$id)
                    ->find();

            $words = null;
            if ($alert->loaded()) {
                $words = $alert->criteria;
            } else {
                $words = Model_Alert::$default_tags;
            }
            if (!empty($words)) {
                return array_filter(
                    array_map(
                        'trim',
                        is_array($words) ? $words : explode(',', $words)
                    ), 'strlen'
                );
            }
        }
        return array();

    }
}
