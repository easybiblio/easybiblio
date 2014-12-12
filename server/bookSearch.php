<?php include '_header.php' ?>
    
<h1>Liste de livres</h1>

<?php
    $search_string = $_POST['search_book'];
    if (!isset($search_string)) {
        $search_string = $_SESSION['search_book'];
    } else {
        $_SESSION['search_book'] = $search_string;
    }
    $search_string = trim($search_string);
?>
<form method="post">
    <input type="search" name="search_book" value="<?= $fmw->escapeHtml($search_string) ?>" autofocus/>
    <input type="submit" value="Recherche"/>
    <input type="button" value="Nouveau livre" onclick="window.location.href='book.php'" />
</form>

<br/>

<table border=1 cellpadding="5" cellspacing="0">
    <tr>
        <th>Code</th>
        <th>Cover</th>
        <th>Title</th>
        <th>Author</th>
        <th>CoAuthor</th>
        <th>Type</th>
        <th>Action</th>
    </tr>
<?php

$search_string = strtr($search_string, " ", "%");
$search_string_quoted = $database->quote("%".$search_string."%");
$query = "select tb_book.*, !isnull(tb_lend.id) as lended, tb_lend.id as lend_id, tb_type.name as typeName " .
           "from (select * from tb_book where code like ".$search_string_quoted." or title like ".$search_string_quoted." or author like ".$search_string_quoted." or coauthor like ".$search_string_quoted." order by date_creation desc) tb_book ".
           "left join (select id, book_id from tb_lend where date_return is null) tb_lend on tb_book.id = tb_lend.book_id " .
           "left join tb_type on tb_book.type_id = tb_type.id";

$datas = $database->query($query)->fetchAll();

$counter = 0;
foreach($datas as $row) {
    $counter++;
    $fmw->escapeHtmlArray($row);
    if ($row['lended']) {
        echo "<tr class='lended'>";
    } else {
        echo "<tr>";
    }
    echo "<td>";
    echo $row['code'];
    echo "</td>";
    
    // Existing cover
    echo "<td>";
    if ($row['cover_url'] != '') {
        $img_src_nocache = $fmw->escapeHtml($row['cover_url']) . '?' . time();
        echo "<img src='".$img_src_nocache."' width='150'/>";
    }
    echo "</td>";
    
    echo "<td>";
    echo "<a href='book.php?id=" . $row['id'] . "'>" . $row['title'] . '</a>';
    echo "</td>";
    echo "<td>";
    echo $row['author'];
    echo "</td>";
    echo "<td>";
    echo $row['coauthor'];
    echo "</td>";
    echo "<td>";
    echo $row['typeName'];
    echo "</td>";
    echo "<td>";
    
    if ($row['lended']) {
        echo "<a href='bookReturn.php?lend_id=" . $row['lend_id'] . "'>" . 'Retourner</a>';
    } else {
        echo "<a href='bookLend.php?book_id=" . $row['id'] . "'>" . 'Emprunter</a>';
    }
    
    echo "</td>";
    echo "</tr>\n";
    if ($counter == 20) {
        echo "<tr><td colspan='100' align='center'>Il y a plus de livres...</td></tr>";
        break;
    }
}

?>

</table>


<?php include '_footer.php' ?>
