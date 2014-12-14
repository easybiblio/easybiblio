<?php require_once '../_header.mandatory.php';
    $search_string = $_GET['search_book'];
    $search_string = trim($search_string);
    $search_string = strtr($search_string, " ", "%");
    $search_string_quoted = $database->quote("%".$search_string."%");

    // Maximum number of results
    $sql_limit = '';
    $max = $_GET['max'];
    if (isset($max)) {
        // This convertion is important to avoid SQL Injection, please do not remove it.
        $max = (int) $max;
        $sql_limit = ' limit '.$max;
    }

    $query = "select tb_book.*, !isnull(tb_lend.id) as lended, tb_lend.id as lend_id, tb_type.name as typeName " .
           "from (select * from tb_book where code like ".$search_string_quoted." or title like ".$search_string_quoted." or author like ".$search_string_quoted." or coauthor like ".$search_string_quoted." order by date_creation desc) tb_book ".
           "left join (select id, book_id from tb_lend where date_return is null) tb_lend on tb_book.id = tb_lend.book_id " .
           "left join tb_type on tb_book.type_id = tb_type.id " . $sql_limit;

    $datas = $database->query($query)->fetchAll();
    $fmw->echo_json($datas);
?>
