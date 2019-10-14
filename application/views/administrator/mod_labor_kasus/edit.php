<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Edit Data</h3>
    </div>
  <div class='box-body'>

  <ul class='nav nav-tabs' role='tablist'>
      <li role='presentation' class='active'><a href='#tab1' aria-controls='tab1' role='tab' data-toggle='tab'>Data Kasus</a></li>
      <li role='presentation'><a href='#tab2' aria-controls='tab2' role='tab' data-toggle='tab'>Data Kasus Detail </a></li>
  </ul>

  <div class='tab-content'>
      <div role='tabpanel' class='tab-pane active' id='tab1'><br>";
      $attributes = array('class'=>'form-horizontal','role'=>'form');
      echo form_open_multipart($this->uri->segment(1).'/edit_labor_kasus',$attributes); 
        echo "<div class='col-md-12'>
          <table class='table table-condensed table-bordered'>
          <tbody>
            <input type='hidden' name='id' value='$s[id_labor_kasus]'>
            <tr><th width='120px' scope='row'>Nama Siswa</th> <td><select class='combobox form-control' name='a'>
                                                                    <option value=''>- Cari Siswa -</option>";
                                                                    $siswa = $this->db->query("SELECT * FROM rb_siswa where status_siswa='Aktif'");
                                                                    foreach ($siswa->result_array() as $row) {
                                                                      if ($s['id_siswa']==$row['id_siswa']){
                                                                        echo "<option value='$row[id_siswa]' selected>$row[nipd] - $row[nama]</option>";
                                                                      }else{
                                                                        echo "<option value='$row[id_siswa]'>$row[nipd] - $row[nama]</option>";
                                                                      }
                                                                    }
                                                                  echo "</select> </td></tr>
            <tr><th scope='row'>Nama Pratikum</th>          <td><input type='text' class='form-control' value='$s[nama_pratikum]' name='b'></td></tr>
            <tr><th scope='row'>Judul Pratikum</th>         <td><input type='text' class='form-control' value='$s[judul_pratikum]' name='c'></td></tr>
            <tr><th scope='row'>Tempat Praktek</th>         <td><input type='text' class='form-control' value='$s[tempat_praktek]' name='d'></td></tr>
            <tr><th scope='row'>Waktu Praktek</th>          <td><input type='text' class='form-control' value='$s[waktu_praktek]' name='e'></td></tr>
            <tr><th scope='row'>Nama Kelompok</th>          <td><input type='text' class='form-control' value='$s[kelompok]' name='f'></td></tr>
            <tr><th scope='row'>Ang. Kelompok</th>       <td><textarea class='form-control' name='g' style='height:150px'>$s[anggota_kelompok]</textarea></td></tr>
          </tbody>
          </table>
        </div>
      <div class='box-footer'>
            <button type='submit' name='submit' class='btn btn-info'>Update</button>
            <a href='".base_url()."".$this->uri->segment(1)."/labor_kasus'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
      </div>";
      echo form_close();

  echo "</div>
  <div role='tabpanel' class='tab-pane' id='tab2'><br>
    <a class='pull-right btn btn-primary btn-sm tambah-labor' data-id='".$this->uri->segment(3)."' href='#'>Tambahkan Data</a>
   <table id='example2' class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th style='width:20px'>No</th>
          <th>Nama Alat</th>
          <th>Kapasitas</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th style='width:80px'>Action</th>
        </tr>
      </thead>
      <tbody>";

      $no = 1;
      $detail = $this->db->query("SELECT * FROM rb_labor_kasus_detail where id_labor_kasus='".$this->uri->segment(3)."'");
      foreach ($detail->result_array() as $r){
      echo "<tr><td>$no</td>
                <td>$r[nama_alat]</td>
                <td>$r[kapasitas]</td>
                <td>$r[jumlah]</td>
                <td>$r[keterangan]</td>
                <td><center>
                  <a class='btn btn-success btn-xs edit-labor' data-id='$r[id_labor_kasus_detail]' title='Edit Data' href='#'><span class='glyphicon glyphicon-edit'></span></a>
                  <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_labor_kasus_detail/$r[id_labor_kasus_detail]/$s[id_labor_kasus]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                </center></td>
                </tr>";
        $no++;
        }

      echo "</tbody>
    </table>
  </div>
</div>


  </div>
  </div>
  </div>";
  
