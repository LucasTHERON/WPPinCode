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

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
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

    public function dump(){
        // var_dump($this->wpdb);
        // self::createHashKey();
        self::createHashedNumbers();
        return;
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

        // var_dump("--------------------------");
        // var_dump($this->wpdb->get_var( "SHOW TABLES LIKE '$this->wp_pincode_table'" ));
        // var_dump($this->wpdb->get_var( "SHOW TABLES LIKE '$this->option_table'" ));
        // null if doesn't exist

        self::createWpPincodeTable();
    }

    private function addValue($table, $args){
        // $args should be ['col1' => 'val1', 'col2' => 'val2']
        $this->wpdb->insert(
            $table,
            $args
        );
    }

    private function checkIfEntryExists($table, $column, $value){
        var_dump("SELECT * FROM $table WHERE $column = '$value'");
        $entry = $this->wpdb->get_row( "SELECT * FROM $table WHERE $column = '$value'", OBJECT );
        var_dump($entry);
        if($entry){
            return true;
        }else{
            return false;
        }
    }

    private function createHashKey(){
        $is_hash_key_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hash_key');
        var_dump($is_hash_key_defined);
        if($is_hash_key_defined){
            return;
        }else{
            $hash_key = bin2hex(random_bytes(16));
            self::addValue(
                $this->wp_pincode_table,
                [
                    'name'  =>  'wp_pincode_hash_key',
                    'value' => $hash_key
                ]
            );
        }
    }

        private function createHashedNumbers(){
        $is_hashed_num_defined = self::checkIfEntryExists($this->wp_pincode_table, 'option_name', 'wp_pincode_hashed_numbers');
        if($is_hashed_num_defined){
            return;
        }else{
            // $n = bin2hex(random_bytes(4));
            // var_dump("1 = ");
            $hashed_numbers = [];
            for($i = 0; $i <= 9; $i++){
                $n = bin2hex(random_bytes(2));
                echo $i . ' => ' . $n . '<br>';
                $hashed_numbers[] = $n;
            }
            var_dump($hashed_numbers);

            $newArr = implode(",", $hashed_numbers);
            var_dump($newArr);
            var_dump(explode(",", $newArr));
            // $hash_key = bin2hex(random_bytes(16));
            // self::addValue(
            //     $this->wp_pincode_table,
            //     [
            //         'name'  =>  'wp_pincode_hash_key',
            //         'value' => $hash_key
            //     ]
            // );
        }
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