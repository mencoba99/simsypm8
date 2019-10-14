<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_guru',$attributes); 
                echo "<div class='col-md-6'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Username/Nip</th>      <td><input type='text' class='form-control' name='nip'></td></tr>
                    <tr><th scope='row'>Email</th>                  <td><input type='email' class='form-control' name='email' required></td></tr>
                    <tr><th scope='row'>Password</th>               <td><input type='password' class='form-control' name='password'></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>           <td><input type='text' class='form-control' name='nama_guru'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>           <td><input type='text' class='form-control' name='tempat_lahir'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>          <td><input type='text' class='form-control datepicker' name='tanggal_lahir'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>          <td><select class='form-control' name='id_jenis_kelamin'> 
                                                                          <option value='0' selected>- Pilih Jenis Kelamin -</option>"; 
                                                                            foreach ($jk->result_array() as $row){
                                                                                  echo "<option value='$row[id_jenis_kelamin]'>$row[jenis_kelamin]</option>";
                                                                            }
                                                                            echo "</select></td></tr>
                    <tr><th scope='row'>Agama</th>                  <td><select class='form-control' name='id_agama'> 
                                                                          <option value='0' selected>- Pilih Agama -</option>"; 
                                                                            foreach ($agama->result_array() as $row){
                                                                                  echo "<option value='$row[id_agama]'>$row[nama_agama]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>No Hp</th>                  <td><input type='text' class='form-control' name='hp'></td></tr>
                    <tr><th scope='row'>No Telpon</th>              <td><input type='text' class='form-control' name='telepon'></td></tr>
                    <tr><th scope='row'>Alamat</th>                 <td><input type='text' class='form-control' name='alamat_jalan'></td></tr>
                    <tr><th scope='row'>RT/RW</th>                  <td><input type='text' class='form-control' value='00/00' name='rt_rw'></td></tr>
                    <tr><th scope='row'>Dusun</th>                  <td><input type='text' class='form-control' name='nama_dusun'></td></tr>
                    <tr><th scope='row'>Kelurahan</th>              <td><input type='text' class='form-control' name='desa_kelurahan'></td></tr>
                    <tr><th scope='row'>Kecamatan</th>              <td><input type='text' class='form-control' name='kecamatan'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>               <td><input type='text' class='form-control' name='kode_pos'></td></tr>
                    <tr><th scope='row'>NUPTK</th>                  <td><input type='text' class='form-control' name='nuptk'></td></tr>
                    <tr><th scope='row'>Bidang Studi</th>           <td><input type='text' class='form-control' name='pengawas_bidang_studi'></td></tr>
                    <tr><th scope='row'>Jenis PTK</th>              <td><select class='form-control' name='id_jenis_ptk'> 
                                                                          <option value='0' selected>- Pilih Jenis PTK -</option>"; 
                                                                            foreach ($ptk->result_array() as $row){
                                                                                  echo "<option value='$row[id_jenis_ptk]'>$row[jenis_ptk]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Tugas Tambahan</th>         <td><input type='text' class='form-control' name='tugas_tambahan'></td></tr>
                    <tr><th scope='row'>Status Pegawai</th>         <td><select class='form-control' name='id_status_kepegawaian'> 
                                                                          <option value='0' selected>- Pilih Status Kepegawaian -</option>"; 
                                                                            foreach ($status_kepegawaian->result_array() as $row){
                                                                                  echo "<option value='$row[id_status_kepegawaian]'>$row[status_kepegawaian]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Status Keaktifan</th>       <td><select class='form-control' name='id_status_keaktifan'> 
                                                                          <option value='0' selected>- Pilih Status Keaktifan -</option>"; 
                                                                            foreach ($status_keaktifan->result_array() as $row){
                                                                                  echo "<option value='$row[id_status_keaktifan]'>$row[nama_status_keaktifan]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Status Nikah</th>           <td><select class='form-control' name='id_status_pernikahan'> 
                                                                          <option value='0' selected>- Pilih Status Pernikahan -</option>"; 
                                                                            foreach ($status_pernikahan->result_array() as $row){
                                                                                  echo "<option value='$row[id_status_pernikahan]'>$row[status_pernikahan]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Foto</th>             <td><div style='position:relative;''>
                                                                          <a class='btn btn-primary' href='javascript:;'>
                                                                            <span class='glyphicon glyphicon-search'></span> Browse..."; ?>
                                                                            <input type='file' class='files' name='foto' onchange='$("#upload-file-info").html($(this).val());'>
                                                                          <?php echo "</a> <span style='width:155px' class='label label-info' id='upload-file-info'></span>
                                                                        </div>
                    </td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='150px' scope='row'>NIK</th>      <td><input type='text' class='form-control' name='nik'></td></tr>
                    <tr><th scope='row'>SK CPNS</th>                <td><input type='text' class='form-control' name='sk_cpns'></td></tr>
                    <tr><th scope='row'>Tanggal CPNS</th>           <td><input type='text' class='form-control' name='tanggal_cpns'></td></tr>
                    <tr><th scope='row'>SK Pengangkat</th>          <td><input type='text' class='form-control' name='sk_pengangkatan'></td></tr>
                    <tr><th scope='row'>TMT Pengangkat</th>         <td><input type='text' class='form-control' name='tmt_pengangkatan'></td></tr>
                    <tr><th scope='row'>Lemb. Pengangkat</th>       <td><input type='text' class='form-control' name='lembaga_pengangkatan'></td></tr>
                    <tr><th scope='row'>Golongan</th>               <td><select class='form-control' name='id_golongan'> 
                                                                          <option value='0' selected>- Pilih Golongan -</option>"; 
                                                                            foreach ($golongan->result_array() as $row){
                                                                                  echo "<option value='$row[id_golongan]'>$row[nama_golongan]</option>";
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Sumber Gaji</th>            <td><input type='text' class='form-control' value='$s[sumber_gaji]' name='sumber_gaji'></td></tr>

                    <tr><th scope='row'>Ahli Laboratorium</th>      <td><input type='text' class='form-control' name='keahlian_laboratorium'></td></tr>
                    <tr><th scope='row'>Nama Ibu Kandung</th>       <td><input type='text' class='form-control' name='nama_ibu_kandung'></td></tr>
                    <tr><th scope='row'>Nama Suami/Istri</th>       <td><input type='text' class='form-control' name='nama_suami_istri'></td></tr>
                    <tr><th scope='row'>Nip Suami/Istri</th>        <td><input type='text' class='form-control' name='nip_suami_istri'></td></tr>
                    <tr><th scope='row'>Pekerjaan Suami/Istri</th>  <td><input type='text' class='form-control' name='pekerjaan_suami_istri'></td></tr>
                    <tr><th scope='row'>TMT PNS</th>                <td><input type='text' class='form-control' name='tmt_pns'></td></tr>
                    <tr><th scope='row'>Lisensi Kepsek</th>         <td><input type='text' class='form-control' name='lisensi_kepsek'></td></tr>
                    <tr><th scope='row'>Jml Sekolah Binaan</th>     <td><input type='text' class='form-control' name='jumlah_sekolah_binaan'></td></tr>
                    <tr><th scope='row'>Diklat Kepengawasan</th>    <td><input type='text' class='form-control' name='diklat_kepengawasan'></td></tr>
                    <tr><th scope='row'>Mampu Handle KK</th>        <td><input type='text' class='form-control' name='mampu_handle_kk'></td></tr>
                    <tr><th scope='row'>Keahlian Breile</th>        <td><input type='text' class='form-control' name='keahlian_breile'></td></tr>
                    <tr><th scope='row'>Keahlian B.Isyarat</th>     <td><input type='text' class='form-control' name='keahlian_bahasa_isyarat'></td></tr>
                    <tr><th scope='row'>Kewarganegaraan</th>        <td><input type='text' class='form-control' name='kewarganegaraan'></td></tr>
                    <tr><th scope='row'>NIY NIGK</th>               <td><input type='text' class='form-control' name='niy_nigk'></td></tr>
                    <tr><th scope='row'>NPWP</th>                   <td><input type='text' class='form-control' name='npwp'></td></tr>

                  </tbody>
                  </table>

                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/guru'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
