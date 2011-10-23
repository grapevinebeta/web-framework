<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 8/12/11
 * Time: 5:09 PM
 */

class Industry
{


    public static function is_valid($industry)
    {
        $class = new ReflectionClass(get_class(self));
        array_key_exists($industry, array_flip($class->getConstants()));


    }

    public static function sitesFor($industry, $mapping = false)
    {
        $common = array(
            'judysbook.com' => 'Judy\'s Book',
            'yelp.com' => 'Yelp',
            'places.google.com' => 'Google Places',
            'citysearch.com' => 'CitySearch',
            'insiderpages.com' => 'InsiderPages',
            'local.yahoo.com' => 'Local.Yahoo.com (Yahoo! Local)',
            'superpages.com' => 'SuperPages',
            'yellowpages.com' => 'YP.com (Yellow Pages)'


        );
        $industry_sites = array(
            'automotive'
            => array(

                'edmunds.com' => 'Edmunds Link',
                'dealerrater.com' => 'Dealer Rater Link'
            ),

            'restaurant'
            => array(
                'urbanspoon.com' => 'Urbanspoon Link'
            )
        );

        $rtn = array_merge(Arr::get($industry_sites, $industry, array()), $common);
        return array_keys($rtn);
    }

}
