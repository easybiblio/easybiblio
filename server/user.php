<?php include '_header.php' ?>

<h1><?= $t->__('db.user') ?></h1>

<?php
  $action = "create";
  $username = $_GET['username'];
  if ($username != '') {
    $columns = $database->get("tb_user", array("username", "fullname", "email", "usertype", "date_creation"), array("username" => $username));
    if (isset($columns['username'])) {
        $action = "update";
    }
  }
?>

<form id="user_form" class="form-horizontal" action="userAction.php?action=<?= $action ?>" method="post" role="form">

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.user.username') ?>:</label>
    <div class="col-sm-10">
      <input id="username" type="text" name="username" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'username') ?> maxlength="120">
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.user.fullname') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="fullname" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'fullname') ?> maxlength="120">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.user.email') ?>:</label>
    <div class="col-sm-10">
      <input type="text" name="email" class="form-control" value=<?= $fmw->getPostOrArrayQuoted($columns, 'email') ?> maxlength="100">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2"><?= $t->__('db.user.usertype') ?>:</label>
    <div class="col-sm-10">
        <select name="usertype" class="form-control">
            <option value="0" <?= $columns['usertype'] == 0 ? "selected" : "" ?> >Guest</option>
            <option value="8" <?= $columns['usertype'] == 8 ? "selected" : "" ?> >Operator</option>
            <option value="9" <?= $columns['usertype'] == 9 ? "selected" : "" ?> >Admin</option>
        </select>   
    </div>
  </div>
    
  <?php if ($username == '') { ?>
      <div class="form-group">
        <label class="control-label col-sm-2"><?= $t->__('db.user.password') ?>:</label>
        <div class="col-sm-10">
          <input id="password" type="password" name="password" class="form-control" maxlength="100">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?= $t->__('db.user.password_verify') ?>:</label>
        <div class="col-sm-10">
          <input id="verify_password" type="password" name="password_verify" class="form-control" maxlength="100">
        </div>
      </div>
  <?php } else { ?>
      <div class="form-group">
        <label class="control-label col-sm-2"><?= $t->__('db.user.date_creation') ?>:</label>
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
      <input type="button" class="btn btn-default" value="<?= $t->__('button.cancel') ?>" onclick="window.location.href='userList.php'">
    </div>
  </div>
</form>

<script src="js/sjcl.js"></script>
<script>
    $(function() {
        $('#user_form').submit(function() {
            
            // If password field is present, then it is a new user
            if ($("#password").length > 0) {
              
                var username = $('#username');
                var password = $('#password');
                var verify_password = $('#verify_password');
                if (password.val() === '' || password.val() != verify_password.val()) {
                    alert('<?= $t->__('userActionSave.message.passworDoesNotMatch') ?>');
                    password.focus();
                    return false;
                }

                // Hashing password
                var hashed = username.val() + password.val();
                for(i=0; i<=2048;i++) {
                    var bitArray = sjcl.hash.sha256.hash(hashed);  
                    var hashed = sjcl.codec.hex.fromBits(bitArray); 
                }
                password.val(hashed);
            }

            return true; // return false to cancel form action
        });
    });
</script>

<?php include '_footer.php' ?>