<?php include '_header.mandatory.php';

$redirection = "loginbyEmail.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // if e-mail present, check if e-mail exist in database
    if (!empty($email)) {

        $columns = $database->get("tb_user", "*", array('email' => $email));
        if (isset($columns['usertype'])) {
            $code = rand(100000,999999);

            $columns['#timestamp_logincode'] = "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')";
            $columns['logincode'] = $code;
            $database->update("tb_user", $columns, array('email' => $email));
            mail($email, "Code for your login", "Your code, valid for 3 min, to login is: " + $code);
            $fmw->info('loginbyEmailGenarateCode.message.codesent');

            $redirection = "loginbyEmailCode.php?email=" . $email;
        } else {
            $fmw->error('loginbyEmailGenarateCode.message.emailNotFound');
        }
    }
    
}

$fmw->checkDatabaseError();

header("Location: " . $redirection);

?>