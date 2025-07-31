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
    // use WPPinCode;
    // echo '<h1 style="text-align: center;">Hello world !</h1>';
    // require 'classes/class-Database';
    // var_dump(WPPINCODE_DIR);
    $db = new \WPPinCode\Database;
    $db->dump();
}

// DEFINIR CODE DANS LE BACKEND
// VERFIER SI LE PINCODE EST PRESENT