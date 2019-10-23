<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_guru',$attributes); 
                echo "<div class='col-md-7'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th style='background-color:#E7EAEC' width='160px' rowspan='28'>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/foto_pegawai/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_pegawai/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_pegawai/$s[foto]'>";
                                }
                                echo "</th>
                            </tr>
                    <input type='hidden' name='id' value='$s[id_guru]'>
                    <tr><th width='120px' scope='row'>Username/Nip</th>      <td><input type='text' class='form-control' name='nip' value='$s[nip]'></td></tr>
                    <tr><th scope='row'>Email</th>         <td><input type='email' class='form-control' name='email' value='$s[email]' required></td></tr>
                    <tr><th scope='row'>Password</th>               <td><input type='password' class='form-control' name='password'></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>           <td><input type='text' class='form-control' name='nama_guru' value='$s[nama_guru]'></td></tr>
                    <tr><th scope='row'>Tempat Lahir</th>           <td><input type='text' class='form-control' name='tempat_lahir' value='$s[tempat_lahir]'></td></tr>
                    <tr><th scope='row'>Tanggal Lahir</th>          <td><input type='text' class='form-control datepicker' name='tanggal_lahir' value='".tgl_view($s['tanggal_lahir'])."'></td></tr>
                    <tr><th scope='row'>Jenis Kelamin</th>          <td><select class='form-control' name='id_jenis_kelamin'> 
                                                                          <option value='0' selected>- Pilih Jenis Kelamin -</option>"; 
                                                                            foreach ($jk->result_array() as $a){
                                                                              if ($s['id_jenis_kelamin']==$a['id_jenis_kelamin']){
                                                                                echo "<option value='$a[id_jenis_kelamin]' selected>$a[jenis_kelamin]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                                                                              }
                                                                            }
                                                                            echo "</select></td></tr>
                    <tr><th scope='row'>Agama</th>                  <td><select class='form-control' name='id_agama'> 
                                                                          <option value='0' selected>- Pilih Agama -</option>"; 
                                                                            foreach ($agama->result_array() as $a){
                                                                              if ($s['id_agama']==$a['id_agama']){
                                                                                echo "<option value='$a[id_agama]' selected>$a[nama_agama]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>No Hp</th>                  <td><input type='text' class='form-control' name='hp' value='$s[hp]'></td></tr>
                    <tr><th scope='row'>No Telpon</th>              <td><input type='text' class='form-control' name='telepon' value='$s[telepon]'></td></tr>
                    <tr><th scope='row'>Alamat</th>                 <td><input type='text' class='form-control' name='alamat_jalan' value='$s[alamat_jalan]'></td></tr>
                    <tr><th scope='row'>RT/RW</th>                  <td><input type='text' class='form-control' value='00/00' name='rt_rw' value='$s[rt]/$s[rw]'></td></tr>
                    <tr><th scope='row'>Dusun</th>                  <td><input type='text' class='form-control' name='nama_dusun' value='$s[nama_dusun]'></td></tr>
                    <tr><th scope='row'>Kelurahan</th>              <td><input type='text' class='form-control' name='desa_kelurahan' value='$s[desa_kelurahan]'></td></tr>
                    <tr><th scope='row'>Kecamatan</th>              <td><input type='text' class='form-control' name='kecamatan' value='$s[kecamatan]'></td></tr>
                    <tr><th scope='row'>Kode Pos</th>               <td><input type='text' class='form-control' name='kode_pos' value='$s[kode_pos]'></td></tr>
                    <tr><th scope='row'>NUPTK</th>                  <td><input type='text' class='form-control' name='nuptk' value='$s[nuptk]'></td></tr>
                    <tr><th scope='row'>Bidang Studi</th>           <td><input type='text' class='form-control' name='pengawas_bidang_studi' value='$s[pengawas_bidang_studi]'></td></tr>
                    <tr><th scope='row'>Jenis PTK</th>              <td><select class='form-control' name='id_jenis_ptk'> 
                                                                          <option value='0' selected>- Pilih Jenis PTK -</option>"; 
                                                                            foreach ($ptk->result_array() as $a){
                                                                              if ($s['id_jenis_ptk']==$a['id_jenis_ptk']){
                                                                                echo "<option value='$a[id_jenis_ptk]' selected>$a[jenis_ptk]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_jenis_ptk]'>$a[jenis_ptk]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Tugas Tambahan</th>         <td><input type='text' class='form-control' name='tugas_tambahan' value='$s[tugas_tambahan]'></td></tr>
                    <tr><th scope='row'>Status Pegawai</th>         <td><select class='form-control' name='id_status_kepegawaian'> 
                                                                          <option value='0' selected>- Pilih Status Kepegawaian -</option>"; 
                                                                            foreach ($status_kepegawaian->result_array() as $a){
                                                                              if ($s['id_status_kepegawaian']==$a['id_status_kepegawaian']){
                                                                                echo "<option value='$a[id_status_kepegawaian]' selected>$a[status_kepegawaian]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_status_kepegawaian]'>$a[status_kepegawaian]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Golongan</th>               <td><select class='form-control' name='id_golongan'> 
                                                                          <option value='0' selected>- Pilih Golongan -</option>"; 
                                                                            foreach ($golongan->result_array() as $a){
                                                                              if ($s['id_golongan']==$a['id_golongan']){
                                                                                echo "<option value='$a[id_golongan]' selected>$a[nama_golongan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_golongan]'>$a[nama_golongan]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Sumber Gaji</th>            <td><input type='text' class='form-control' value='$s[sumber_gaji]' name='sumber_gaji'></td></tr>
                    <tr><th scope='row'>Status Keaktifan</th>       <td><select class='form-control' name='id_status_keaktifan'> 
                                                                          <option value='0' selected>- Pilih Status Keaktifan -</option>"; 
                                                                            foreach ($status_keaktifan->result_array() as $a){
                                                                              if ($s['id_status_keaktifan']==$a['id_status_keaktifan']){
                                                                                echo "<option value='$a[id_status_keaktifan]' selected>$a[nama_status_keaktifan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_status_keaktifan]'>$a[nama_status_keaktifan]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Status Nikah</th>           <td><select class='form-control' name='id_status_pernikahan'> 
                                                                          <option value='0' selected>- Pilih Status Pernikahan -</option>"; 
                                                                            foreach ($status_pernikahan->result_array() as $a){
                                                                              if ($s['id_status_pernikahan']==$a['id_status_pernikahan']){
                                                                                echo "<option value='$a[id_status_pernikahan]' selected>$a[status_pernikahan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_status_pernikahan]'>$a[status_pernikahan]</option>";
                                                                              }
                                                                            }
                                                                  echo "</select></td></tr>
                    <tr><th scope='row'>Ganti Foto</th>             <td><div style='position:relative;''>
                                                                          <a class='btn btn-primary' href='javascript:;'>
                                                                            <span class='glyphicon glyphicon-search'></span> Browse..."; ?>
                                                                            <input type='file' class='files' name='foto' onchange='$("#upload-file-info").html($(this).val());'>
                                                                          <?php echo "</a> <span style='width:155px' class='label label-info' id='upload-file-info'></span>
                                                                        </div>
                    </td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-5'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='150px' scope='row'>NIK</th>      <td><input type='text' class='form-control' name='nik' value='$s[nik]'></td></tr>
                    <tr><th scope='row'>NO SK CPNS</th>                <td><input type='text' class='form-control' name='sk_cpns' value='$s[sk_cpns]'></td></tr>
                    <tr><th scope='row'>Tanggal CPNS</th>           <td><input type='text' class='form-control datepicker' name='tanggal_cpns' value='".tgl_view($s['tanggal_cpns'])."'></td></tr>                   
                   
                    <tr><th scope='row'>NO SK GTT</th>                <td><input type='text' class='form-control' name='sk_gtt' value='$s[sk_gtt]'></td></tr>
                    <tr><th scope='row'>Tanggal GTT</th>           <td><input type='text' class='form-control datepicker' name='tgl_gtt' value='".tgl_view($s['tgl_gtt'])."'></td></tr>
                    <tr><th scope='row'>NO SK GTY</th>                <td><input type='text' class='form-control' name='sk_gty' value='$s[sk_gty]'></td></tr>
                    <tr><th scope='row'>Tanggal GTY</th>           <td><input type='text' class='form-control datepicker' name='tgl_gty' value='".tgl_view($s['tgl_gty'])."'></td></tr>                    

                    <tr><th scope='row'>SK Pengangkat</th>          <td><input type='text' class='form-control' name='sk_pengangkatan' value='$s[sk_pengangkatan]'></td></tr>
                    <tr><th scope='row'>TMT Pengangkat</th>         <td><input type='text' class='form-control datepicker' name='tmt_pengangkatan' value='".tgl_view($s['tmt_pengangkatan'])."'></td></tr>
                    <tr><th scope='row'>Lemb. Pengangkat</th>       <td><input type='text' class='form-control' name='lembaga_pengangkatan' value='$s[lembaga_pengangkatan]'></td></tr>
                    <tr><th scope='row'>Ahli Laboratorium</th>      <td><input type='text' class='form-control' name='keahlian_laboratorium' value='$s[keahlian_laboratorium]'></td></tr>
                    <tr><th scope='row'>Nama Ibu Kandung</th>       <td><input type='text' class='form-control' name='nama_ibu_kandung' value='$s[nama_ibu_kandung]'></td></tr>
                    <tr><th scope='row'>Nama Suami/Istri</th>       <td><input type='text' class='form-control' name='nama_suami_istri' value='$s[nama_suami_istri]'></td></tr>
                    <tr><th scope='row'>Nip Suami/Istri</th>        <td><input type='text' class='form-control' name='nip_suami_istri' value='$s[nip_suami_istri]'></td></tr>
                    <tr><th scope='row'>Pekerjaan Suami/Istri</th>  <td><input type='text' class='form-control' name='pekerjaan_suami_istri' value='$s[pekerjaan_suami_istri]'></td></tr>
                    <tr><th scope='row'>TMT PNS</th>                <td><input type='text' class='form-control' name='tmt_pns' value='$s[tmt_pns]'></td></tr>
                    <tr><th scope='row'>Lisensi Kepsek</th>         <td><input type='text' class='form-control' name='lisensi_kepsek' value='$s[lisensi_kepsek]'></td></tr>
                    <tr><th scope='row'>Jml Sekolah Binaan</th>     <td><input type='text' class='form-control' name='jumlah_sekolah_binaan' value='$s[jumlah_sekolah_binaan]'></td></tr>
                    <tr><th scope='row'>Diklat Kepengawasan</th>    <td><input type='text' class='form-control' name='diklat_kepengawasan' value='$s[diklat_kepengawasan]'></td></tr>
                    <tr><th scope='row'>Mampu Handle KK</th>        <td><input type='text' class='form-control' name='mampu_handle_kk' value='$s[mampu_handle_kk]'></td></tr>
                    <tr><th scope='row'>Keahlian Breile</th>        <td><input type='text' class='form-control' name='keahlian_breile' value='$s[keahlian_breile]'></td></tr>
                    <tr><th scope='row'>Keahlian B.Isyarat</th>     <td><input type='text' class='form-control' name='keahlian_bahasa_isyarat' value='$s[keahlian_bahasa_isyarat]'></td></tr>
                    <tr><th scope='row'>Kewarganegaraan</th>        <td><input type='text' class='form-control' name='kewarganegaraan' value='$s[kewarganegaraan]'></td></tr>
                    <tr><th scope='row'>NIY NIGK</th>               <td><input type='text' class='form-control' name='niy_nigk' value='$s[niy_nigk]'></td></tr>
                    <tr><th scope='row'>NPWP</th>                   <td><input type='text' class='form-control' name='npwp' value='$s[npwp]'></td></tr>";
                    if ($this->session->level=='guru'){
                      echo "<input type='hidden' name='guru_bk' value='$s[guru_bk]'>
                            <input type='hidden' name='guru_piket' value='$s[guru_piket]'>
                            <input type='hidden' name='guru_bkk' value='$s[guru_bkk]'>
                            <input type='hidden' name='guru_wali_kelas' value='$s[guru_wali_kelas]'>
                            <input type='hidden' name='guru_matpel' value='$s[guru_matpel]'>
                            <input type='hidden' name='laboratorium' value='$s[laboratorium]'>
                            <input type='hidden' name='ppdb' value='$s[ppdb]'>
                            <input type='hidden' name='pustaka' value='$s[pustaka]'>
                            <input type='hidden' name='koperasi' value='$s[koperasi]'>
                            <input type='hidden' name='asset' value='$s[asset]'>
                            <input type='hidden' name='finance' value='$s[finance]'>";
                    }else{
                    echo "<tr><th scope='row'>Guru BK</th>          <td>";
                                                                    if ($s['guru_bk']=='Ya'){
                                                                        echo "<input type='radio' name='guru_bk' value='Ya' checked> Ya
                                                                               <input type='radio' name='guru_bk' value='Tidak'> Tidak";
                                                                    }else{
                                                                        echo "<input type='radio' name='guru_bk' value='Ya'> Ya
                                                                               <input type='radio' name='guru_bk' value='Tidak' checked> Tidak";
                                                                    }
                    echo "</td></tr>
                    <tr><th scope='row'>Guru Piket</th>               <td>";
                                                                      if ($s['guru_piket']=='Ya'){
                                                                          echo "<input type='radio' name='guru_piket' value='Ya' checked> Ya
                                                                                 <input type='radio' name='guru_piket' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='guru_piket' value='Ya'> Ya
                                                                                 <input type='radio' name='guru_piket' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Guru BKK</th>                <td>";
                                                                      if ($s['guru_bkk']=='Ya'){
                                                                          echo "<input type='radio' name='guru_bkk' value='Ya' checked> Ya
                                                                                 <input type='radio' name='guru_bkk' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='guru_bkk' value='Ya'> Ya
                                                                                 <input type='radio' name='guru_bkk' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Guru Wali Kelas</th>          <td>";
                                                                      if ($s['guru_wali_kelas']=='Ya'){
                                                                          echo "<input type='radio' name='guru_wali_kelas' value='Ya' checked> Ya
                                                                                 <input type='radio' name='guru_wali_kelas' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='guru_wali_kelas' value='Ya'> Ya
                                                                                 <input type='radio' name='guru_wali_kelas' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Guru Mata Pelajaran</th>      <td>";
                                                                      if ($s['guru_matpel']=='Ya'){
                                                                          echo "<input type='radio' name='guru_matpel' value='Ya' checked> Ya
                                                                                 <input type='radio' name='guru_matpel' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='guru_matpel' value='Ya'> Ya
                                                                                 <input type='radio' name='guru_matpel' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Akses Laboratorium</th>      <td>";
                                                                      if ($s['laboratorium']=='Ya'){
                                                                          echo "<input type='radio' name='laboratorium' value='Ya' checked> Ya
                                                                                 <input type='radio' name='laboratorium' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='laboratorium' value='Ya'> Ya
                                                                                 <input type='radio' name='laboratorium' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Akses PPDB</th>                <td>";
                                                                      if ($s['ppdb']=='Ya'){
                                                                          echo "<input type='radio' name='ppdb' value='Ya' checked> Ya
                                                                                 <input type='radio' name='ppdb' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='ppdb' value='Ya'> Ya
                                                                                 <input type='radio' name='ppdb' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Akses Pustaka</th>                <td>";
                                                                      if ($s['pustaka']=='Ya'){
                                                                          echo "<input type='radio' name='pustaka' value='Ya' checked> Ya
                                                                                 <input type='radio' name='pustaka' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='pustaka' value='Ya'> Ya
                                                                                 <input type='radio' name='pustaka' value='Tidak' checked> Tidak";
                                                                      }
                    // echo "</td></tr>
                    // <tr><th scope='row'>Akses Koperasi</th>                <td>";
                    //                                                   if ($s['koperasi']=='Ya'){
                    //                                                       echo "<input type='radio' name='koperasi' value='Ya' checked> Ya
                    //                                                              <input type='radio' name='koperasi' value='Tidak'> Tidak";
                    //                                                   }else{
                    //                                                       echo "<input type='radio' name='koperasi' value='Ya'> Ya
                    //                                                              <input type='radio' name='koperasi' value='Tidak' checked> Tidak";
                    //                                                   }
                    echo "</td></tr>
                    <tr><th scope='row'>Akses Asset</th>                <td>";
                                                                      if ($s['asset']=='Ya'){
                                                                          echo "<input type='radio' name='asset' value='Ya' checked> Ya
                                                                                 <input type='radio' name='asset' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='asset' value='Ya'> Ya
                                                                                 <input type='radio' name='asset' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>
                    <tr><th scope='row'>Akses Finance</th>                <td>";
                                                                      if ($s['finance']=='Ya'){
                                                                          echo "<input type='radio' name='finance' value='Ya' checked> Ya
                                                                                 <input type='radio' name='finance' value='Tidak'> Tidak";
                                                                      }else{
                                                                          echo "<input type='radio' name='finance' value='Ya'> Ya
                                                                                 <input type='radio' name='finance' value='Tidak' checked> Tidak";
                                                                      }
                    echo "</td></tr>";
                  }
                  echo "</tbody>
                  </table>

                </div>
              </div>
              <div class='box-footer'>

                    <button type='submit' name='update' class='btn btn-info'>Update</button>";                    
                    if($this->session->level=='admin'){                      
                    echo"<a href='".base_url()."".$this->uri->segment(1)."/guru'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>";
                    
                    }
              echo"</div>";
              echo form_close();
            echo "</div>";


            
