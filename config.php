<?php
date_default_timezone_set('Australia/Sydney');
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
//error_reporting(-1);
//error_reporting( E_ALL ^ E_NOTICE );

/** MySQL database username */
define('DB_USER', 'ec2-user');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_PDO', 'mysql:dbname=db_test;host=127.0.0.1');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** BASE DIR PATH */
define('ROOTPATH', __DIR__);

/** BASE URL PATH */
define('BASEURLPATH', '/test/');

/** Includes DIR PATH */
define('INCLUDESPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'includes');

/** Author */
define('AUTHOR', 'Zachary He');

/** Admin email address*/
define('ADMIN_EMAIL', 'test-project@hotmail.com');

/** Default contact email subject, please check sprintf, for format support*/ 
define('CONTACT_EMAIL_SUBJECT', 'REQUEST FROM : %s');

/** Load spl_autoload_register for class loading */
require_once( INCLUDESPATH . DIRECTORY_SEPARATOR . 'ini.php' );