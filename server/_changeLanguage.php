<?php
  session_start();

  // Setting the language to be used into the session
  if (isset($_GET['_language'])) {
      $_SESSION['_language'] = $_GET['_language'];
  }
?>