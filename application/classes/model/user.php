<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stores credentials and is used internally, for signing in.
 */
class Model_User extends Model_Auth_User {

    protected $_belongs_to = array();

    protected $_roles = null;
    
    /**
     * Find user associated to the specific location or give empty ORM object
     * @param int $user_id user's ID
     * @param int $location_id location's ID
     */
    public function findUserForLocation($user_id, $location_id) {
        
        $exists = (bool) DB::select(array(DB::expr('COUNT(`user_id`)'), 'total'))
                ->from('locations_users')
                ->where('locations_users.location_id', '=', (int)$location_id)
                ->and_where('locations_users.user_id', '=', (int)$user_id)
                ->execute()
                ->get('total');
        
        if ($exists) {
            $result = ORM::factory('user')
                    ->where('id','=',(int)$user_id)
                    ->find();
        } else {
            $result = ORM::factory('user');
        }
        
        return $result;
        
    }

}