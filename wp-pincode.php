<?php
/*
Plugin Name: WP Pincode
Description: Lock easiky your Wordpress with a pincode
Author: Mezant
Version: 1
*/

require_once 'includes/define.php';

add_action('init', 'hello_world');

function hello_world(){

    require WPPINCODE_DIR . 'classes/class-Database.php';

    $db = new \WPPinCode\Database;
    $db->dump();

    // global $wpdb;
    // $table = $wpdb->prefix . 'wp_pincode_options';
    // $column = 'name';
    // $value = 'wp_pincode_hash_key';
    // var_dump("SELECT * FROM wp_wp_pincode_options WHERE option_name = wp_pincode_hash_key");
    // $test = $wpdb->get_row( "SELECT * FROM wp_wp_pincode_options WHERE option_name = 'wp_pincode_hash_key'");
    // // $test = $wpdb->get_row( "SELECT * FROM {$table} WHERE {$column} = {$value}", OBJECT );
    // var_dump($test);
    // var_dump('________');
    // $test = $wpdb->get_row( "SELECT * FROM wp_options WHERE option_id = 5");
    // var_dump($test);
}

// DEFINIR CODE DANS LE BACKEND
// VERFIER SI LE PINCODE EST PRESENT