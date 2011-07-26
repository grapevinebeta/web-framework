<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for representing single location
 */
class Model_Location extends ORM {

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

    /**
     * Get users associated with the specific location.
     * @return Database_Result the collection of users, if any
     */
    public function getUsers() {

        // get ID of users as an array
        $users = DB::select('user_id')
                ->from('locations_users')
                ->where('location_id','=',DB::expr((int)$this->id))
                ->execute();
        
        $users_ids = array();
        foreach ($users as $user) {
            $users_ids[] = (int)$user['user_id'];
        }
        
        // if array is empty, add something that will not be matched
        if (empty($users_ids)) {
            $users_ids = array(0);
        }

        // get the actual objects of users
        $users = ORM::factory('user')
                ->where('id','IN',$users_ids)
                ->find_all();

        return $users;

    }
    
}