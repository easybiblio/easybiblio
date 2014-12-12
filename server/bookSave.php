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
    if (isset($to_check['id']) and $to_check['id'] != $id) {
        $fmw->error('Il y a un livre que contient déjà ce code ! Livre pas enregistrée ');
    } else {
        $database->update("tb_book", $columns, array("id[=]" => $id));  
        $fmw->info('Livre "' . $columns['title'] . '" enregistré !');  
    }
  
} else {

    // Check if code already exist in another book
    $to_check = $database->get("tb_book", "*", array("code" => $code));
    if ($columns['code'] == '') {
        $fmw->error('Le code d\'un livre est obligatoire !');
    } else if ($columns['title'] == '') {
        $fmw->error('Le titre d\'un livre est obligatoire !');
    } else if (isset($to_check['id'])) {
        $fmw->error('Attention ! Il y a déjà le livre "'. $to_check['title'] .'" avec le code "' . $code . '"');
    } else {
        $columns['#date_creation'] = "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')";
        $last_book_id = $database->insert("tb_book", $columns);    
        $fmw->info('Nouveau livre "' . $columns['title'] . '" enregistré avec ID = ' . $last_book_id);
    }
    
}

if ($fmw->hasError()) {
    include "book.php";
    exit();
}

$fmw->checkDatabaseError();

header("Location: bookSearch.php");
?>