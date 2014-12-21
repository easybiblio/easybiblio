<?php

class Framework {

   var $database;
   var $translator;

   function Framework($database, $translator) {
       $this->database = $database;
       $this->translator = $translator;
   }

  // Check if a date if valid, return TRUE or FALSE.
  function verifyDate($date) {
    $dateTime = DateTime::createFromFormat('d/m/Y', $date);
    $errors = DateTime::getLastErrors();
    if (!empty($errors['warning_count'])) {
        return false;
    }

    return $dateTime !== false;
  }

  function getPostOrArray($columns, $key) {
      $value = $_POST[$key];
      if (!isset($value)) {
          $value = $columns[$key];
      }
      return trim($value);
  }

  function getPostOrArrayQuoted($columns, $key) {
      $value = $this->getPostOrArray($columns, $key);
      $value = $this->escapeHtml($value);
      return "'" . $value . "'";
  }

  // Helper function to select elements in a <Select> HTML
  function getPostOrArraySelected($columns, $key, $valueToCheck) {
      $value = $_POST[$key];
      if (!isset($value)) {
          $value = $columns[$key];
      }
      return $value == $valueToCheck ? "selected" : "";
  }

  // Before including a TEXT from DB to HTML, it must be escaped.
  function escapeHtml($value) {
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  // It escape all string values of the array
  function escapeHtmlArray(&$array) {
      foreach ($array as $key => $value) {
          if ( is_string($value) ) {
              $array[$key] = $this->escapeHtml($value);
          }
      }
  }

  // Set an info message to be shown to the user
  function info($message, $arg1 = "", $arg2 = "") {
      $_SESSION['message'] = $this->translator->__($message, $arg1, $arg2);
  }

  // Set an error message to be shown to the user
  function error($message, $arg1 = "", $arg2 = "") {
      $_SESSION['error_message'] = $this->translator->__($message, $arg1, $arg2);
  }

  function clearMessages() {
      $_SESSION['message'] = '';
      $_SESSION['error_message'] = '';
  }
    
  // Check if there is a message that was set
  function hasInfo() {
      return $_SESSION['message'] != '';
  }

  // Check if there is an error that was set
  function hasError() {
      return $_SESSION['error_message'] != '';
  }

  function checkDatabaseError() {
      $array_error = $this->database->error();
      if (current($array_error) != "00000") {
          $this->error('Error: ' . $array_error[2]);
      }
  }
   
  // Echo the array into JSON.
  // Also removes the numeric keys (important because when meddo create array based on result SQL, each column is present twice).
  function echo_json($datas) {

    // Important to remove duplicates, as each column is put in the array twice by medoo framework.
    // Once with the name of the column, a second time with the position of the column like 0, 1, 2, etc.
    for ($r=0; $r<=count($datas); $r++) {
        $num_columns = count($datas[$r]) / 2;
        for ($c=0; $c<=$num_columns; $c++) {
            unset($datas[$r][$c]);
        }
    }

    echo json_encode($datas);
  }
    
}

?>