<?php include '_header.php' ?>
    
<h1><?= $t->__('title.list_of_people') ?></h1>

<?php
    $search_string = $_POST['search_person'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_person'];
    } else {
        $_SESSION['search_person'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form method="post">
    <input type="search" name="search_person" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    <input type="submit" value="<?= $t->__('button.search') ?>"/>
    <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='person.php'" />
</form>

<br/>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th><?= $t->__('db.person.name') ?></th>
        <th><?= $t->__('db.person.city') ?></th>
        <th><?= $t->__('db.person.phone1') ?></th>
        <th><?= $t->__('db.person.phone2') ?></th>
        <th><?= $t->__('db.person.email') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$search_string = strtr($search_string, " ", "%");
$datas = $database->select("tb_person", "*",  array(
                    'LIKE' => array(
                        'OR' => array( 'name' => $search_string,
                                  'email' => $search_string )
                              ),
                    'ORDER' => "ID DESC"
                    ));

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo "<a href='person.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['zipcode'].' '.$row['city'];
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
    echo "<a href='reportLendPerPerson.php?person_id=" . $row['id'] . "'>". $t->__('label.report_lent_books') ."</a>";
    echo "</td>";
    echo "</tr>\n";
    if ($counter == 20) {
        echo "<tr><td colspan='100' align='center'>" . $t->__('message.there_are_more_people') . "</td></tr>";
        break;
    }
}

?>

</table>


<?php include '_footer.php' ?>
