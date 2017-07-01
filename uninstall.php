<?php

// prevent direct access
defined('ABSPATH') || exit('Direct access not allowed.' . PHP_EOL);

// if uninstall.php is not called by WordPress, die
if ( !defined( 'WPINC' ) || !defined('WP_UNINSTALL_PLUGIN') )
    die('Direct access not allowed.' . PHP_EOL);

// delete settings
delete_option('rmus_items');