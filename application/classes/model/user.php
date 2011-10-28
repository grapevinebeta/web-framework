<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stores credentials and is used internally, for signing in.
 */
class Model_User extends Model_Auth_User {

    protected $_belongs_to = array('location'=>array());
    

    protected $_roles = null;
    public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
				/*array('regex', array(':value', '/^[a-zA-Z0-9_\.]++$/D')),*/
				array(array($this, 'username_available'), array(':validation', ':field')),
			),
			'password' => array(
				array('not_empty'),
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 127)),
				array('email'),
				array(array($this, 'email_available'), array(':validation', ':field')),
			),
                        'firstname' => array(
                                array('not_empty'),
                        ),
                        'lastname' => array(
                                array('not_empty'),
                        ),
                        'phone' => array(
                                array('not_empty'),
                        ),
		);
	}
    
    /**
     * Find user associated to the specific location or give empty ORM object
     * @param int $user_id user's ID
     * @param int $location_id location's ID
     * @param bool $only_managable should this method return user only if he is
     *      managable by administrator?
     */
    public function findUserForLocation($user_id, $location_id, $only_managable = false) {
        
        $exists = DB::select(array(DB::expr('COUNT(`user_id`)'), 'total'))
                ->from('locations_users')
                ->where('locations_users.location_id', '=', (int)$location_id)
                ->and_where('locations_users.user_id', '=', (int)$user_id);

        if ($only_managable) {
            $managable_levels = Model_Location::getAccessLevels(array(
                'admin',
                'readonly',
            ));
            if (empty($managable_levels)) {
                $managable_levels = array(-1); // just to avoid errors
            }
            $exists = $exists
                    ->and_where('locations_users.level', 'IN', $managable_levels);
        }

        $exists = (bool)$exists
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
    
        
    public function getLocationsList() {

        // get companies' ids
        $available_companies = DB::select('company_id')
                ->from('companies_users')
                ->where('user_id', '=', (int) $this->id);

        
        $available_companies = $available_companies
                ->execute()
                ->as_array(null, 'company_id');
        if (empty($available_companies)) {
            $available_companies = array(-1); // placeholder to avoid query builder's errors
        }

        // get locations' ids
        $available_locations = DB::select('location_id')
                ->from('locations_users')
                ->where('user_id', '=', (int) $this->id);

        
        $available_locations = $available_locations
                ->execute()
                ->as_array(null, 'location_id');
        if (empty($available_locations)) {
            $available_locations = array(-1); // placeholder to avoid query builder's errors
        }


        $rs =  DB::select()
                ->from('companies_locations')
                ->join('locations')
                ->on('companies_locations.location_id', '=', 'locations.id')
                ->where('companies_locations.location_id', 'IN', $available_locations)
                ->or_where('companies_locations.company_id', 'IN', $available_companies)
                ->as_assoc()
                ->execute()
                ->as_array('location_id', 'name');
        
        $sql =  DB::insert('locations_slug', array('location_id', 'slug'));
        
        $values = array();
        
        DB::delete('locations_slug')
                ->where('location_id', 'IN', array_keys($rs))
                ->execute();
        
        $hashes = array();
        
        foreach($rs as $key => $name) {
            
            $hashes[] = $hash = strtolower(Inflector::underscore(preg_replace("/[^A-Za-z0-9\s]/", "", $name)));
            $sql->values(array($key, $hash));
            
        }
        
        $sql->execute();
                
        return 
        array(
            'locations' => array_combine($hashes, array_values($rs)),
            'hashes' => array_combine($hashes, array_keys($rs)),
        );
        
        
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
     * @param bool $ignore_company_level Should the level of access to the
     *      company be ignored?
     * @return int Access level determined
     */
    public function getAccessLevelForLocation(Model_Location $location, $ignore_company_level = false) {
        $access_levels = array();

        if (!$ignore_company_level) {
            $company_level = $this->getAccessLevelForCompany($location->getCompany());
            if ($company_level !== null) {
                // has access to company, thus take it into account
                $access_levels[] = (int)$company_level;
            }
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

    /**
     * Change access level for the current user to given location
     * @param Model_Location $location Location to be set access to
     * @param mixed $level numeric representation of level or string
     * @return mixed
     * @todo Change returned value to boolean representing success or failure
     */
    public function setAccessLevelForLocation(Model_Location $location, $level) {
        $given_level = $level;
        if (!is_numeric($level)) {
            // transform level to numeric representation (assuming codename)
            $level = Arr::get(Model_Location::getAccessLevels(array($level)), 0);
            if ($level === null) {
                // we can not allow for passing this further
                throw new Kohana_Exception('Given level (":level") is not supported for setting access for location.', array(
                    ':level' => $given_level,
                ));
            }
        }

        $result = DB::update('locations_users')
                ->value('level', (int)$level)
                ->where('location_id', '=', (int)$location->id)
                ->and_where('user_id', '=', (int)$this->id)
                ->execute();

        return $result; // @todo pass only success / failure information

    }
    
    /**
     * Check if the role is assigned to the current user.
     * @param string $role_name name of the role
     * @return bool TRUE if role is assigned, FALSE otherwise
     */
    public function hasRole($role_name) {
        return $this->has('roles', ORM::factory('role', array('name' => $role_name)));
    }
    
    /**
     * Add specific role to the user
     * @param string $role_name name of the role
     * @return 
     */
    public function addRole($role_name) {
        return $this->add('roles', ORM::factory('role', array('name' => $role_name)));
    }

}