<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stores emails associated with specific location
 */
class Model_Email extends ORM {

    // @todo fill this property
    protected $_belongs_to = array();

    // primary key within the table
    protected $_primary_key = 'email_id';

    public function rules() {
        return array(
            'email' => array(
                array('email', null),
                array('max_length', array(':value',255)),
                array('min_length', array(':value',6)),
                array('not_empty', null),
            ),
        );
    }

}