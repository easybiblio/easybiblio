<?php include '_header.php' ?>
    
<h1><?= $t->__('reportStatistics.title') ?></h1>

<?php
  $numberBooks = $database->count("tb_book");
  $numberPersons = $database->count("tb_person");
  $numberLendedBooks = $database->count("tb_lend");
  $numberLendedBooksToday = $database->count("tb_lend", array("date_return" => null));
?>


<?= $t->__('reportStatistics.total_books') ?>: <?= $numberBooks ?><br/>
<?= $t->__('reportStatistics.total_people') ?>: <?= $numberPersons ?><br/>
<?= $t->__('reportStatistics.total_lent') ?>: <?= $numberLendedBooks ?><br/>
<br/>
<?= $t->__('reportStatistics.total_lent_today') ?>: <?= $numberLendedBooksToday ?>

<br/>
<br/>
<a href="backup.php"><?= $t->__('reportStatistics.link_backup') ?></a>

<br/>
<br/>
<a href="bookCoverSearch.php"><?= $t->__('reportStatistics.link_addBookCover') ?></a>


<?php include '_footer.php' ?>
