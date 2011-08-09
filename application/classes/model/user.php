<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stores credentials and is used internally, for signing in.
 */
class Model_User extends Model_Auth_User {

    protected $_belongs_to = array('company'=>array(),'location'=>array());

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

    /**
     * Get locations user has access to. Optionally limit them to the locations
     * he can administer (see and change settings). By default returns only
     * locations that user can administer.
     * Check for availability happens on two levels: companies and locations
     * @param boolean $with_admin_access
     * @return Database_Result collection of Model_Location objects
     * @todo Split it into methods getting available companies and available
     *      locations.
     */
    public function getLocations($with_admin_access = true) {

        // get companies' ids
        $available_companies = DB::select('company_id')
                ->from('companies_users')
                ->where('user_id', '=', (int)  $this->id);
        if ($with_admin_access) {
            // select only these with access allowing for administration
            $available_companies = $available_companies
                    ->and_where('level', '<', 2);
        }
        $available_companies = $available_companies
                ->execute()
                ->as_array(null, 'company_id');
        if (empty($available_companies)) {
            $available_companies = array(-1); // placeholder to avoid query builder's errors
        }

        // get locations' ids
        $available_locations = DB::select('location_id')
                ->from('locations_users')
                ->where('user_id', '=', (int)  $this->id);
        if ($with_admin_access) {
            // select only these with access allowing for administration
            $available_locations = $available_locations
                    ->and_where('level', '<', 2);
        }
        $available_locations = $available_locations
                ->execute()
                ->as_array(null, 'location_id');
        if (empty($available_locations)) {
            $available_locations = array(-1); // placeholder to avoid query builder's errors
        }
        
        $result = ORM::factory('location')
                ->where('id', 'IN', $available_locations)
                ->or_where('company_id', 'IN', $available_companies)
                ->find_all();

        return $result;

    }

    /**
     * Get the username matching given credentials or FALSE if none found
     * @param string $username username for the user
     * @param string $password password of the user
     * @return Model_User user object or FALSE if data incorrect
     * @uses checkPassword() for checking password matching
     */
    public function verifyLoginData($username, $password) {

        if (empty($username) || empty($password)) {
            // no username or password given, so there is nothing to check
            return false;
        }

        // find user by username
        $user = ORM::factory('user')
                ->where('username', '=', $username)
                ->find();

        if (empty($user->id)) {
            // user not found
            return false;
        }

        if (!$user->checkPassword($password)) {
            // password is incorrect
            return false;
        }

        return $user;

    }

    /**
     * Check if the given password matches current user's password
     * @param string $password
     * @return bool TRUE if matches stored password, FALSE otherwise\
     * @uses Auth::hash()
     * @uses Auth::instance()
     */
    protected function checkPassword($password) {

        return Auth::instance()->hash($password) == $this->password;

    }

    /**
     * Get the access level for current user to given company
     * @param Model_Company $company company to be checked
     * @return int Access level or NULL if none found
     * @todo Fix the values returned - should be clear
     */
    protected function getAccessLevelForCompany(Model_Company $company) {
        $company_level = DB::select(array(DB::expr('MIN(`level`)'),'level'))
                ->from('companies_users')
                ->where('company_id', '=', (int)$company->id)
                ->and_where('user_id', '=', (int)$this->id)
                ->execute()
                ->get('level');
        if ($company_level !== null) {
            $company_level = (int)$company_level;
        }
        return $company_level;
    }

    /**
     * Get the access level by checking levels for location and for associated
     * company.
     * @param Model_Location $location location to be checked
     * @return int Access level determined
     */
    protected function getAccessLevelForLocation(Model_Location $location) {
        $access_levels = array();

        $company_level = $this->getAccessLevelForCompany($location->getCompany());
        if ($company_level !== null) {
            // has access to company, thus take it into account
            $access_levels[] = (int)$company_level;
        }

        $location_level = DB::select(array(DB::expr('MIN(`level`)'),'level'))
                ->from('locations_users')
                ->where('location_id', '=', (int)$location->id)
                ->and_where('user_id', '=', (int)$this->id)
                ->execute()
                ->get('level');
        if ($location_level !== null) {
            // location level has been found
            $access_levels[] = (int)$location_level;
        }

        if (empty($access_levels)) {
            // no access levels have been found
            $access_level = null;
        } else {
            $access_level = min($access_levels);
        }
        
        return $access_level;
    }

    /**
     * Determine if the current user can read given location's data
     * @param Model_Location $location
     * @return bool TRUE if can read, FALSE if can not
     */
    public function canReadLocation(Model_Location $location) {
        $level = $this->getAccessLevelForLocation($location);
        if ($level === null) {
            // has no access
            return false;
        } else {
            return in_array($level, array(0,1,2)); // @todo make it clearer
        }
    }

    /**
     * Determine if the current user can manage given location's settings
     * @param Model_Location $location
     * @return bool TRUE if can manage, FALSE if can not
     */
    public function canManageLocation(Model_Location $location) {
        $level = $this->getAccessLevelForLocation($location);
        if ($level === null) {
            // has no access
            return false;
        } else {
            return in_array($level, array(0,1)); // @todo make it clearer
        }
    }

}