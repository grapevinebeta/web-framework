<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for representing single company. One company may have multiple
 * locations.
 */
class Model_Company extends ORM {

    /**
     * Get locations associated with current company
     * @return Database_Result collection of Model_Location objects
     */
    public function getLocations() {

        if (empty($this->id)) {
            /**
             * @todo Implement custom exception class applicable for such cases
             */
            throw new Kohana_Exception('Company object has not been loaded');
        }

        $locations = ORM::factory('location')
                ->where('company_id', '=', (int)$this->id)
                ->find_all();

        return $locations;

    }
    
}