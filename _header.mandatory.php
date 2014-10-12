<?php
  require_once 'medoo.min.php';
  require_once '_framework.php';
  $database = new medoo();
  $fmw = new Framework($database);
  session_start();

?>