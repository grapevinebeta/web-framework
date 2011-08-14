<?php defined('SYSPATH') or die('No direct script access.');

return array(
    
    'api_key' => 'ccgXj8JFWYAXX7fkM8uB', // key to use for docraptor
    'facebook_app_id' => '114877061941522', // application key for facebook oauth
    'facebook_api_key' => 'fa19888079b4a46affe2e8ca3096e882', // application key for facebook oauth
    'facebook_secret' => '0dd927c3d819e19903bc84ae99705b58', // application key for facebook oauth
    'twitter_consumer_key' => Kohana::config('oauth.twitter.key'), // application key for twitter oauth
    'twitter_consumer_secret' => Kohana::config('oauth.twitter.secret'), // application secret for twitter oauth
    'oauth_callback' => 'http://grapevine.dev.com/api/box/callback/', // application key for facebook oauth
    'docraptor_url' => 'https://docraptor.com/docs?user_credentials=%s',
    'test_mode' => true, // docraptor test mode 
    'sendgrid_username' => 'grapevine',
    'sendgrid_password' => 'grapevine2011',
    'sendgrid_host' => 'smtp.sendgrid.net',
    'sendgrid_port' => 25,
    'from_email' => array('grapevine@grapevine.org' => 'Grapevine Service'),
    'freshbooks_url'=>'https://conceptualideas.freshbooks.com/api/2.1/xml-in',
    'freshbooks_token'=>'3b76656df8228d9b46f898a61733bffe'
    
);