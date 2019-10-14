            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Detail Data Guru </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php 
                      echo "<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <div class='col-md-7'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <input type='hidden' name='id' value='$s[nip]'>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='25'>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/foto_pegawai/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_pegawai/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_pegawai/$s[foto]'>";
                                }
                              if($_SESSION['level']!='kepala'){
                                echo "<a href='".base_url().$this->uri->segment(1)."/edit_guru/$s[id_guru]' class='btn btn-success btn-block'>Edit Profile</a>";
                              }
                                echo "</th>
                            </tr>
                            <tr><th width='120px' scope='row'>Nip</th>      <td>$s[nip]</td></tr>
                            <tr><th scope='row'>Username/Email</th>           <td>$s[email]</td></tr>
                            <tr><th scope='row'>Password</th>               <td>**************</td></tr>
                            <tr><th scope='row'>Nama Lengkap</th>           <td>$s[nama_guru]</td></tr>
                            <tr><th scope='row'>Tempat Lahir</th>           <td>$s[tempat_lahir]</td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th>          <td>$s[tanggal_lahir]</td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th>          <td>$s[jenis_kelamin]</td></tr>
                            <tr><th scope='row'>Agama</th>                  <td>$s[nama_agama]</td></tr>
                            <tr><th scope='row'>No Hp</th>                  <td>$s[hp]</td></tr>
                            <tr><th scope='row'>No Telpon</th>              <td>$s[telepon]</td></tr>
                            <tr><th scope='row'>Alamat</th>                 <td>$s[alamat_jalan]</td></tr>
                            <tr><th scope='row'>RT/RW</th>                  <td>$s[rt]/$s[rw]</td></tr>
                            <tr><th scope='row'>Dusun</th>                  <td>$s[nama_dusun]</td></tr>
                            <tr><th scope='row'>Kelurahan</th>              <td>$s[desa_kelurahan]</td></tr>
                            <tr><th scope='row'>Kecamatan</th>              <td>$s[kecamatan]</td></tr>
                            <tr><th scope='row'>Kode Pos</th>               <td>$s[kode_pos]</td></tr>
                            <tr><th scope='row'>NUPTK</th>                  <td>$s[nuptk]</td></tr>
                            <tr><th scope='row'>Bidang Studi</th>           <td>$s[pengawas_bidang_studi]</td></tr>
                            <tr><th scope='row'>Jenis PTK</th>              <td>$s[jenis_ptk]</td></tr>
                            <tr><th scope='row'>Tugas Tambahan</th>         <td>$s[tugas_tambahan]</td></tr>
                            <tr><th scope='row'>Status Pegawai</th>         <td>$s[status_kepegawaian]</td></tr>
                            <tr><th scope='row'>Status Keaktifan</th>       <td>$s[nama_status_keaktifan]</td></tr>
                            <tr><th scope='row'>Status Nikah</th>           <td>$s[status_pernikahan]</td></tr>
                          </tbody>
                          </table>
                        </div>

                        <div class='col-md-5'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th width='150px' scope='row'>NIK</th>      <td>$s[nik]</td></tr>
                            <tr><th scope='row'>SK CPNS</th>                <td>$s[sk_cpns]</td></tr>
                            <tr><th scope='row'>Tanggal CPNS</th>           <td>$s[tanggal_cpns]</td></tr>
                            <tr><th scope='row'>SK Pengangkat</th>          <td>$s[sk_pengangkatan]</td></tr>
                            <tr><th scope='row'>TMT Pengangkat</th>         <td>$s[tmt_pengangkatan]</td></tr>
                            <tr><th scope='row'>Lemb. Pengangkat</th>       <td>$s[lembaga_pengangkatan]</td></tr>
                            <tr><th scope='row'>Golongan</th>               <td>$s[nama_golongan]</td></tr>
                            <tr><th scope='row'>Sumber Gaji</th>            <td>$s[sumber_gaji]</td></tr>

                            <tr><th scope='row'>Ahli Laboratorium</th>  <td>$s[keahlian_laboratorium]</td></tr>
                            <tr><th scope='row'>Nama Ibu Kandung</th>            <td>$s[nama_ibu_kandung]</td></tr>
                            <tr><th scope='row'>Nama Suami/Istri</th>            <td>$s[nama_suami_istri]</td></tr>
                            <tr><th scope='row'>Nip Suami/Istri</th>            <td>$s[nip_suami_istri]</td></tr>
                            <tr><th scope='row'>Pekerjaan Suami/Istri</th>            <td>$s[pekerjaan_suami_istri]</td></tr>
                            <tr><th scope='row'>TMT PNS</th>            <td>$s[tmt_pns]</td></tr>
                            <tr><th scope='row'>Lisensi Kepsek</th>            <td>$s[lisensi_kepsek]</td></tr>
                            <tr><th scope='row'>Jml Sekolah Binaan</th>            <td>$s[jumlah_sekolah_binaan]</td></tr>
                            <tr><th scope='row'>Diklat Kepengawasan</th>            <td>$s[diklat_kepengawasan]</td></tr>
                            <tr><th scope='row'>Mampu Handle KK</th>            <td>$s[mampu_handle_kk]</td></tr>
                            <tr><th scope='row'>Keahlian Breile</th>            <td>$s[keahlian_breile]</td></tr>
                            <tr><th scope='row'>Keahlian B.Isyarat</th>            <td>$s[keahlian_bahasa_isyarat]</td></tr>
                            <tr><th scope='row'>Kewarganegaraan</th>            <td>$s[kewarganegaraan]</td></tr>
                            <tr><th scope='row'>NIY NIGK</th>            <td>$s[niy_nigk]</td></tr>
                            <tr><th scope='row'>NPWP</th>                   <td>$s[npwp]</td></tr>

                          </tbody>
                          </table>
                        </div> 
                      </div>
                    </form>";
                    ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>