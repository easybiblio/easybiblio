<?php
    include_once '_header.mandatory.php';
    $fmw->checkAdmin();
    include '_header.php';
?>

<script src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea.editme",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
 });
    
function loadImage() {
    var imgToLoad = $("#site_logo_url").val();

    var img = $("<img/>")
      .load(function(e) {
         $("#imageContainer").replaceWith(e.target);
      })
      .attr("id","imageContainer")
      .attr("width", 260)
      .attr("src",imgToLoad);
}
    
</script>

<h1><?= $t->__('db.about') ?></h1>

<?php
    $columns = $config->about;
?>

<form class="form-horizontal" action="aboutSave.php" method="post" role="form">

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_shortname') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="site_shortname" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_shortname') ?> maxlength="30">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_longname') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="site_longname" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_longname') ?> maxlength="120">
    </div>
  </div>
    
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_meta_description') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="site_meta_description" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_meta_description') ?> maxlength="200">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_meta_keywords') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="site_meta_keywords" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_meta_keywords') ?> maxlength="200">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_logo_url') ?>:</label>
    <div class="col-sm-10">
        <input id='site_logo_url' type="text" class="form-control" name="site_logo_url" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_logo_url') ?> onInput="loadImage();"/><br/>
<img id='imageContainer' src=<?= $fmw->getPostOrArrayQuoted($columns, 'site_logo_url') ?> width= "260" />
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.about.site_max_lent_books') ?>:</label>
    <div class="col-sm-10">
        <input id='site_max_lent_books' type="text" class="form-control" name="site_max_lent_books" value=<?= $fmw->getPostOrArrayQuoted($columns, 'site_max_lent_books') ?> maxlength="1">
    </div>
  </div>
    
  <label class="control-label"><?= $t->__('db.about.site_welcome') ?>:</label>
    
  <div class="form-group">
    <div class="col-lg-12">
      <textarea rows="15" class="form-control editme" name="site_welcome"><?= $fmw->escapeHtml($fmw->getPostOrArray($columns, 'site_welcome')) ?></textarea>
    </div>
  </div>

  <!-- Buttons -->
  <div class="form-group">
    <label class="control-label col-sm-2">&nbsp;</label>
    <div class="col-sm-10">
      <input type="submit" class="btn btn-default" name="Submit" value="<?= $t->__('button.save') ?>">
    </div>
  </div>
</form>

<?php include '_footer.php' ?>