<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Ganti Logo Website PPDB</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example" class="table table-bordered table-striped">
        <tbody>
          <?php
          $attributes = array('class' => 'form-horizontal', 'role' => 'form');
          echo form_open_multipart($this->uri->segment(1) . '/logo_header', $attributes);
          ?>
          <tr>
            <input type='hidden' name='id' value='<?php echo $data[id_header_banner] ?>'>
            <input type='hidden' name='foto' value='asset/logo/<?php echo $data[gambar] ?>'>
            <?php echo $error; ?>
          </tr>
          <tr>
            <td width=120px>Logo Terpasang</td>
            <td><a href=''><img width='100%' src='<?php echo base_url()."psb/asset/logo/".$data[gambar] ?>'></a></td>
          </tr>
          <tr>
            <td>Ganti Logo</td>
            <td>
              <input type='file' name='logo' class='form-control'></td>
          </tr>
          <tr>
            <td></td>
            <td>
              <div class='box-footer'>
                <button type='submit' name='submit' class='btn btn-info'>Update</button>
                <a href='".base_url().$this->uri->segment(1)."/logo_header'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>
            </td>
          </tr>
          <?php echo form_close();
          ?>
        </tbody>
      </table>
    </div>