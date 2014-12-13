<?php require_once '_header.mandatory.php';

  $book_id = $_POST['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
  }

  $person_id = $_POST['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
  }

  $date_lend = $_POST['date_lend'];
  $notes = $_POST['notes'];

  if (!isset($book_columns['id'])) {
      $fmw->error('Livre pas trouvé !');
  } else if (!isset($person_columns['id'])) {
      $fmw->error('Personne n\'as pas été trouvé');
  } else if (!$fmw->verifyDate($date_lend)) {
      $fmw->error("Date d'Emprunt n'est pas valide !");
  } else {
    // Check if book is already lended
      $query = "select * from tb_lend where book_id = " . $book_id . " and date_return is null";
      $book_already_lended = $database->query($query)->fetchAll();
      if (count($book_already_lended) > 0) {
          error('Livre est déjà preté à une autre personne');
      }
  }

  if (!$fmw->hasError()) {
      // Validation is OK, let's save.
      
    $columns = array(
        "book_id" => $book_id,
        "person_id" => $person_id,
        "#date_lend" => "STR_TO_DATE('" . $date_lend . "','%d/%m/%Y')",
        "notes" => $notes,
        '#date_creation' => "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')"
    );

    $last_book_lend_id = $database->insert("tb_lend", $columns);
	$fmw->info('Emprunt du livre "' . $book_columns['title'] .'" a été enregistrée avec ID = ' . $last_book_lend_id);

    $fmw->checkDatabaseError();
  }

  header("Location: bookSearch.php");
?>