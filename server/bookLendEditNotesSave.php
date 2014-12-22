<?php require_once '_header.mandatory.php';

  $lend_id = $_POST['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
  }

  $notes = $_POST['notes'];

  if (!isset($lend_columns['id'])) {
      $fmw->error('bookLendEditNotesSave.message.loanNotFound');
  } else if (isset($lend_columns['date_return'])) {
      $fmw->error('bookLendEditNotesSave.message.bookAlreadyReturned');
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
      $columns = array(
        "notes" => $notes
      );

    $database->update("tb_lend", $columns, array("id[=]" => $lend_id));
	$fmw->info('bookLendEditNotesSave.message.success');

    $fmw->checkDatabaseError();
  }

  header("Location: reportBookLended.php");
?>