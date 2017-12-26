<?php
  require_once 'medoo.php';
  require_once 'configuration.php';
  require_once '_framework.php';
  require_once '_translator.php';
  require_once '_audit.php';

  $config = new EBBConfig();
  session_start();

  // Getting the language to be used
  if (isset($_SESSION['_language'])) {
      $config->language = $_SESSION['_language'];
  }

  // Object for translating text
  $t = new Translator($config->language);

  $fmw = new Framework($config, $t);
  $database = $fmw->database;
  $audit = $fmw->audit;
?>