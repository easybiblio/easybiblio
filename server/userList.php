<?php include '_header.php' ?>
    
<h1><?= $t->__('userList.title') ?></h1>

<form method="post">
  <input type="button" value="<?= $t->__('button.new') ?>" onclick="window.location.href='user.php'" />
</form>

<br/>

<table class="table table-hover">
    <tr>
        <th><?= $t->__('db.user.username') ?></th>
        <th><?= $t->__('db.user.fullname') ?></th>
        <th><?= $t->__('db.user.usertype') ?></th>
        <th><?= $t->__('label.action') ?></th>
    </tr>
<?php

$datas = $database->select("tb_user", "*");

foreach($datas as $row) {
    $fmw->escapeHtmlArray($row);

    $usertype = "Guest";
    if ($row['usertype'] == 9) {
        $usertype = "Admin";
    } else if ($row['usertype'] == 8) {
        $usertype = "Operator"; 
    }
    
    echo "<tr>";
    echo "<td>";
    echo "<a href='user.php?username=" . $row['username'] . "'>" . $row['username'] . '</a>';
    echo "</td>";
    echo "<td>", $row['fullname'], "</td>";
    echo "<td>", $usertype, "</td>";
    echo "<td>";
    echo "<a href='userAction.php?action=delete&username=" . $row['username'] . "'>". $t->__('label.action.delete') ."</a>";
    echo "</td>";
    echo "</tr>\n";
}

?>

</table>


<?php include '_footer.php' ?>