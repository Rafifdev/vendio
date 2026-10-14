<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vendio | Verifikasi OTP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/plugins/iCheck/square/blue.css">
  <style type="text/css">
    .login-box-body {
      border-top: 5px solid #D7320C;
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= site_url(); ?>">
      <img src="<?=base_url('asset/img/icon-wide.png')?>" height="40px"><br/>
      <small>Verifikasi Akun Bisnis</small>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Masukkan kode OTP yang telah dikirim ke email Anda</p>
    
    <?php if(isset($error) AND !empty($error)): ?>
         <div class="callout callout-error" style="color:#C82626">
              <h4>Error!</h4>
              <p><?= is_array($error) ? implode('<br>', $error) : $error; ?></p>
            </div>
    <?php endif; ?>
    <?php
    $message = $this->session->flashdata('f_message'); 
    $type = $this->session->flashdata('f_type'); 
    if ($message):
    ?>
   <div class="callout callout-<?= $type; ?>" style="<?= $type == 'success' ? 'color:#27ae60' : 'color:#C82626'; ?>">
        <p><?= $message; ?></p>
      </div>
    <?php endif; ?>
     <?= form_open(site_url('administrator/verify-otp'), [
        'name'    => 'form_otp', 
        'id'      => 'form_otp', 
        'method'  => 'POST'
      ]); ?>
      <div class="form-group has-feedback <?= form_error('otp') ? 'has-error' :''; ?>">
        <input type="text" class="form-control" placeholder="Kode OTP (6 digit)" name="otp" id="otp" maxlength="6" value="<?= set_value('otp'); ?>" required autofocus>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Verifikasi</button>
        </div>
        <!-- /.col -->
      </div>
    <?= form_close(); ?>

    <br>
    <div id="resend-countdown-box">
      <span class="text-muted">Tidak menerima kode? Kirim ulang dalam <b id="timer">60</b> detik</span>
    </div>
    <div id="resend-action-box" style="display: none;">
      <a href="<?= site_url('administrator/resend-otp'); ?>">Kirim ulang kode OTP</a>
    </div>
    <div style="margin-top: 6px;">
      <a href="<?= site_url('administrator/login'); ?>" class="text-center">Kembali ke halaman masuk</a>
    </div>
    <br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?= BASE_ASSET; ?>/admin-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= BASE_ASSET; ?>/admin-lte/bootstrap/js/bootstrap.min.js"></script>
<script>
  $(function () {
    var countdown = 60;
    var $timer = $('#timer');
    var $countdownBox = $('#resend-countdown-box');
    var $actionBox = $('#resend-action-box');

    var interval = setInterval(function() {
      countdown--;
      $timer.text(countdown);
      if (countdown <= 0) {
        clearInterval(interval);
        $countdownBox.hide();
        $actionBox.show();
      }
    }, 1000);
  });
</script>
</body>
</html>
