<?php require_once '_header.mandatory.php';

$fmw->checkOperator();

$action = $_GET['action'];

if ($action == 'delete') {
    
    $id = $_GET['id'];

    $numberBooks = $database->count("tb_book", array("type_id[=]" => $id));

    if ($numberBooks > 0) {
        $fmw->info('bookTypeDelete.message.notPossibleToDelete', $numberBooks);
    } else {
        $deleted = $database->delete("tb_type", array("id[=]" => $id));

        if ($deleted > 0) {
            $fmw->info('bookTypeDelete.message.deleted');
        } else {
            $fmw->info('bookTypeDelete.message.notFound');
        }
    }
    
} else if ($action == 'save') {
    
    $name = $_POST['name'];
    if ($name == '') {
        $fmw->error('bookTypeSave.message.nameMandatory');
        include('bookType.php');
        exit();
    }

    $columns = array(
        "name" => $_POST['name']
    );

    $id = $_POST['id'];
    if ($id != '') {
        $database->update("tb_type", $columns, array("id[=]" => $id));
        $fmw->info('bookTypeSave.message.updated');
    } else {
        $database->insert("tb_type", $columns); 
        $fmw->info('bookTypeSave.message.created');
    }
    
}


$fmw->checkDatabaseError();

header("Location: bookTypeList.php");
?>