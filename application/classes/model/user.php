<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Stores credentials and is used internally, for signing in.
 */
class Model_User extends Model_Auth_User {

    protected $_belongs_to = array();

    protected $_roles = null;

}