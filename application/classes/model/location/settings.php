<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Settings model representing group of settings for a specific location. It is
 * used to get multiple different settings, associated with one location, and
 * placed within separate database records.
 */
class Model_Location_Settings {

    /**
     * Associative array with names of settings as keys and collections of
     * settings errors as values
     * @var array
     */
    private $_settings = array(
        'competitor'            => null,
        'newsletter'            => null,
        'facebook_oauth_token'  => null,
        'twitter_search'        => null,
        'twitter_account'       => null,
        'filter_search'         => null,
        'gblog_search'          => null,
        'youtube_search'        => null,
    );

    public function  __construct($location_id) {
        
    }

}