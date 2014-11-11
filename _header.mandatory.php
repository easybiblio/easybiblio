<?php
  require_once 'medoo.min.php';
  require_once 'configuration.php';
  require_once '_framework.php';

  // Here you put the config for your database
  $config = new EBBConfig();
  $dbconfig = array(
    'database_type' => $config->database_type,
    'database_name' => $config->database_name,
    'server' => $config->server,
    'username' => $config->username,
    'password' => $config->password );

  $database = new medoo($dbconfig);
  $fmw = new Framework($database);

  session_start();

?>