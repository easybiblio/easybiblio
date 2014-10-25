<?php
  require_once 'medoo.min.php';
  require_once '_framework.php';

  // Here you put the config for your database
  $dbconfig = array(
    'database_type' => 'mysql',
    'database_name' => 'mydb',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root' );

  $database = new medoo($dbconfig);

  $fmw = new Framework($database);
  session_start();

?>