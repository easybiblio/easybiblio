<?php
  include '_header.php';

  $book_id = $_POST['book_id'];
  if ($book_id != '') {
    $book_columns = $database->get("tb_book", "*", array("id" => $book_id));
    $fmw->escapeHtmlArray($book_columns);
  }

  $person_id = $_POST['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
    $fmw->escapeHtmlArray($person_columns);
  }

  $date_lend = $_POST['date_lend'];
  $notes = $_POST['notes'];
?>

<h1>Emprunter des livres (Confirmation)</h1>

Livre:
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

<br/>
Personne:
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

<br/>

Données pour l'emprunt:
<table width="70%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td width="1%">Date&nbsp;d'Emprunt:</td>
    <td><?=$date_lend?></td>
  </tr>
  <tr>
    <td width="1%">Notes:</td>
    <td><?=$fmw->escapeHtml($notes)?></td>
  </tr>
</table>

<br/>

<form action="bookLendConfirmationSave.php" method="post">
    <input type="hidden" name="book_id"   value="<?=$book_id?>" />
    <input type="hidden" name="person_id" value="<?=$person_id?>" />
    <input type="hidden" name="date_lend" value="<?=$date_lend?>" />
    <input type="hidden" name="notes"     value="<?=$fmw->escapeHtml($notes)?>" />
    <input type="submit" name="Submit" value="Confirmer l'Emprunt">
    <input type="button" value="Retourner" onclick="window.location.href='bookSearch.php'">
</form>

<?php include '_footer.php' ?>
