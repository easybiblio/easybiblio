<?php require_once '_header.mandatory.php';

$fmw->checkAdmin();

$columns = array(
    "site_shortname" => $_POST['site_shortname'],
    "site_longname" => trim($_POST['site_longname']),
    "site_meta_description" => trim($_POST['site_meta_description']),
    "site_meta_tags" => trim($_POST['site_meta_tags']),
    "site_logo_url" => trim($_POST['site_logo_url']),
    "site_welcome" => trim($_POST['site_welcome'])
);

$database->update("tb_about", $columns);
$fmw->info('aboutSave.message.saved');  

$fmw->checkDatabaseError();

header("Location: about.php");
?>