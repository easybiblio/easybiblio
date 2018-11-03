<?php
  include_once '_header.mandatory.php';
  $fmw->checkOperator();
  include '_header.php';
?>

<h1><?= $t->__('reportStatistics.title') ?></h1>

<?php
  $query_books_per_language = "select total, language_name from (select language, count(*) total from tb_book where lost = 0 group by language) tb_book inner join tb_language on tb_book.language = tb_language.language";
  
  $data = $database->query($query_books_per_language)->fetchAll();
    
  $numberBooks = $database->count("tb_book", ["lost" => 0]);
  $numberBooksLost = $database->count("tb_book", ["lost" => 1]);
  $numberPersons = $database->count("tb_person");
  $numberLendedBooks = $database->count("tb_lend");
  $numberLendedBooksToday = $database->count("tb_lend", array("date_return" => null));
?>

<h3><?= $t->__('reportStatistics.total_books')?></h3>
<table class="table table-hover">
<?php
  foreach($data as $row) {
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>", $row['language_name'], "</td>";
    echo "<td>", $row['total'], "</td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<td><strong>", $t->__('reportStatistics.total_books'), "</strong></td>";
  echo "<td><strong>", $numberBooks, "</strong></td>";
  echo "</tr>";
?>
</table>

<?= $t->__('reportStatistics.total_books_lost') ?>: <?= $numberBooksLost ?><br/>
<?= $t->__('reportStatistics.total_people') ?>: <?= $numberPersons ?><br/>
<?= $t->__('reportStatistics.total_lent') ?>: <?= $numberLendedBooks ?><br/>
<br/>
<?= $t->__('reportStatistics.total_lent_today') ?>: <?= $numberLendedBooksToday ?>

<?php include '_footer.php' ?>
