<?php require_once '_header.mandatory.php';

  $lend_id = $_POST['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
  }

  $date_return = $_POST['date_return'];
  $notes = $_POST['notes'];

  if (!isset($lend_columns['id'])) {
      $fmw->error('Emprunt pas trouvé !');
  } else if (!$fmw->verifyDate($date_return)) {
      $fmw->error("Date de retourn n'est pas valide !");
  } else if (isset($lend_columns['date_return'])) {
      $fmw->error('Livre est déjà retourné. Rien a été sauvegardé !');
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
      $columns = array(
        "#date_return" => "STR_TO_DATE('" . $date_return . "','%d/%m/%Y')",
        "notes" => $notes
      );

    $book_columns = $database->get("tb_book", "*", array("id" => $lend_columns['book_id']));
    $database->update("tb_lend", $columns, array("id[=]" => $lend_id));
	$fmw->info('Livre "' . $book_columns['title'] . '" a été retourné !');

    $fmw->checkDatabaseError();
  }

  header("Location: bookSearch.php");
?>