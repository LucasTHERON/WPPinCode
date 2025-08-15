<?php

namespace WPPinCode;

class WPPinCode {
    private $database;
    private $plugin_options;

    public function __construct() {
        require WPPINCODE_DIR . 'classes/class-Database.php';

        
        $this->database = new  \WPPinCode\DatabaseInterface();
        $this->plugin_options = self::getOptions();
        var_dump($this->plugin_options);
        if($this->plugin_options['is_app_locked'] == '1' || 1 == 1){
            self::lock();
        }
        
    }

    public function activate() {
        // Créer la table dans la base de données
        $this->database->create_table();
    }

    public function deactivate() {
        // Nettoyer les données si nécessaire
    }

    public function getOptions() {
        // Vérouillage actif ?
        // Code défini ?
        $options = $this->database->getOptions();
        return $options;
    }

    private function lock(){
        var_dump('locking');
        echo '<h1>Website is locked !</h1>';
        die;
    }
}