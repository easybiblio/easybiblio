<?php include '_header.php' ?>
    
<h1><?= $t->__('personSearch.title') ?></h1>

<?php
    $search_string = $_POST['search_person'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_person'];
    } else {
        $_SESSION['search_person'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form class="navbar-form navbar-left" role="search" method="post">
    <input type="search" class="form-control" name="search_person" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    <input type="submit" class="btn btn-default" value="<?= $t->__('button.search') ?>"/>
    <input type="button" class="btn btn-default" value="<?= $t->__('button.new') ?>" onclick="window.location.href='person.php'" />
</form>

<br/>

<table class="table table-hover">
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
$search_string_quoted = $database->quote("%".$search_string."%");
        
$query = 'select * from tb_person left join (
select person_id, count(*) as qtt from tb_lend where date_return is null group by person_id ) qtt_livres ON tb_person.id = qtt_livres.person_id where name like ' . $search_string_quoted . ' or email like ' . $search_string_quoted . ' order by NAME';

$datas = $database->query($query)->fetchAll();

/* -- Old Simple Query
$datas = $database->select("tb_person", "*",  array(
                    'LIKE' => array(
                        'OR' => array( 'name' => $search_string,
                                  'email' => $search_string )
                              ),
                    'ORDER' => "ID DESC"
                    ));
*/

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    echo "<tr>";
    echo "<td>";
    echo "<a href='person.php?id=" . $row['id'] . "'>" . $row['name'] . '</a>';
    if (isset($row['qtt'])) {
        echo "&nbsp;<span class='badge'>", $row['qtt'], "</span>";
    }
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
