<?php require_once '_header.mandatory.php';

$fmw->checkOperator();

$id = $_POST['id'];
$makeLost = $_POST['action'] == 'lost';
if ($id != '') {

    $columns = array(
        "lost" => ($makeLost ? 1 : 0),
        "lost_by_username" => ($makeLost ? $_SESSION['_ebb_username'] : NULL),
        "#lost_timestamp" => ($makeLost ? "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')" : NULL)
    );
        
    $database->update("tb_book", $columns, array("id[=]" => $id));
    
    // Audit
    $columns = $database->get("tb_book", "*", array('id' => $id));
    $audit_details = 'id:' . $id . ', code:' . $columns['code'] . ', title:' . $columns['title'];
    if ($makeLost) {
        $audit->bookLost($audit_details);
    } else {
        $audit->bookFound($audit_details);
    }

    $fmw->info($makeLost ? 'bookLostSave.message.lost' : 'bookLostSave.message.unlost');

}

if ($fmw->hasError()) {
    include "book.php?id=" . $id;
    exit();
}

$fmw->checkDatabaseError();

header("Location: book.php?id=" . $id);
?>