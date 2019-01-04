<?php
    include_once '_header.mandatory.php';
    $fmw->checkOperator();
    include '_header.php';
?>

<h1><?= $t->__('db.person') ?></h1>

<?php
  $id = $_GET['id'];
  if ($id != '') {
    $columns = $database->get("tb_person", "*", array("id" => $id));
  }
?>

<form class="form-horizontal" action="personSave.php" method="post" role="form">

  <!-- ID -->
  <input type="hidden" name="id" value="<?= $columns['id'] ?>">

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.name') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="name" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'name') ?> maxlength="120">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.address') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="address" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'address') ?> maxlength="120">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.zipcode') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="zipcode" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'zipcode') ?> maxlength="10">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.city') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="city" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'city') ?> maxlength="45">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.phone1') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="phone1" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'phone1') ?> maxlength="45">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.phone2') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="phone2" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'phone2') ?> maxlength="45">
    </div>
  </div>
    
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.email') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="email" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'email') ?> maxlength="100">
    </div>
  </div>
    
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.notes') ?>:</label>
    <div class="col-sm-10">
      <textarea rows="6" cols="47" class="form-control" name="notes"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'notes')) ?></textarea>
    </div>
  </div>
    
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.active') ?></label>
    <div class="col-sm-1">
      <input type="checkbox" name="active" class="form-control" value='1' <?= $fmw->getPostOrArray($columns, 'active') == '1' ? 'checked' : '' ?> >
    </div>
    <p class="form-control-static"><?= $t->__('db.person.active_explanation') ?></p>
  </div>
    
  <?php if ($id != '') { ?>
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.person.date_creation') ?>:</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?= $fmw->getPostOrArray($columns, 'date_creation') ?></p>
    </div>
  </div>
  <?php } ?>

  <!-- Buttons -->
  <div class="form-group">
    <label class="control-label col-sm-2">&nbsp;</label>
    <div class="col-sm-10">
      <input type="submit" class="btn btn-default" name="Submit" value="<?= $t->__('button.save') ?>">
      <input type="button" class="btn btn-default" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='personSearch.php'">
    </div>
  </div>
</form>

<?php include '_footer.php' ?>