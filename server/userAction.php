<?php require_once '_header.mandatory.php';

use Medoo\Medoo;

$fmw->checkAdmin();
$action = $_GET['action'];

if ($action == 'delete') {
    
    $canDelete = true;
    
    $username = $_GET['username'];
    $columns = $database->get("tb_user", array("usertype"), array("username" => $username));
    
    // We need to make sure it is not the last one
    if ($columns['usertype'] == 9) {
        $count = $database->count("tb_user", array("usertype" => 9));
        if ($count == 1) {
            // Cannot delete, last Admin user
            $canDelete = false;
            $fmw->error('userActionDelete.message.lastAdmin');
        }
    }
    
    if ($canDelete) {   
        $deleted = $database->delete("tb_user", array("username[=]" => $username));

        if ($deleted > 0) {
            $fmw->info('userActionDelete.message.deleted', $username);
        } else {
            $fmw->info('userActionDelete.message.notFound', $username);
        }
    }
    
} else if ($action == 'create') {
    
    $username = $_POST['username'];
    if ($username == '') {
        $fmw->error('userActionSave.message.usernameMandatory');
        include('user.php');
        exit();
    }

    $salt = bin2hex(openssl_random_pseudo_bytes(32));
    $password = $fmw->hashPassword($_POST['password'], $salt);
    
    $columns = array(
        "username" => $username,
        "fullname" => $_POST['fullname'],
        "email" => $_POST['email'],
        "salt" => $salt,
        "usertype" => $_POST['usertype'],
        "password" => $password,
        "date_creation" => Medoo::raw("STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')")
    );

    $database->insert("tb_user", $columns); 
    $fmw->info('userActionSave.message.created', $username);

} else if ($action == 'update') {
    
    $canUpdate = true;
    $username = $_POST['username'];
    $usertype = $_POST['usertype'];
    
    // We need to make sure it is not the last Admin User
    if ($usertype != 9) {
        $columns = $database->get("tb_user", array("usertype"), array("username" => $username));
        if ($columns['usertype'] == 9) {
            $count = $database->count("tb_user", array("usertype" => 9));
            if ($count == 1) {
                // Cannot update, last Admin user
                $canUpdate = false;
                $fmw->error('userActionUpdate.message.lastAdmin');
            }
        }
    }
    
    if ($canUpdate) {
        $columns = array(
            "fullname" => $_POST['fullname'],
            "email" => $_POST['email'],
            "usertype" => $usertype
        );

        $database->update("tb_user", $columns, array("username[=]" => $username)); 
        $fmw->info('userActionUpdate.message.updated', $username);
    }
    
}


$fmw->checkDatabaseError();

header("Location: userList.php");
?>