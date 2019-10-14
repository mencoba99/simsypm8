<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Data Identitas Sekolah</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/sekolah',$attributes); 
              echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_identitas_sekolah]'>
                    <tr><th width='140px' scope='row'>Nama Sekolah</th>   <td><input type='text' class='form-control' name='a' value='$s[nama_sekolah]'></td></tr>
                    <tr><th scope='row'>NPSN</th>                         <td><input type='text' class='form-control' name='b' value='$s[npsn]'></td></tr>
                    <tr><th scope='row'>NSS</th>                          <td><input type='text' class='form-control' name='c' value='$s[nss]'></td></tr>
                    <tr><th scope='row'>Alamat Sekolah</th>               <td><input type='text' class='form-control' name='d' value='$s[alamat_sekolah]'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>                     <td><input type='text' class='form-control' name='e' value='$s[kode_pos]'></td></tr>
                    <tr><th scope='row'>No Telpon</th>                    <td><input type='text' class='form-control' name='f' value='$s[no_telpon]'></td></tr>
                    <tr><th scope='row'>Kelurahan</th>                    <td><input type='text' class='form-control' name='g' value='$s[kelurahan]'></td></tr>
                    <tr><th scope='row'>Kecamatan</th>                    <td><input type='text' class='form-control' name='h' value='$s[kecamatan]'></td></tr>
                    <tr><th scope='row'>Kabupaten / Kota</th>             <td><input type='text' class='form-control' name='i' value='$s[kabupaten_kota]'></td></tr>
                    <tr><th scope='row'>Provinsi</th>                     <td><input type='text' class='form-control' name='j' value='$s[provinsi]'></td></tr>
                    <tr><th scope='row'>Website</th>                      <td><input type='text' class='form-control' name='k' value='$s[website]'></td></tr>
                    <tr><th scope='row'>Email</th>                        <td><input type='text' class='form-control' name='l' value='$s[email]'></td></tr>
                    <tr><th scope='row'>Tgl Rapor 1</th>                  <td><input type='text' class='form-control' name='tanggal_rapor1' value='$s[tanggal_rapor1]'></td></tr>
                    <tr><th scope='row'>Tgl Rapor 2</th>                  <td><input type='text' class='form-control' name='tanggal_rapor2' value='$s[tanggal_rapor2]'></td></tr>
                    <tr><th scope='row'>Logo 1</th>                       <td><input type='file' name='foto1'>";
                                                                               if ($s['logo1'] != ''){ echo "<i style='color:red'>Logo 1 Saat ini : </i><a target='_BLANK' href='".base_url()."asset/logo/$s[logo1]'>$s[logo1]</a>"; } echo "</td></tr>
                    <tr><th scope='row'>Logo 2</th>                       <td><input type='file' name='foto2'>";
                                                                               if ($s['logo2'] != ''){ echo "<i style='color:red'>Logo 2 Saat ini : </i><a target='_BLANK' href='".base_url()."asset/logo/$s[logo2]'>$s[logo2]</a>"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                <button type='submit' name='submit' class='btn btn-info'>Update</button>
                <a href='".base_url()."".$this->uri->segment(1)."/sekolah'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
