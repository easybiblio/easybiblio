<?php include '_header.php' ?>

<div class="container" style="margin-top:30px">
    <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title"><strong><?= $t->__('loginbyEmail.title') ?> </strong></h3></div>
          <div class="panel-body">
           <form id="login" action="loginbyEmailGenerateCode.php" method="post" role="form">
              <div class="form-group">
                <label for="exampleInputEmail1"><?= $t->__('loginbyEmail.email') ?></label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" type="text" name='email' class="form-control" placeholder="<?= $t->__('loginbyEmail.tip.email') ?>">
                </div>
              </div>
               
              <button type="submit" class="btn btn-sm btn-default"><?= $t->__('loginbyEmail.button.sendCode') ?></button>
            </form>
          </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Focus on email
        $('#email').focus();
    });
</script>

<?php include '_footer.php' ?>