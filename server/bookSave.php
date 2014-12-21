<?php require_once '_header.mandatory.php';

$code = trim($_POST['code']);
$columns = array(
    "code" => $code,
    "title" => trim($_POST['title']),
    "description" => trim($_POST['description']),
    "author" => trim($_POST['author']),
    "coauthor" => trim($_POST['coauthor']),
    "editor" => trim($_POST['editor']),
    "year_publication" => $_POST['year_publication'],
    "language" => $_POST['language'],
    "category_id" => $_POST['category_id'],
    "type_id" => $_POST['type_id'],
    "cover_url" => $_POST['cover_url'],
    "notes" => $_POST['notes']
);

$id = $_POST['id'];
if ($id != '') {
    
    // Check if code already exist in another book
    $to_check = $database->get("tb_book", "*", array("code" => $code));
    if ($columns['code'] == '') {
        $fmw->error('bookSave.message.codeMandatory');
    } else if ($columns['title'] == '') {
        $fmw->error('bookSave.message.titleMandatory');
    } else if (isset($to_check['id']) and $to_check['id'] != $id) {
        $fmw->error('bookSave.message.codeAlreadyExist', $to_check['title'], $code);
    } else {
        $database->update("tb_book", $columns, array("id[=]" => $id));  
        $fmw->info('bookSave.message.bookUpdated', $columns['title']);  
    }
  
} else {

    // Check if code already exist in another book
    $to_check = $database->get("tb_book", "*", array("code" => $code));
    if ($columns['code'] == '') {
        $fmw->error('bookSave.message.codeMandatory');
    } else if ($columns['title'] == '') {
        $fmw->error('bookSave.message.titleMandatory');
    } else if (isset($to_check['id'])) {
        $fmw->error('bookSave.message.codeAlreadyExist', $to_check['title'], $code);
    } else {
        $columns['#date_creation'] = "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')";
        $last_book_id = $database->insert("tb_book", $columns);    
        $fmw->info('bookSave.message.newBookSaved', $columns['title'], $last_book_id);
    }
    
}

if ($fmw->hasError()) {
    include "book.php";
    exit();
}

$fmw->checkDatabaseError();

header("Location: bookSearch.php");
?>