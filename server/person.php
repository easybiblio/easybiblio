<?php include '_header.php' ?>

<h1><?= $t->__('db.person') ?></h1>

<?php
  $id = $_GET['id'];
  if ($id != '') {
    $columns = $database->get("tb_person", "*", array("id" => $id));
  }
?>

<form action="personSave.php" method="post">

<!-- ID -->
<input type="hidden" name="id" value="<?= $columns['id'] ?>">

<table width="70%" border="0">

  <tr>
    <td width="10%"><strong><?= $t->__('db.person.name') ?>:</strong></td>
    <td><input type="text" name="name" value=<?= $fmw->getPostOrArrayQuoted($columns, 'name') ?> size="52" maxlength="120"></td>
  </tr>
  
  <tr>
    <td><strong><?= $t->__('db.person.address') ?>:</strong></td>
    <td><input type="text" name="address" value=<?= $fmw->getPostOrArrayQuoted($columns, 'address') ?> size="52" maxlength="120"></td>
  </tr>

  <tr>
    <td><?= $t->__('db.person.zipcode') ?>:</td>
    <td> 
      <input type="text" name="zipcode" value=<?= $fmw->getPostOrArrayQuoted($columns, 'zipcode') ?> size="52" maxlength="10"></td>
  </tr>
  
  <tr>
    <td><?= $t->__('db.person.city') ?>:</td>
    <td><input type="text" name="city" value=<?= $fmw->getPostOrArrayQuoted($columns, 'city') ?> size="52" maxlength="45"></td>
  </tr>

  <tr>
    <td><?= $t->__('db.person.phone1') ?>:</td>
    <td><input type="text" name="phone1" value=<?= $fmw->getPostOrArrayQuoted($columns, 'phone1') ?> size="52" maxlength="45"></td>
  </tr>
  
  <tr>
    <td><?= $t->__('db.person.phone2') ?>:</td>
    <td><input type="text" name="phone2" value=<?= $fmw->getPostOrArrayQuoted($columns, 'phone2') ?> size="52" maxlength="45"></td>
  </tr>
    
  <tr>
    <td><?= $t->__('db.person.email') ?>:</td>
    <td><input type="text" name="email" value=<?= $fmw->getPostOrArrayQuoted($columns, 'email') ?> size="52" maxlength="100"></td>
  </tr>
    
  <tr>
    <td><?= $t->__('db.person.notes') ?>:</td>
    <td>
        <textarea rows="6" cols="47" name="notes"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'notes')) ?></textarea>
    </td>
  </tr>
    
  <?php if ($id != '') { ?>
  <tr>
    <td><?= $t->__('db.person.date_creation') ?>:</td>
    <td><?= $fmw->getPostOrArray($columns, 'date_creation') ?></td>
  </tr>
  <?php } ?>
    
  <!-- Ligne vide -->
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <!-- Buttons -->
  <tr> 
    <td>&nbsp;</td>
    <td align="left" class="texte"> 
      <input type="submit" name="Submit" value="<?= $t->__('button.save') ?>">
      <input type="button" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='personSearch.php'"></td>
  </tr>

</table>

</form>

<?php include '_footer.php' ?>