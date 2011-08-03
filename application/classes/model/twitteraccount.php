<?php defined('SYSPATH') or die('No direct script access.');

class Model_TwitterAccount {

    /**
     * User ID
     * @var integer
     */
    protected $_user_id;

    /**
     * OAuth access token string
     * @var string
     */
    protected $_access_token;

    /**
     * Screen name of the user
     * @var string
     */
    protected $_screen_name;

    /**
     * URLs used for getting additional information from Twitter
     * @var array
     */
    protected $_urls = array(
        'show' => 'http://api.twitter.com/1/users/show.json',
    );

    /**
     * Set the access token
     * @param string $access_token access token
     */
    public function setAccessToken($access_token) {
        if (is_object($access_token)) {
            $access_token = $access_token->token;
        }

        $this->_access_token = $access_token;

        preg_match('/([0-9]+)[-][a-zA-Z0-9]+/', $this->_access_token, $matches);
        $user_id = Arr::get($matches, 1);
        if (!empty($user_id)) {
            $this->_user_id = (int)$user_id;
        }

        return $this;
    }

    /**
     * Get the screen name. It calls Twitter and requires User ID to be set.
     * @return string Twitter screen name
     */
    public function getScreenName() {
        if (!isset($this->_screen_name)) {
            $response = Request::factory(Arr::get($this->_urls, 'show'))->query('user_id', $this->getUserId())->execute();
            $this->_screen_name = json_decode((string)$response)->screen_name;
        }

        return $this->_screen_name;
    }

    /**
     * Set the Twitter's screen name
     * @param string $screen_name
     * @return Model_TwitterAccount 
     */
    public function setScreenName($screen_name) {
        $this->_screen_name = $screen_name;
        return $this;
    }

    /**
     * Get user ID
     * @return integer
     */
    public function getUserId() {
        return $this->_user_id;
    }

    /**
     * Set the ID of the user
     * @param integer $user_id the ID of the Twitter user
     * @return Model_TwitterAccount
     */
    public function setUserId($user_id) {
        $this->_user_id = (int)$user_id;
        return $this;
    }

}