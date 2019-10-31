<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <meta name="author" content="limakode.com">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>asset/logo/favicon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/admin/plugins/iCheck/square/blue.css">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a style='display:block' href="#">SMK YPM 8<b>  SIDOARJO</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php 
          echo "<center><img style='width:150px' 

          src='".base_url()."asset/admin/dist/img/sekolah_ypm.png'></center><br/>";
          echo "<center>".$this->session->flashdata('message')."</center>";
          echo form_open('login/index');
        ?>
         <p class="login-box-msg">Silahkan Login Pada Form dibawah ini</p>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name='a' placeholder="Username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name='b' placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button name='submit' type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a class='link' data-dismiss="modal" aria-hidden="true" data-toggle='modal' href='#lupapass' data-target='#lupapass'>Anda Lupa Password?</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>/asset/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>/asset/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>/asset/admin/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

<div class="modal fade" id="lupapass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel">Lupa Password Login?</h5>
      </div><center>
      <div class="modal-body">
                  <?php 
                      $attributes = array('class'=>'form-horizontal');
                      echo form_open('administrator/lupapassword',$attributes); 
                  ?>
                    <div class="form-group">
                        <center style='color:red'>Masukkan Email yang terkait dengan akun!</center><br>
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div style='background:#fff;' class="input-group col-sm-8">
                            <span class="input-group-addon"><i class='fa fa-envelope fa-fw'></i></span>
                            <input style='text-transform:lowercase;' type="email" class="required form-control" name="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3">
                            <button type="submit" name='lupa' class="btn btn-primary btn-sm">Kirimkan Permintaan</button>
                            &nbsp; &nbsp; &nbsp;<a data-dismiss="modal" aria-hidden="true" data-toggle='modal' href='#login' data-target='#login' title="Lupa Password Members">Kembali Login?</a>
                        </div>
                    </div>

                </form><div style='clear:both'></div>
      </div>
      </center>
    </div>
  </div>
</div>
        
  </body>
</html>
