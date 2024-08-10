<?php

use Medoo\Medoo;

class Framework {

   public $config;
   public $database;
   public $translator;
   public $audit;

   function __construct($config, $translator) {
       $this->config = $config;
       $this->translator = $translator;
       
       $dbconfig = array(
         'type' => $config->database_type,
         'database' => $config->database_name,
         'host' => $config->server,
         'username' => $config->username,
         'password' => $config->password,
         'charset' => $config->charset);

       // Medoo instance
       $this->database = new Medoo($dbconfig);
       
       // Audit
       $this->audit = new Audit($this->database);
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
      if ($this->database->error != "") {
          $this->error('Error: ' . $this->database->error . ": " . $this->database->errorInfo);
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
   
  // This function hash a password using a public salt (from argument) and a secret salt from configuration
  function hashPassword($password, $public_salt) {
      $hashed_password = hash('sha256', $this->config->secret_salt . $public_salt . $password);
      return $hashed_password;
  }
    
  // When user login, this method need to be called with the type of the user
  // 9 -> Admin
  // 8 -> Operator
  // 0 -> Logged as a Guest
  function login($username, $usertype) {
      $_SESSION['_ebb_username'] = $username;
      $_SESSION['_ebb_usertype'] = $usertype;
      $this->audit->login();
  }

  // Called for logout the user.
  function logout() {
      $this->audit->logout();
      unset($_SESSION['_ebb_username']);
      unset($_SESSION['_ebb_usertype']);
  }

  // Check if there is a logged user
  function isLoggedIn() {
      $userType = $_SESSION['_ebb_usertype'];
      return isset($userType);
  }
    
  // Check if the connected user is Administrator
  function isLoggedInAdmin() {
      return $this->isUser(9);
  }
    
  // Check if the connected user is Operator
  function isLoggedInOperator() {
      return $this->isUser(7);
  }
    
  // Check if the connected user is Contributor
  function isLoggedInContributor() {
      return $this->isUser(3);
  }
    
  // Check if the connected user is Registered
  function isLoggedInRegistered() {
      return $this->isUser(1);
  }
    
  private function isUser($userType) {
      $sessionUserType = $_SESSION['_ebb_usertype'];
      if (isset($sessionUserType) && $sessionUserType >= $userType) {
          return true;
      }
      return false;
  }

  // Check if the logged user has a userType equals or bigger than the required one.
  // If it has not the authorization, it forward user to Login Page with an error message.
  function checkAdmin() {
      if (!$this->isLoggedInAdmin()) {          
          $this->error('checkAuthorization.message.notAuthorized');
          header("Location: login.php");
          exit();
      }
  }
    
  function checkOperator() {
      if (!$this->isLoggedInOperator()){          
          $this->error('checkAuthorization.message.notAuthorized');
          header("Location: login.php");
          exit();
      }
  }
    
  function checkContributor() {
      if (!$this->isLoggedInContributor()){          
          $this->error('checkAuthorization.message.notAuthorized');
          header("Location: login.php");
          exit();
      }
  }
    
  function checkRegistered() {
      if (!$this->isLoggedInRegistered()){          
          $this->error('checkAuthorization.message.notAuthorized');
          header("Location: login.php");
          exit();
      }
  }

  function loadAbout() {
    $this->config->about = $this->database->select("tb_about", "*");
    $this->config->about = $this->config->about[0];

    // Meddo put lots of \ in the HTML. Let's remove them.
    $this->config->about['site_welcome'] = str_replace(array('\\'),'',$this->config->about['site_welcome']);
  }
    
  // Return the maximum numbers of books a person can let simultaneous.
  function maxLentBooks() {
      return $this->config->about['site_max_lent_books'];
  }
    
}

?>