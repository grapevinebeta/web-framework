<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for representing single location
 */
class Model_Location extends ORM
{

    const AUTOMOTIVE = 'automotive';
    const HOSPITALITY = 'hospitality';
    const RESTAURANT = 'restaurant';
    const STATUS_ACTIVE='active';
    const STATUS_SUSPENDED='suspended';
    const STATUS_TRIAL='trial';
    const STATUS_DEACTIVE='deactive';
    const STATUS_PASTDUE='pastdue';
    protected $_belongs_to = array('company' => array());
    protected $_has_many = array('users' => array('through' => 'locations_users'));

    /**
     * Possible access levels stored in locations_users connector table
     * @var array array with representations as keys and codenames as values
     */
    protected static $_access_levels
    = array(
        0 => 'owner',
        1 => 'admin',
        2 => 'readonly',
    );

    public function rules()
    {
        return array(
            'name'
            => array(
                array('max_length', array(':value', 50)),
            ),
            'address1'
            => array(
                array('max_length', array(':value', 45)),
            ),
            'address2'
            => array(
                array('max_length', array(':value', 45)),
            ),
            'city'
            => array(
                array('max_length', array(':value', 45)),
            ),
            'state'
            => array(
                array('max_length', array(':value', 2)),
            ),
            'zip'
            => array(
                array('max_length', array(':value', 12)),
            ),
            'phone'
            => array(
                array('max_length', array(':value', 20)),
            ),
            'url'
            => array(
                array('max_length', array(':value', 255)),
            ),
            'owner_name'
            => array(
                array('max_length', array(':value', 45)),
            ),
            'owner_email'
            => array(
                array('email', null),
                array('min_length', array(':value', 6)),
                array('max_length', array(':value', 255)),
                //array('not_empty', null),
            ),
            'owner_phone'
            => array(
                array('max_length', array(':value', 20)),
            ),
            'owner_ext'
            => array(
                array('max_length', array(':value', 45)),
            ),
            // @todo add rule for billing type
        );
    }

    /**
     * Get users associated with the specific location.
     * @param bool $only_managable should this method return only users that can
     *      be managed by location's administrators?
     * @return Database_Result the collection of users, if any
     */
    public function getUsers($only_managable = false)
    {

        // prepare query
        $users = DB::select('user_id')
                ->from('locations_users')
                ->where('location_id', '=', DB::expr((int)$this->id));

        if ($only_managable) {
            // filter to only users that can be managed
            $managable_levels = self::getAccessLevels(
                array(
                    'admin',
                    'readonly',
                )
            );
            if (empty($managable_levels)) {
                $managable_levels = array(-1); // value not matching any level
            }
            $users = $users
                    ->and_where('level', 'IN', $managable_levels);
        }

        $users = $users
                ->execute();

        $users_ids = array();
        foreach (
            $users as $user
        ) {
            $users_ids[] = (int)$user['user_id'];
        }

        // if array is empty, add something that will not be matched
        if (empty($users_ids)) {
            $users_ids = array(0);
        }

        // get the actual objects of users
        $users = ORM::factory('user')
                ->where('id', 'IN', $users_ids)
                ->find_all();

        return $users;

    }

    /**
     * Get settings for current location.
     * @return Model_Location_Settings settings collection for location
     */
    public function getSettings()
    {

        return new Model_Location_Settings($this->id);

    }

    /**
     * Get the company associated with this location
     * @return Model_Company
     */
    public function getCompany()
    {
        return ORM::factory('company')
                ->where('id', '=', $this->company_id)
                ->find();
    }

    /**
     * Get the list of access levels available
     * @param array $levels list of access levels to be returned IDs for
     * @return array
     * @uses Model_Location::$_access_levels for determining list of access
     *      levels
     */
    public static function getAccessLevels($levels = null)
    {
        if ($levels === null) {
            return self::$_access_levels;
        }

        foreach (
            $levels as $level
        ) {
            $result[] = Arr::get(array_flip(self::$_access_levels), strtolower($level));
        }
        return $result;
    }
    
    /**
     * Get the numeric representation of level, corresponding to the given name.
     * This is a shorthand for getting array and passing only the first element.
     * @param string $level name of the level
     * @return int numeric representation of level or NULL if none
     * @uses getAccessLevels() for accessing list of possible levels
     */
    public static function getAccessLevel($level) {
        return Arr::get(self::getAccessLevels(array($level)),0);
    }

}