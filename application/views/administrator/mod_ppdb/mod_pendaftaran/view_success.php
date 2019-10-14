<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Informasi Setelah Sukses Ini Formulir</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php 
          echo "<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><td><textarea class='form-control textarea' name='b' style='height:350px'>$s[informasi]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='update' class='btn btn-info'>Update</button>
              </div>
              </form>";
        ?>
    </div>
  </div>
</div>