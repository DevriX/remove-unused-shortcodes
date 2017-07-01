<?php
/*
Plugin Name: Remove Unused Shortcodes
Plugin URI: https://github.com/elhardoum/remove-unused-shortcodes
Description: Remove Unused Shortcodes from your WordPress posts, pages, and everything.
Author: Samuel Elh
Version: 0.1
Author URI: https://samelh.com/work-with-me
Text Domain: remove-unused-shortcodes
*/

if ( !defined('ABSPATH') ) {
    exit ( 'Direct access not allowed!' . PHP_EOL  );
}

if ( !defined('RMUS_FILE') ) {
    define('RMUS_FILE', __FILE__);
}

$constants = array(
    'RMUS_DIR' => plugin_dir_path(RMUS_FILE),
    'RMUS_URL' => plugin_dir_url(RMUS_FILE),
    'RMUS_VER' => '0.1',
    'RMUS_DOMAIN' => 'remove-unused-shortcodes',
);

foreach ( $constants as $constant => $def ) {
    if ( !defined( $constant ) ) {
        define( $constant, $def );
    }
}

function rmus_autload($className) {
    $classFile = $className;
    // main parent namespace
    $parentNamespace = 'RMUS';

    if ( "\{$parentNamespace}\\" === substr( $classFile, 0, (strlen($parentNamespace)+2) ) ) {
        $classFile = substr( $classFile, (strlen($parentNamespace)+2) );
    }
    else if ( "{$parentNamespace}\\" === substr( $classFile, 0, (strlen($parentNamespace)+1) ) ) {
        $classFile = substr( $classFile, (strlen($parentNamespace)+1) );
    }

    $classFile = RMUS_DIR."{$classFile}.php";
    $classFile = str_replace( '\\', DIRECTORY_SEPARATOR, $classFile );

    if ( !class_exists( $className ) && file_exists($classFile) ) {
        return require( $classFile );
    }
}

spl_autoload_register('rmus_autload');

new RMUS\Includes\Setup(1);