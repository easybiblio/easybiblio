<?php require_once '_header.mandatory.php';

  $lend_id = $_POST['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
  }

  $notes = $_POST['notes'];

  if (!isset($lend_columns['id'])) {
      $fmw->error("Emprunt n'as pas été trouvé !");
  } else if (isset($lend_columns['date_return'])) {
      $fmw->error('Livre est déjà retourné. Rien a été sauvegardé !');
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
      $columns = array(
        "notes" => $notes
      );

    $database->update("tb_lend", $columns, array("id[=]" => $lend_id));
	$fmw->info("Notes pour l'emprunt ont été sauvegardés !");

    $fmw->checkDatabaseError();
  }

  header("Location: reportBookLended.php");
?>