<?php require_once '_header.mandatory.php';

use Medoo\Medoo;

$fmw->checkContributor();

// Check if String ends with toCheck.
function endsWith($string, $toCheck) {
    // search forward starting from end minus needle length characters
    return $toCheck === "" || strpos($string, $toCheck, strlen($string) - strlen($toCheck)) !== FALSE;
}

// Checks if it is a REMOTE URL for the cover, if yes, tries to copy it to local server
function copyImageFromServer($bookId, $columns) {
    $urlSource = $columns['cover_url'];

    if (substr($urlSource, 0, 4) === "http" && endsWith($urlSource, "jpg")) {
        $newCoverURL = "images/covers/book_cover_" . $bookId . '.jpg';
        if (@copy($urlSource, $newCoverURL)) {
            // It worked, lets use it
            $columns['cover_url'] = $newCoverURL;
        };
    }
}

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

$audit_details = 'code: '  . $columns['code'] . ', ';
$audit_details.= 'title: ' . $columns['title'] ;

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
        
        // This line tries to copy the remote cover to your local file
        // copyImageFromServer($id, &$columns);
        
        $database->update("tb_book", $columns, array("id[=]" => $id));  
        $fmw->info('bookSave.message.bookUpdated', $columns['title']);
        
        // Audit
        $audit->updateBook($audit_details);
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
        $columns['date_creation'] = Medoo::raw("STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')");
        
        // This line tries to copy the remote cover to your local file
        // copyImageFromServer($id, &$columns);
        
        $database->insert("tb_book", $columns);
        $last_book_id = $database->id();
        $fmw->info('bookSave.message.newBookSaved', $columns['title'], $last_book_id);
        $fmw->checkDatabaseError();
        
        // Audit
        $audit->newBook($audit_details);
    }
    
}

if ($fmw->hasError()) {
    include "book.php";
    exit();
}

$fmw->checkDatabaseError();

header("Location: bookSearch.php");
?>