<?php
class EBBConfig {
    
    var $database_type = 'mysql';
    var $database_name = 'easybiblio';
    var $server = 'localhost';
    var $username = 'root';
    var $password = '';
    var $language = 'English';
    
    // Be sure what to do when changing charset
    var $charset = 'utf8';
    
    // For security reasons, personalize secret salt for your EasyBiblio installation
    // ATTENTION: By changing the secret salt you will make useless the default password for users admin and operator.
    //            After adapting the secret salt, please create a new admin and a new operator for your installation.
    var $secret_salt = 'secret-salt-to-be-changed';
    
    // To be implemented in the future
	// var $dbprefix = 'ebb_';
}
?>