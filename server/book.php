<?php include '_header.php' ?>

<script>

function loadImage() {
    var imgToLoad = $("#cover_url").val();

	var img = $("<img/>")
	.load(function(e) {
		$("#imageContainer").replaceWith(e.target);
	})
    .attr("id","imageContainer")
    .attr("width", 260)
	.attr("src",imgToLoad);
}

</script>

<h1><?= $t->__('db.book') ?></h1>

<?php
  $id = $_GET['id'];
  if (!isset($id)) {
    $id = $_POST['id'];
  }
  if ($id != '') {
    $columns = $database->get("tb_book", "*", array('id' => $id));
  } else {
    $columns = array();
    $columns['language'] = 'pt'; // Default value
  }

  function prepareLanguageOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_language", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['language']);
          echo $valueToSelect == $row['language'] ? "selected" : "";
          echo ">";
          echo $row['language_name'];
          echo "</option>";
      }
  }

  function prepareCategoryOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_category", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['id']);
          echo $valueToSelect == $row['id'] ? "selected" : "";
          echo ">";
          echo $row['name'];
          echo "</option>";
      }
  }

  function prepareTypeOptions($valueToSelect) {
      global $database;
      $data = $database->select("tb_type", '*');
      foreach ($data as $row) {
          echo "\n<option value=";
          echo $database->quote($row['id']);
          echo $valueToSelect == $row['id'] ? "selected" : "";
          echo ">";
          echo $row['name'];
          echo "</option>";
      }
  }

?>

<form action="bookSave.php" class="form-horizontal" method="post">

<!-- ID -->
<input type="hidden" name="id" value="<?= $id ?>">

<div class="row">
<div class="col-sm-7">

  <!-- Code --> 
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.code') ?>:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="code" value=<?= $fmw->getPostOrArrayQuoted($columns, 'code') ?>  maxlength="45">
    </div>
  </div>

  <!-- Type -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.type') ?>:</label>
    <div class="col-sm-10">
        <select name="type_id" class="form-control" size="1">
            <?php prepareTypeOptions( $fmw->getPostOrArray($columns, 'type_id') ); ?>
        </select>
    </div>
  </div>

  <!-- Title -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.title') ?>:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="title" value=<?= $fmw->getPostOrArrayQuoted($columns, 'title') ?>  maxlength="100">
    </div>
  </div>
    
  <!-- Description -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.description') ?>:</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="5" name="description"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'description')) ?></textarea>
    </div>
  </div>
    
  <!-- Author -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.author') ?>:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="author" value=<?= $fmw->getPostOrArrayQuoted($columns, 'author') ?> maxlength="100">
    </div>
  </div>
    
  <!-- CoAuthor -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.coauthor') ?>:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="coauthor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'coauthor') ?> maxlength="100">
    </div>
  </div>
    
  <!-- Editor -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.editor') ?>:</label>
    <div class="col-sm-10">
<input type="text" class="form-control" name="editor" value=<?= $fmw->getPostOrArrayQuoted($columns, 'editor') ?> maxlength="100">
    </div>
  </div>
    
  <!-- Year of publication -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.year_publication') ?>:</label>
    <div class="col-sm-10">
<input type="number" class="form-control" name="year_publication" value=<?= $fmw->getPostOrArrayQuoted($columns, 'year_publication') ?>  maxlength="4">
    </div>
  </div>
    
  <!-- Language -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.language') ?>:</label>
    <div class="col-sm-10">
        <select class="form-control" name="language">
            <?php prepareLanguageOptions( $fmw->getPostOrArray($columns, 'language') ); ?>
	    </select>
    </div>
  </div>
    
  <!-- Category -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.category') ?>:</label>
    <div class="col-sm-10">
    <select class="form-control" name="category_id">
        <?php prepareCategoryOptions( $fmw->getPostOrArray($columns, 'category_id') ); ?>
	</select>
    </div>
  </div>
        
  <!-- Notes -->
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.notes') ?>:</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="5" cols="47" name="notes"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'notes')) ?></textarea>
    </div>
  </div>
    
  <?php if ($id != '') { ?>
  <!-- Creation date -->
  <div class="form-group">
    <label class="control-label col-md-2"><?= $t->__('db.book.date_creation') ?>:</label>
    <div class="col-sm-10">
        <p class="form-control-static"><?= $fmw->getPostOrArray($columns, 'date_creation') ?></p>
    </div>
  </div>
  <?php } ?>

</div>


<div class="col-sm-5">
    
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.book.cover') ?>:</label>
    <div class="col-sm-10">
        <input id='cover_url' type="text" class="form-control" name="cover_url" value=<?= $fmw->getPostOrArrayQuoted($columns, 'cover_url') ?> onInput="loadImage();"/><br/>
<img id='imageContainer' src=<?= $fmw->getPostOrArrayQuoted($columns, 'cover_url') ?> width= "260" />
    </div>
  </div>

</div>
    
</div>

<!-- Buttons -->
<div class="row">

        <div class="col-sm-10">
          <?php if ($fmw->isLoggedInContributor()) { ?>
            <input type="submit" class="btn btn-default" name="Submit" value="<?= $t->__('button.save') ?>">
          <?php } ?>
          <input type="button" class="btn btn-default" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='bookSearch.php'" >
        </div>

</div>
    
</form>

<?php include '_footer.php' ?>