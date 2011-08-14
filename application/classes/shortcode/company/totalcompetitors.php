<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:44 PM
 */

class Shortcode_Company_TotalCompetitors extends Shortcode_Company_Base
{


    public function execute($document = null)
    {
        $id = $this->location_id($document);
        if (is_int($id)) {
            $settings = new Model_Location_Settings($id);
            $competitors = $settings->getSetting('competitor');
            return is_array($competitors) ? count($competitors) : 0;
        }
        return 0;
    }

}
