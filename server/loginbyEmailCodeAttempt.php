<?php include '_header.mandatory.php';

$redirection = "bookSearch.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $logincode = trim($_POST['logincode']);

    // Check if e-mail exist, code exist and not yet expired (5 min)
    $query = "select * from tb_user where email = " . $database->quote($email) . " and logincode = " . $database->quote($logincode) . " and TIMESTAMPDIFF(SECOND, timestamp_logincode, now()) < 300";
    $data = $database->query($query)->fetchAll();
    $codeIsValid = count($data) == 1;
    
    if ($codeIsValid) {
        $columns = $data[0];
        $fmw->login($columns['username'], $columns['usertype']);
        $fmw->info('login.message.loginSuccessful');
        $redirection = "bookSearch.php";
    } else {
        $fmw->error('loginByEmailCodeAttempt.message.codeNotFound');
        $redirection = "loginbyEmailCode.php?email=" . $email;
    }
    
}

$fmw->checkDatabaseError();

header("Location: " . $redirection);

?>