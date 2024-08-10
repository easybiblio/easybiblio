<?php include '_header.php' ?>

<div class="container" style="margin-top:30px">
    <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading"><h3 class="panel-title"><strong><?= $t->__('login.title') ?> </strong></h3></div>
          <div class="panel-body">
           <form id="login" action="loginAttempt.php" method="post" role="form">
              <div class="form-group">
                <label for="exampleInputEmail1"><?= $t->__('login.username') ?></label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="username" type="text" name='username' class="form-control" id="exampleInputEmail1" placeholder="<?= $t->__('login.tip.username') ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1"><?= $t->__('login.password') ?></label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" name='password' class="form-control" id="exampleInputPassword1" placeholder="<?= $t->__('login.tip.password') ?>">
                </div>
              </div>

              <button type="submit" class="btn btn-sm btn-default"><?= $t->__('login.button.login') ?></button>
            </form>
            <br/><a href="loginbyEmail.php"><?= $t->__('login.loginByEmail') ?></a>
          </div>
        </div>
    </div>
</div>

<script src="js/sjcl.js"></script>
<script>
    $(function() {
        // Focus on username
        $('#username').focus();
        
        // Code before login
        $('#login').submit(function() {
            var username = $('#username');
            var password = $('#password');

            // Hashing password
            var hashed = username.val() + password.val();
            for(i=0; i<=2048;i++) {
                var bitArray = sjcl.hash.sha256.hash(hashed);  
                var hashed = sjcl.codec.hex.fromBits(bitArray); 
            }
            password.val(hashed);
            
            return true; // return false to cancel form action
        });
    });
</script>

<?php include '_footer.php' ?>