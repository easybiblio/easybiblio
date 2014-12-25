<?php
  require_once 'medoo.min.php';
  require_once 'configuration.php';
  require_once '_framework.php';
  require_once '_translator.php';

  $config = new EBBConfig();
  $dbconfig = array(
    'database_type' => $config->database_type,
    'database_name' => $config->database_name,
    'server' => $config->server,
    'username' => $config->username,
    'password' => $config->password );

  // Medoo instance
  $database = new medoo($dbconfig);

  session_start();

  // Getting the language to be used
  if (isset($_SESSION['_language'])) {
      $config->language = $_SESSION['_language'];
  }

  // Object for translating text
  $t = new Translator($config->language);

  $fmw = new Framework($database, $t);
?>