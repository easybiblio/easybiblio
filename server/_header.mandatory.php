<?php
  require_once 'medoo.min.php';
  require_once 'configuration.php';
  require_once '_framework.php';
  require_once '_translator.php';

  // Here you put the config for your database
  $config = new EBBConfig();
  $dbconfig = array(
    'database_type' => $config->database_type,
    'database_name' => $config->database_name,
    'server' => $config->server,
    'username' => $config->username,
    'password' => $config->password );

  // Medoo instance
  $database = new medoo($dbconfig);

  // Object for translating text
  $t = new Translator($config->language);

  $fmw = new Framework($database, $t);

  session_start();
?>