<?php include '_header.php' ?>
    
<h1>Statistiques</h1>

<?php
  $numberBooks = $database->count("tb_book");
  $numberPersons = $database->count("tb_person");
  $numberLendedBooks = $database->count("tb_lend");
  $numberLendedBooksToday = $database->count("tb_lend", array("date_return" => null));
?>

Total de Livres: <?= $numberBooks ?><br/>
Total de Personnes: <?= $numberPersons ?><br/>
Total d'Emprunts: <?= $numberLendedBooks ?><br/>
<br/>
Total de Livres Actuelement Empruntées: <?= $numberLendedBooksToday ?>

<?php include '_footer.php' ?>
