<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Edit Banner</h3>
    </div>
    <div class='box-body'>
      <?php
      $attributes = array('class' => 'form-horizontal', 'role' => 'form');
      echo form_open_multipart($this->uri->segment(1) . '/edit_banner', $attributes);
      ?>
      <div class='col-md-12'>
        <table class='table table-condensed table-bordered'>
          <tbody>
            <?php echo $error; ?>
            <input type='hidden' name='id' value='<?php echo $s['id_header_banner'] ?>'>
            <tr>
              <td width=120px>Banner</td>
              <td>
                <input type='hidden' name='foto' value='<?php echo "asset/banner/" . $s[gambar] ?>'>
                <img width='400px' src='<?php echo base_url() . "asset/banner/" . $s[gambar] ?>'>
              </td>
            </tr>
            <tr>
              <td>Ganti Banner</td>
              <td><input type='file' name='foto' class='form-control'></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class='box-footer'>
        <button type='submit' name='submit' class='btn btn-info'>Update</button>
        <a href='<?php echo base_url() . $this->uri->segment(1) . "/banner" ?>'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>

      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>