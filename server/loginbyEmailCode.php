<?php include '_header.php' ?>

<div class="container" style="margin-top:30px">
    <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title"><strong><?= $t->__('loginbyEmail.title') ?> </strong></h3></div>
          <div class="panel-body">
           <form id="login" action="loginByEmailCodeAttempt.php" method="post" role="form">
              <input id="email" type="hidden" name='email' value="<?= trim($_GET['email']); ?>" />
              <div class="form-group">
                <label for="email"><?= $t->__('loginbyEmail.email') ?></label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="emailForVisualization" type="text" name='emailForVisualization' value="<?= trim($_GET['email']); ?>" class="form-control" disabled="true"/>
                </div>
              </div>
               
              <div class="form-group">
                <label for="logincode"><?= $t->__('loginbyEmailCode.code') ?></label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="logincode" type="text" name='logincode' class="form-control" placeholder="<?= $t->__('loginbyEmailCode.tip.code') ?>">
                </div>
              </div>
               
              <button type="submit" class="btn btn-sm btn-default"><?= $t->__('loginbyEmailCode.button.verifyCode') ?></button>
            </form>
          </div>
        </div>
    </div>
</div>

<script src="js/sjcl.js"></script>
<script>
    $(function() {
        // Focus on email
        $('#logincode').focus();
    });
</script>

<?php include '_footer.php' ?>