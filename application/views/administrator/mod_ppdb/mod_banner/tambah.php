<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Tambah Banner Baru</h3>
    </div>
    <div class='box-body'>
      <?php
      $attributes = array('class' => 'form-horizontal', 'role' => 'form');
      echo form_open_multipart($this->uri->segment(1) . '/tambah_banner', $attributes);
      ?>
      <div class='col-md-12'>
        <table class='table table-condensed table-bordered'>
          <tbody>
            <?php echo $error; ?>
            <input type='hidden' name='id' value=''>
            <tr>
              <td width='120px'>Cari Banner</td>
              <td><input type='file' name='foto' class='form-control'></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class='box-footer'>
        <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
        <a href='<?php echo base_url().$this->uri->segment(1)."/banner" ?>'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>

      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>