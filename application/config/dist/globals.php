<?php defined('SYSPATH') or die('No direct script access.');

return array(

    'api_key' => 'ccgXj8JFWYAXX7fkM8uB', // key to use for docraptor
    'facebook_app_id' => '224929787553573', // application key for facebook oauth
    'facebook_api_key' => '224929787553573', // application key for facebook oauth
    'facebook_secret' => '257397f33ebf6c2b9d0b25c9eafbeb4c', // application key for facebook oaut
    'twitter_consumer_key' => Kohana::config('oauth.twitter.key'), // application key for twitter oauth
    'twitter_consumer_secret' => Kohana::config('oauth.twitter.secret'), // application secret for twitter oauth
    'oauth_callback' => 'http://grapevine.dev.com/api/box/callback/', // application key for facebook oauth
    'docraptor_url' => 'https://docraptor.com/docs?user_credentials=%s',
    'test_mode' => true, // docraptor test mode 
    'sendgrid_username' => 'grapevine',
    'sendgrid_password' => 'grapevine2011',
    'sendgrid_host' => 'smtp.sendgrid.net',
    'sendgrid_port' => 25,
    'send_alerts' => false,
    'from_email' => array('grapevine@grapevine.org' => 'Grapevine Service'),
    'freshbooks_url' => 'https://conceptualideas.freshbooks.com/api/2.1/xml-in',
    'freshbooks_token' => '3b76656df8228d9b46f898a61733bffe',
    'reviews_categories'
    => array(

        ''
        => array(
            'Select One ->', 'General / Multiple Dept.'
        ),

        'automotive'
        => array(
            'Select One ->', 'Sales Dept', 'Service Dept', 'Parts Dept', 'Finance Dept.',
            'General / Multiple Dept.'
        ),
        'restaurant'
        => array(
            'Select One ->', 'Valet /Parking', 'Drinks / Bar', 'Food / Kitchen', 'Service / Greeters',
            'Service / Waitstaff', 'Service / Managers', 'General / Multiple Dept.'
        ),
        'hospitality'
        => array(
            'Select One ->', 'Valet / Parking', 'Front Desk / Door Staff / Concierge',
            'Food & Beverage', 'Housekeeping', 'Engineering',
            'Amenities / Pool / Spa / Business Ctr. / Fitness Ctr.',
            'Catering', 'Conference Services / Banquets', 'Reservations',
            'Managers', 'General / Multiple Dept.'
        ),

    ),
    'review_sources'
    => array(
        'common'
        => array(
            'CitySearch' => 'citysearch.com',
            'InsiderPages' => 'insiderpages.com',
            'Yelp' => 'yelp.com',
            'Google Places' => 'places.google.com',
            'InsiderPages' => 'insiderpages.com',
            'Yahoo! Local' => 'local.yahoo.com',
            'SuperPages' => 'superpages.com',
            'Yellow Pages' => 'yp.com'
        ),
        'automotive'
        => array(
            'Edmunds' => 'edmunds.com',
            'Dealer Rater' => 'dealerrater.com'
        ),
        'restaurant'=>array(
            'Urbanspoon'=>'urbanspoon.com'
        )

    )

);