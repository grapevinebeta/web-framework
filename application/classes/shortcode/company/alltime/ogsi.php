<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/13/11
 * Time: 11:16 PM
 */

class Shortcode_Company_Alltime_Ogsi extends Shortcode_Company_30d_Ogsi
{


    protected function post()
    {
        return array('alltime' => true); // use alltime,)
    }
}
