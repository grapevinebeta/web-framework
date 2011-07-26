<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Settings model representing group of settings for a specific location. It is
 * used to get multiple different settings, associated with one location, and
 * placed within separate database records.
 */
class Model_Location_Settings {

    /**
     * ID of the location associated with specific settings' collection
     * @var integer
     */
    private $_location_id = null;

    /**
     * Determines, whether the settings were loaded at least once
     * @var boolean
     */
    private $_loaded = false;

    /**
     * Associative array with names of settings as keys and collections of
     * settings errors as values
     * @var array
     */
    private $_settings = array(
        'competitor'            => array(),
        'gblog_search'          => array(),
        'facebook_oauth_token'  => array(),
        'facebook_page_id'      => array(),
        'filter_search'         => array(),
        'newsletter'            => array(),
        'twitter_account'       => array(),
        'twitter_search'        => array(),
        'youtube_search'        => array(),
    );

    /**
     * Get settings for specific location
     * @param int $location_id ID of the location
     */
    public function __construct($location_id) {
        $this->_location_id = (int)$location_id;
        $this->load();
    }

    /**
     * Load settings
     * @return Model_Location_Settings
     */
    public function load($force_reload = false) {
        if ($force_reload) {
            foreach (array_keys($this->_settings) as $type) {
                $this->_settings[$type] = array(); // reset stored value
            }
        }

        $settings = ORM::factory('location_setting')
                ->where_open()
                    ->where('location_id', '=', (int)$this->_location_id)
                    ->and_where('type', 'IN', array_keys($this->_settings))
                ->where_close()
                ->find_all();
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                $this->_add_location_setting($setting->type, $setting->value);
            }
        }
        return $this;
    }

    /**
     * 
     * @return Model_Location_Settings
     */
    public function reload() {
        return $this->load(true);
    }

    /**
     * Add setting into the place where they are stored to be accessed.
     * @param string $type name of the setting type
     * @param mixed $value
     */
    private function _add_location_setting($type, $value) {
        $this->_settings[$type][] = $value;
        return $this;
    }

    /**
     * Get the setting of specified type or all settings if none specified.
     * @param string $type type of the setting
     * @return array The collection of settings for specified type, or
     *      collection of all settings with types as keys
     */
    public function getSetting($type = null) {
        if ($type) {
            $result = Arr::get($this->_settings, $type);
        } else {
            $result = $this->_settings;
        }
        return $result;
    }

}