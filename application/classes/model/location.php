<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for representing single location
 */
class Model_Location extends ORM {

    protected $_primary_key = 'location_id';

    public function rules() {
        return array(
            'owner_email' => array(
                array('email', null),
                array('min_length', array(':value',6)),
                array('not_empty', null),
            ),
        );
    }
    
}