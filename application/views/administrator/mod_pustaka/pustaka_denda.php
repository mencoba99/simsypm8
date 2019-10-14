<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Denda Keterlambatan </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php 
        echo "<form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/setting' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_denda]'>
                    <tr><th width='130px' scope='row'>Denda (Rp)</th> <td><input type='text' class='form-control' name='a' value='$s[nominal]'> 
                                            <small><i>Ctt : Isikan Nominal Denda Keterlamabatan per 1 buku untuk durasi perhari</i></small></td></tr>
                    <tr><th scope='row'>Keterangan</th> <td><textarea class='form-control' name='b'>$s[keterangan]</textarea></td></tr>
                    <tr><th scope='row'>Lama Pinjam (Max)</th> <td><input type='text' class='form-control' name='c' value='$e[durasi]' style='display:inline-block; width:100px'> Hari</td></tr>
                  </tbody>
                  </table>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='update' class='btn btn-info'>Update</button>
              </div>
              </form>";
      ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>