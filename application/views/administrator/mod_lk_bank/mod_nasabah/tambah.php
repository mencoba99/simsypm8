              <div class='box box-info'>
                  <div class='box-header with-border'>
                    <h3 class='box-title'>Tambah Data</h3>
                  </div>
                <div class='box-body'>
                  <?php
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/tambah_nasabah',$attributes);
                  ?>
                    <div class='col-md-12'>
                      <table class='table table-condensed table-bordered'>
                        <tbody>
                         
                          <input type='hidden' name='id' value=''>                                                    
                          <?php
                          echo"                                 
                          <tr><th width='120px'>Nama Nasabah</th>
                            <td>
                            <select class='form-control combobox' name='id_siswa' required>
                                <option value='' selected>Cari Nama Nasabah Terlebih Dahulu...</option>";
                                  foreach ($siswa as $row) {
                                    echo "<option value='$row[id_siswa]'>$row[nama]</option>";
                                  }
                            echo "</select>
                            </td>
                          </tr>";
                          ?>

                          <tr>
                            <th scope='row'>Saldo Awal</th> 
                              <td class='col-md-10'><input type='number' style="font-size: 20px" class='form-control' name='nasabah_saldo' required=""></td>
                          </tr>
                          <tr>
                            <th scope='row'>Keterangan</th> 
                              <td class='col-md-10'><input type='text' class='form-control' name='nasabah_keterangan'></td>
                          </tr>                    

                        </tbody>
                      </table>
                    </div>
                </div>
                <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                      <?php echo"<a href='".base_url()."".$this->uri->segment(1)."/view_nasabah'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>";?>
                </div>
                <?php echo form_close(); ?>
              </div>

<script type="text/javascript">
   function autofill() {
    var nasabah_nipd = $("#nasabah_nipd").val();
    $.ajax({
        url : "<?php echo base_url().$this->uri->segment(1).'/ajax_nasabah'?>",
        data : 'nasabah_nipd='+nasabah_nipd,       
    }).success(function(data){
      
      var json = data;
      obj = JSON.parse(json);
      $("#nasabah_nama").val(obj.nasabah_nama);
      $("#nasabah_kelas").val(obj.nasabah_kelas);
      $("#nasabah_jurusan").val(obj.nasabah_jurusan);
      $("#nasabah_tahun_angkatan").val(obj.nasabah_tahun_angkatan);
      $("#nasabah_jk").val(obj.nasabah_jk);
      $("#nasabah_alamat").val(obj.nasabah_alamat);
      $("#nasabah_no_telp").val(obj.nasabah_no_telp);
    });
}
</script>