<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for representing single location
 */
class Model_Location extends ORM {

    protected $_primary_key = 'location_id';

    public function rules() {
        return array(
            'location_name' => array(
                array('max_length', array(':value',50)),
            ),
            'address1' => array(
                array('max_length', array(':value',45)),
            ),
            'address2' => array(
                array('max_length', array(':value',45)),
            ),
            'city' => array(
                array('max_length', array(':value',45)),
            ),
            'state' => array(
                array('max_length', array(':value',2)),
            ),
            'zip' => array(
                array('max_length', array(':value',12)),
            ),
            'phone' => array(
                array('max_length', array(':value',20)),
            ),
            'url' => array(
                array('max_length', array(':value',255)),
            ),
            'owner_name' => array(
                array('max_length', array(':value',45)),
            ),
            'owner_email' => array(
                array('email', null),
                array('min_length', array(':value',6)),
                array('max_length', array(':value',255)),
                //array('not_empty', null),
            ),
            'owner_phone' => array(
                array('max_length', array(':value',20)),
            ),
            'owner_ext' => array(
                array('max_length', array(':value',45)),
            ),
            // @todo add rule for billing type
        );
    }
    
}