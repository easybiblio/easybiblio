<?php require_once '_header.mandatory.php';

$fmw->checkAdmin();

$max_lent_books = $_POST['site_max_lent_books'];
if ( !is_numeric($max_lent_books) ) {
    // Set default in case of not numeric
    $max_lent_books = 2;
}

$columns = array(
    "site_shortname" => $_POST['site_shortname'],
    "site_longname" => trim($_POST['site_longname']),
    "site_meta_description" => trim($_POST['site_meta_description']),
    "site_meta_keywords" => trim($_POST['site_meta_keywords']),
    "site_logo_url" => trim($_POST['site_logo_url']),
    "site_welcome" => trim($_POST['site_welcome']),
    "site_max_lent_books" => $max_lent_books
);

$database->update("tb_about", $columns);
$fmw->info('aboutSave.message.saved');  

$fmw->checkDatabaseError();

header("Location: about.php");
?>