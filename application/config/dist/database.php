<?php defined('SYSPATH') or die('No direct access allowed.');

return array
    (
    'default' => array
    (
        'type'       => 'mysql',
        'connection' => array(
        /**
         * The following options are available for MySQL:
         *
         * string   hostname     server hostname, or socket
         * string   database     database name
         * string   username     database username
         * string   password     database password
         * boolean  persistent   use persistent connections?
         *
         * Ports and sockets may be appended to the hostname.
         */
            'hostname'   => 'localhost',
            'database'   => 'grapevine',
            'username'   => 'root',
            'password'   => 'lukasz.123',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
        'profiling'    => TRUE,
    ),
    'alternative' => array(
        'type'       => 'pdo',
        'connection' => array(
            /**
             * The following options are available for PDO:
             *
             * string   dsn         Data Source Name
             * string   username    database username
             * string   password    database password
             * boolean  persistent  use persistent connections?
             */
            'dsn'        => 'mysql:host=localhost;dbname=grapevine',
            'username'   => 'root',
            'password'   => 'lukasz.123',
            'persistent' => FALSE,
        ),
        /**
         * The following extra options are available for PDO:
         *
         * string   identifier  set the escaping identifier
         */
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
        'profiling'    => TRUE,
    ),
);