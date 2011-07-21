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
                array(array($this, 'is_unique_for_location')),
            ),
        );
    }

    /**
     * Check if the given email address is unique for the current location
     * @param string $email
     * @return boolean
     * @todo This may not support editing (saving already exitsing email), as it
     *      will cound also currently saved record. Change it if needed.
     */
    public function is_unique_for_location($email) {

        return ! DB::select(array(DB::expr('COUNT(email_id)'), 'total'))
            ->from($this->_table_name)
                ->where('email', '=', $email)
                ->and_where('location_id', '=', $this->location_id)
            ->execute()
            ->get('total');

    }

}