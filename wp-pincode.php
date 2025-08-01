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
    $db->createHashKey();
}

// DEFINIR CODE DANS LE BACKEND
// VERFIER SI LE PINCODE EST PRESENT