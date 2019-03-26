<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <?php $this->load->view('_partials/head.php');?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo BASE_URL();?>"><?php echo SITE_NAME?></a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Sign in untuk mulai monitoring</p>
    <?php
    if ($this->session->flashdata('error')): ?>
      <script>
        swal({
          title: "Error",
          text: "<?php echo $this->session->flashdata('error'); ?>",
          showConfirmButton: true,
          type: 'error',
          button: "Ok",
        });
      </script>
    <?php endif; ?>
    <form action="<?php echo BASE_URL()."index.php/login/auth"?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      </div>
    </form>

    <a href="#">Lupa password?</a><br>
    <a href="register.html" class="text-center">Daftar disini</a>

  </div>
  <!-- /.login-box-body -->
</div>
<?php $this->load->view('_partials/js.php')?>
</body>
</html>
