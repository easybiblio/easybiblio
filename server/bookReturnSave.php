<?php include_once '_header.mandatory.php';

  $fmw->checkOperator();

  $lend_id = $_POST['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
    $book_columns = $database->get("tb_book", "*", array("id" => $lend_columns['book_id']));
  }

  $date_return = $_POST['date_return'];
  $notes = $_POST['notes'];

  if (!isset($lend_columns['id'])) {
      $fmw->error('bookReturnSave.message.loanNotFound');
  } else if (!$fmw->verifyDate($date_return)) {
      $fmw->error('bookReturnSave.message.returnDateNotValid');
  } else if (isset($lend_columns['date_return'])) {
      $fmw->error('bookReturnSave.message.bookAlreadyReturned');
  } else if ($book_columns['lost'] == 1) {
      $fmw->error('bookReturnSave.message.bookLostCannotReturn');      
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
      $columns = array(
        "#date_return" => "STR_TO_DATE('" . $date_return . "','%d/%m/%Y')",
        "notes" => $notes
      );

    $database->update("tb_lend", $columns, array("id[=]" => $lend_id));
	$fmw->info('bookReturnSave.message.bookReturned', $book_columns['title']);

    $fmw->checkDatabaseError();
  }

  header("Location: bookSearch.php");
?>