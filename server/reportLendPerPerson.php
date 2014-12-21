<?php include '_header.php' ?>
    
<h1><?= $t->__('reportLendPerPerson.title') ?></h1>

<?php
    
  $person_id = $_GET['person_id'];
  if ($person_id != '') {
    $person_columns = $database->get("tb_person", "*", array("id" => $person_id));
    $fmw->escapeHtmlArray($person_columns);
  }
    
    $query = "select *, tb_lend.id as lend_id, DATEDIFF(now(), date_lend) as late_days from (select * from tb_lend where person_id = " . $person_id . ") tb_lend left join tb_book on tb_lend.book_id = tb_book.id order by date_lend";

    $datas = $database->query($query)->fetchAll();
?>

<?= $t->__('db.person') ?>:
<table width="70%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td width="1%"><?= $t->__('db.person.name') ?>:</td>
    <td><?=$person_columns['name'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.city') ?>:</td>
    <td><?=$person_columns['city'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.phone1') ?>:</td>
    <td><?=$person_columns['phone1'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.phone2') ?>:</td>
    <td><?=$person_columns['phone2'] ?></td>
  </tr>
  <tr>
    <td><?= $t->__('db.person.email') ?>:</td>
    <td><?=$person_columns['email'] ?></td>
  </tr>
</table>

<br/>
<br/>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th><?= $t->__('db.lend.date_lend') ?></th>
        <th><?= $t->__('db.lend.date_return') ?></th>
        <th><?= $t->__('reportLendPerPerson.label.days') ?></th>
        <th><?= $t->__('db.book') ?></th>
        <th><?= $t->__('db.book.author') ?></th>
        <th><?= $t->__('db.book.coauthor') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    if (!isset($row['date_return'])) {
        echo "<tr class='lended'>";
    } else {
        echo "<tr>";
    }
    echo "<td>";
    echo $row['date_lend'];
    echo "</td>";
    echo "<td>";
    echo $row['date_return'];
    echo "</td>";
    echo "<td>";
    echo $row['late_days'];
    echo "</td>";
    echo "<td>";
    echo "<a href='book.php?id=" . $row['id'] . "'>(" . $row['code'] .") " . $row['title'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['author'];
    echo "</td>";
    echo "<td>";
    echo $row['coauthor'];
    echo "</td>";
    echo "<td>";
    
    if (!isset($row['date_return'])) {
        echo "<a href='bookReturn.php?lend_id=" . $row['lend_id'] . "'>" . 'Retourner</a>';
    }
    
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>

<br/>
<?= $t->__('reportLendPerPerson.message.total_lent_books') ?>: <?=$counter?>

<?php include '_footer.php' ?>
