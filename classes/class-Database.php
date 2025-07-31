<?php

namespace WPPinCode;

class Database
{
    private $wpdb;
    private $option_table;
    private $wp_pincode_table;

    public function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->option_table = $wpdb->prefix . 'options';
        $this->wp_pincode_table = $wpdb->prefix . 'wp_pincode_options';
    }

    public function createWpPincodeTable(){

    }

    public function dump(){
        // var_dump($this->wpdb);
        $db = $this->wpdb;
        var_dump($this->option_table);
        // $value = $db->get_var( $wpdb->prepare(
        //     " SELECT option_value FROM {$wpdb->prefix}plugin_table WHERE option_name = siteurl ",
        //     get_current_user_id()
        // ) );
        // $value = $db->get_var( $db->prepare(
        //     " SELECT `option_value` FROM `{$this->option_table}` WHERE `option_name` = `blogname`"
        // ) );
        // var_dump($value);
        $test = $db->get_var( "SELECT option_value FROM {$this->option_table} WHERE option_id = 1500" );
        // if null alors on créé

        var_dump($test);

        $firstTest = self::checkIfEntryExists($this->option_table, 'option_id', 150);
        var_dump($firstTest);
        $secondTest = self::checkIfEntryExists($this->option_table, 'option_id', 1500);
        var_dump($secondTest);

        var_dump("--------------------------");
        var_dump($this->wpdb->get_var( "SHOW TABLES LIKE '$this->wp_pincode_table'" ));
        var_dump($this->wpdb->get_var( "SHOW TABLES LIKE '$this->option_table'" ));
        // null if doesn't exist
    }

    private function addValue($table, $column, $value){
        return;
    }

    private function checkIfEntryExists($table, $column, $value){
        $entry = $this->wpdb->get_row( "SELECT * FROM {$table} WHERE {$column} = {$value}", OBJECT );
        if($entry){
            return true;
        }else{
            return false;
        }
    }

    private function createHashKey(){

    }

    public function getHashKey(){
        // Vérif si existe
        self::checkIfEntryExists('wp_pincode_hash_key');
        // Si non on créé
    }

    // Add hash
    // Update hasg
    // CRUD
    // Hash, Code, Active

    /**
     * On va créer :
     * - SALT KEY
     * - 
     */


}