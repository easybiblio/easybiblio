<?php include '_header.php' ?>
    
<h1>Liste de livres empruntées</h1>

<?php
    $query = "select *, tb_lend.id as lend_id, tb_lend.notes as notes, tb_book.code as book_code, DATEDIFF(now(), date_lend) as late_days ".
               "from (select * from tb_lend where date_return is null) tb_lend left join tb_book ".
                "on tb_lend.book_id = tb_book.id left join tb_person on tb_lend.person_id = tb_person.id order by date_lend";

    $datas = $database->query($query)->fetchAll();
?>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th>Date Emprunt</th>
        <th>Jours</th>
        <th>Livre</th>
        <th>Personne</th>
        <th>Phone1</th>
        <th>Phone2</th>
        <th>E-mail</th>
        <th>Notes</th>
        <th>Actions</th>
    </tr>
<?php

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo $row['date_lend'];
    echo "</td>";
    echo "<td>";
    echo $row['late_days'];
    echo "</td>";
    echo "<td>";
    echo "<a href='book.php?id=" . $row['book_id'] . "'>(" . $row['book_code'] . ') ' . $row['title'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo "<a href='person.php?id=" . $row['person_id'] . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['phone1'];
    echo "</td>";
    echo "<td>";
    echo $row['phone2'];
    echo "</td>";
    echo "<td>";
    echo $row['email'];
    echo "</td>";
    echo "<td>";
    echo $row['notes'];
    echo "</td>";
    echo "<td>";
    echo "<a href='bookLendEditNotes.php?lend_id=" . $row['lend_id'] . "'>" . 'Changer&nbsp;Notes</a>';
    echo "&nbsp;&nbsp;&nbsp";
    echo "<a href='bookReturn.php?lend_id=" . $row['lend_id'] . "'>" . 'Retourner</a>';
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>

<br/>
Total de livres empruntées: <?=$counter?>

<?php include '_footer.php' ?>
