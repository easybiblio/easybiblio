<?php
  include '_header.php';

  $lend_id = $_GET['lend_id'];
  if ($lend_id != '') {
    $lend_columns = $database->get("tb_lend", "*", array("id" => $lend_id));
  }

  $book_id = $lend_columns['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }

  $person_id = $lend_columns['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
    $fmw->escapeHtmlArray($person_columns);
  }

  $date_lend = $lend_columns['date_lend'];
  $notes = $lend_columns['notes'];
?>

<h1>Changer les notes d'un emprunt</h1>

<h3>Livre:</h3>
<table width="70%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td width="1%">Livre:</td>
    <td>(<?=$book_columns['code'] ?>) <?=$book_columns['title'] ?></td>
  </tr>
    
  <tr>
    <td>Auteur:</td>
    <td><?=$book_columns['author'] ?></td>
  </tr>
   
  <tr>
    <td>Co-Auteur:</td>
    <td><?=$book_columns['coauthor'] ?></td>
  </tr>
</table>

<h3>Personne:</h3>
<table width="70%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td width="1%">Nom/Prenom:</td>
    <td><?=$person_columns['name'] ?></td>
  </tr>
  <tr>
    <td>Ville:</td>
    <td><?=$person_columns['city'] ?></td>
  </tr>
  <tr>
    <td>Phone 1:</td>
    <td><?=$person_columns['phone1'] ?></td>
  </tr>
  <tr>
    <td>Phone2:</td>
    <td><?=$person_columns['phone2'] ?></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td><?=$person_columns['email'] ?></td>
  </tr>
</table>



<h3>Données de l'emprunt:</h3>

<form action="bookLendEditNotesSave.php" method="post" id="myform">
    <input type="hidden" name="lend_id"   value="<?=$lend_id?>" />

<table width="70%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="1%">Date&nbsp;d'Emprunt:</td>
    <td><?=$date_lend?></td>
  </tr>
  <tr>
    <td width="1%">Notes:</td>
    <td>
        <textarea rows="6" cols="50" name="notes" autofocus><?= $fmw->escapeHtml($notes) ?></textarea>
    </td>
    
  </tr>
</table>

<br/>

    <input type="submit" name="Submit" value="Changer Notes" />
    <input type="button" value="Annuler" onclick="window.location.href='reportBookLended.php'" />
</form>

<?php include '_footer.php' ?>
