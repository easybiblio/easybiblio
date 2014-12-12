<?php require_once '_header.mandatory.php';

$name = $_POST['name'];
if ($name == '') {
    $fmw->error('Le nom est obligatoire.');
    include('person.php');
    exit();
}

$columns = array(
    "name" => $_POST['name'],
    "address" => $_POST['address'],
    "zipcode" => $_POST['zipcode'],
    "city" => $_POST['city'],
    "phone1" => $_POST['phone1'],
    "phone2" => $_POST['phone2'],
    "email" => $_POST['email'],
    "notes" => $_POST['notes']
);

$id = $_POST['id'];
if ($id != '') {
    $database->update("tb_person", $columns, array("id[=]" => $id));
	$fmw->info('Personne "' . $columns['name'] . '" enregistrée.');
} else {
    $columns['#date_creation'] = "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')";
    $last_person_id = $database->insert("tb_person", $columns);    
	$fmw->info('Nouvelle personne "'. $columns['name'] . '" enregistrée avec ID = ' . $last_person_id);
}

$fmw->checkDatabaseError();

header("Location: personSearch.php");
?>