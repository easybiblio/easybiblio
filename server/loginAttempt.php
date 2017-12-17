<?php include '_header.mandatory.php';

$redirection = "login.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $columns = $database->get("tb_user", array("salt"), array('username' => $username));
    
    $salt_from_user = $columns["salt"];
    $hashed_password = $fmw->hashPassword($password, $salt_from_user);

    $columns = $database->get("tb_user", "*", array("AND" => array('username' => $username, 'password' => $hashed_password)));

    if (isset($columns['usertype'])) {
        $fmw->login($columns['username'], $columns['usertype']);
        $fmw->info('login.message.loginSuccessful');
        $redirection = "bookSearch.php";
        $fmw->audit('User logged in');
    } else {
        $fmw->error('login.message.loginFailed');
    }
}

$fmw->checkDatabaseError();

header("Location: " . $redirection);

?>