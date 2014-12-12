<?php include '_header.php' ?>
    
<h1>Liste de personnes</h1>

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
    <input type="submit" value="Recherche"/>
    <input type="button" value="Nouvelle personne" onclick="window.location.href='person.php'" />
</form>

<br/>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th>Nom/Prenom</th>
        <th>Ville</th>
        <th>Phone 1</th>
        <th>Phone 2</th>
        <th>E-mail</th>
        <th>Action</th>
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
    echo "<a href='reportLendPerPerson.php?person_id=" . $row['id'] . "'>Livres empruntées</a>";
    echo "</td>";
    echo "</tr>\n";
    if ($counter == 20) {
        echo "<tr><td colspan='100' align='center'>Il y a plus de personnes...</td></tr>";
        break;
    }
}

?>

</table>


<?php include '_footer.php' ?>
