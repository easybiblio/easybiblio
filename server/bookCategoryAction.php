<?php require_once '_header.mandatory.php';

$action = $_GET['action'];

if ($action == 'delete') {
    
    $id = $_GET['id'];

    $numberBooks = $database->count("tb_book", array("category_id[=]" => $id));

    if ($numberBooks > 0) {
        $fmw->info('bookCategoryDelete.message.notPossibleToDelete', $numberBooks);
    } else {
        $deleted = $database->delete("tb_category", array("id[=]" => $id));

        if ($deleted > 0) {
            $fmw->info('bookCategoryDelete.message.deleted');
        } else {
            $fmw->info('bookCategoryDelete.message.notFound');
        }
    }
    
} else if ($action == 'save') {
    
    $name = $_POST['name'];
    if ($name == '') {
        $fmw->error('bookCategorySave.message.nameMandatory');
        include('bookCategory.php');
        exit();
    }

    $columns = array(
        "name" => $_POST['name']
    );

    $id = $_POST['id'];
    if ($id != '') {
        $database->update("tb_category", $columns, array("id[=]" => $id));
        $fmw->info('bookCategorySave.message.updated');
    } else {
        $database->insert("tb_category", $columns); 
        $fmw->info('bookCategorySave.message.created');
    }
    
}


$fmw->checkDatabaseError();

header("Location: bookCategoryList.php");
?>