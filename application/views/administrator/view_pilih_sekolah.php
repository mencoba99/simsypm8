<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMASTA | Jenjang Pendidikan</title>
    <meta name="author" content="limakode.com">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/iCheck/flat/blue.css">
  </head>
  <body class="hold-transition login-page">
    <div class="jenjang-pendidikan">
      <div class="login-logo">
        <a style='display:block' href="#"><b>SIM</b>ASTA</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"><a class='btn btn-xs btn-primary pull-left' href='' data-toggle="modal" data-target=".bs-example-modal-lg"><span class='fa fa-plus'></span></a> Silahkan Pilih Jenjang Pendidikan  <a class='btn btn-xs btn-default pull-right' href='<?php echo base_url(); ?>login/logout'><span class='fa fa-power-off'></span></a></p>
        <div class="col-md-12">
          <?php 
            $no=1;
            foreach ($sekolah->result_array() as $row) {
              if ($no==4 OR $no==5){ $grid = '6'; }else{ $grid = '4'; }
              echo "<div class='col-md-$grid' style='padding:5px;'>
                      <div class='box box-primary'>
                        <div class='box-body box-profile'>
                          <a href='#'><img class='profile-user-img img-responsive img-circle' src='".base_url()."asset/admin/dist/img/$row[logo]' alt='User profile picture'></a>
                          <p class='text-muted text-center'>$row[nama_sekolah]</p>";
                          if ($this->session->level=='guru'){
                            $detail = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session))->row_array();
                            $guru = $this->model_app->view_where('rb_guru',array('id_identitas_sekolah'=>$row['id_identitas_sekolah'],'nip'=>$detail['nip']));
                            if ($guru->num_rows()<=0){ 
                              echo "<a href='' class='btn btn-danger btn-sm btn-block'><b style='text-decoration:line-through'>Akses System</b></a>";
                            }else{
                              echo "<a href='".base_url()."login/system/$row[id_identitas_sekolah]' class='btn btn-success btn-sm btn-block'><b>Akses System</b></a>";
                            }
                          }elseif ($this->session->level=='kepala'){
                            $kepala = $this->model_app->view_where('rb_users',array('id_identitas_sekolah'=>$row['id_identitas_sekolah'],'id_user'=>$this->session->id_session));
                            if ($kepala->num_rows()<=0){ 
                              echo "<a href='' class='btn btn-danger btn-sm btn-block'><b style='text-decoration:line-through'>Akses System</b></a>";
                            }else{ 
                              echo "<a href='".base_url()."login/system/$row[id_identitas_sekolah]' class='btn btn-success btn-sm btn-block'><b>Akses System</b></a>";
                            }
                          }elseif ($this->session->level=='siswa'){
                            $siswa = $this->model_app->view_where('rb_siswa',array('id_identitas_sekolah'=>$row['id_identitas_sekolah'],'id_siswa'=>$this->session->id_session));
                            if ($siswa->num_rows()<=0){ 
                              echo "<a href='' class='btn btn-danger btn-sm btn-block'><b style='text-decoration:line-through'>Akses System</b></a>";
                            }else{ 
                              echo "<a href='".base_url()."login/system/$row[id_identitas_sekolah]' class='btn btn-success btn-sm btn-block'><b>Akses System</b></a>";
                            }
                          }else{
                            echo "<a href='".base_url()."login/system/$row[id_identitas_sekolah]' class='btn btn-success btn-sm btn-block'><b>Akses System</b></a>";
                          } 
                        echo "</div>
                      </div>
                    </div>";
                $no++;
            }
          ?> 
        </div>
        <div style="clear:both"></div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambahkan Sekolah Baru</h4>
      </div>
      <form action='' method='POST'>
        <div class="modal-body">
          <table class='table table-condensed table-bordered'>
            <tbody>
              <tr><th width='120px' scope='row'>Jenjang</th>   <td><select class='form-control' name='aa'>
                                                                      <option value='' selected>- Pilih -</option>
                                                                      <?php 
                                                                        $jenjang = $this->model_app->view('rb_jenjang');
                                                                        foreach ($jenjang->result_array() as $row) {
                                                                          echo "<option value='$row[id_jenjang]'>$row[nama_jenjang]</option>";
                                                                        }
                                                                      ?>
                                                                   </select></td></tr>
              <tr><th scope='row'>Nama Sekolah</th>             <td><input type='text' class='form-control' name='a'></td></tr>
              <tr><th scope='row'>NPSN</th>                     <td><input type='text' class='form-control' name='b'></td></tr>
              <tr><th scope='row'>NSS</th>                      <td><input type='text' class='form-control' name='c'></td></tr>
              <tr><th scope='row'>Alamat Sekolah</th>           <td><textarea class='form-control' name='d'></textarea></td></tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" name='submit' class="btn btn-primary">Tambahkan</button>
        </div>
      </form>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>


          
