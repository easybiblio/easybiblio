<?php require_once '_header.mandatory.php';

use Medoo\Medoo;

$fmw->checkOperator();

$name = $_POST['name'];
if ($name == '') {
    $fmw->error('personSave.message.nameMandatory');
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
    "active" => $_POST['active'],
    "notes" => $_POST['notes']
);

$audit_details= 'name: ' . $columns['name'] ;

$id = $_POST['id'];
if ($id != '') {
    $database->update("tb_person", $columns, array("id[=]" => $id));
	$fmw->info('personSave.message.personUpdated', $columns['name']);
    $audit->updatePerson($audit_details);
} else {
    $columns['date_creation'] = Medoo::raw("STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')");
    $database->insert("tb_person", $columns);
    $last_person_id = $database->id();
    $fmw->checkDatabaseError();
    $fmw->info('personSave.message.newPersonSaved', $columns['name'], $last_person_id);
    $audit->newPerson($audit_details);
}

$fmw->checkDatabaseError();

header("Location: personSearch.php");
?>