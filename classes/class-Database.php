<?php

namespace WPPinCode;

class Database
{
    private $wpdb;
    private $option_table;
    private $wp_pincode_table;

    protected function __construct(){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->option_table = $wpdb->prefix . 'options';
        $this->wp_pincode_table = $wpdb->prefix . 'wp_pincode_options';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }

    protected function dump(){
        // $hashed_numbers = self::getValue($this->wp_pincode_table, 'wp_pincode_hashed_numbers');
        // $hashed_numbers_array = explode(',', $hashed_numbers);
        // $code = $hashed_numbers_array[1] . $hashed_numbers_array[2] . $hashed_numbers_array[3] . $hashed_numbers_array[4];
        // self::createPincode($code);
        
    }

    protected function getOptions(){

        self::checkDatabaseEntries();

        $is_pincode_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode');
        $is_app_locked = self::getValue($this->option_table, 'wp_pincode_lock');

        return [
            'is_pincode_defined'    =>  $is_pincode_defined,
            'is_app_locked'         =>  $is_app_locked,
        ];

    }

    /**
     * 
     * 
     * PRIVATE FUNCTIONS
     * 
     * 
     */

    private function addOptions(){
        self::addValue(
            $this->option_table,
            [
                'option_name'  =>  'wp_pincode_lock',
                'option_value' => false
            ]
        );
    }
    
    private function addValue($table, $args){
        // $args should be ['col1' => 'val1', 'col2' => 'val2']
        $this->wpdb->insert(
            $table,
            $args
        );
    }

    private function getValue($table, $option){
        $value = $this->wpdb->get_var( "SELECT option_value FROM $table WHERE option_name = '$option'" );
        return $value;
    }

    private function updateValue($table, $option){
        $value = $db->get_var( "SELECT option_value FROM $table WHERE option_name = '$option'" );
        return $value;
    }

    private function checkIfEntryExists($table, $column, $value){
        $entry = $this->wpdb->get_row( "SELECT * FROM $table WHERE $column = '$value'", OBJECT );
        if($entry){
            return true;
        }else{
            return false;
        }
    }

    private function checkDatabaseEntries(){
        // This method is only here to check required entries for the plugin to work

        // Database lock option
        $wp_pincode_lock_check = self::checkIfEntryExists($this->option_table, 'option_name', 'wp_pincode_lock');
        if(!$wp_pincode_lock_check){
            self::addValue(
                $this->option_table,
                [
                    'option_name'  =>  'wp_pincode_lock',
                    'option_value' => false
                ]
            );
        }

        // Main hash key
        $wp_pincode_hash_key_check = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hash_key');
        if(!$wp_pincode_hash_key_check){
            self::createHashKey();
        }

        // Hahsed numbers
        $wp_pincode_hashed_numbers_check = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hash_key');
        if(!$wp_pincode_hashed_numbers_check){
            self::createHashedNumbers();
        }
    }

    public function createWpPincodeTable(){
        if(!$this->wpdb->get_var( "SHOW TABLES LIKE '$this->wp_pincode_table'" )){

            // Get the database character set and collation
            $charset_collate = $this->wpdb->get_charset_collate();

            // The SQL query to create the table
            $sql = "CREATE TABLE $this->wp_pincode_table (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                option_name varchar(255) NOT NULL,
                option_value varchar(255) NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";

            $new_database = dbDelta($sql);
            if($new_database){
                $hash_key = self::createHashKey();
            }
        }
    }

    private function createHashKey(){
        $is_hash_key_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hash_key');
        if($is_hash_key_defined){
            return;
        }else{
            $hash_key = bin2hex(random_bytes(16));
            self::addValue(
                $this->wp_pincode_table,
                [
                    'option_name'  =>  'wp_pincode_hash_key',
                    'option_value' => $hash_key
                ]
            );
        }
    }

    private function createHashedNumbers(){
        $is_hashed_num_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hashed_numbers');
        if($is_hashed_num_defined){
            return;
        }else{
            $hashed_numbers = [];
            for($i = 0; $i <= 9; $i++){
                $n = bin2hex(random_bytes(2));
                echo $i . ' => ' . $n . '<br>';
                $hashed_numbers[] = $n;
            }

            $hashed_str = implode(",", $hashed_numbers);
            self::addValue(
                $this->wp_pincode_table,
                [
                    'option_name'  =>  'wp_pincode_hashed_numbers',
                    'option_value' => $hashed_str
                ]
            );
        }
    }

    private function createPincode($code){
        $is_pincode_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode');
        if($is_pincode_defined){
            return;
        }else{
            $hashed_code = self::hashCode($code);
            self::addValue(
                $this->wp_pincode_table,
                [
                    'option_name'  =>  'wp_pincode',
                    'option_value' => $hashed_code
                ]
            );
        }
    }

    public function getHashKey(){
        // Vérif si existe
        self::checkIfEntryExists('wp_pincode_hash_key');
        // Si non on créé
    }

    public function getHashedNumbers(){
        // Vérif si existe
        $is_hashed_num_defined = self::checkIfEntryExists('wp_pincode_hashed_numbers');
        if($is_hashed_num_defined){
            
        }
    }

    private function hashCode($code){
        $hash_key = self::getValue($this->wp_pincode_table, 'wp_pincode_hash_key');
        $hashed_code = hash('sha256', $code . $hash_key);
        return $hashed_code;
    }

    private function privateFunction(){
        return 'private';
    }

    protected function protectedFunction(){
        return 'protected';
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

class DatabaseInterface extends Database
{
    public function __construct(){
        parent::__construct();
    }

    public function getOptions(){
        $options = parent::getOptions();
        return $options;
    }
}