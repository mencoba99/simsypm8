<?php 
    $absensi = tgl_indo(tgl_simpan($_GET['tanggal']));
    $tgl = tgl_simpan($_GET['tanggal']);
    $tgl_filter = $_GET['tanggal'];

$cek = $this->db->query("SELECT a.*,b.* FROM rb_journal_list a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar 
                          JOIN rb_jadwal_pelajaran c ON a.kodejdwl=c.kodejdwl where c.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."'")->row_array(); 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Jurnal Mata Pelajaran</h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url()."".$this->uri->segment(1)."/detail_absensi_siswa_jurnal/".$this->uri->segment(3)."' method='GET' enctype='multipart/form-data'>
                    <input type='text' name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;' value='$tgl_filter' class='datepicker'>
                    <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat</button>
                    <a style='margin-top:-4px' class='btn btn-warning btn-sm' href='".base_url()."".$this->uri->segment(1)."/absensi_siswa?tanggal=".$this->input->get('tanggal')."'>Kembali</a>
                  </form>
                </div>
              <div class='box-body'>
              <div class='col-md-12'>
              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='140px' scope='row'>Kelas</th>   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>       <td>$s[namamatapelajaran]</td></tr>
                   
                    <tr><th scope='row'>Hari</th>  <td>".namahari($tgl)."</td></tr>
                    <tr><th scope='row'>Tanggal</th>  <td>".tgl_view($tgl)."</td></tr>
                    <tr><th scope='row'>Pertemuan Ke</th>  <td>$cek[jam_ke]</td></tr>
                    <tr><th scope='row'>Komp. Dasar</th>   <td>$cek[kompetensi_dasar]</td></tr>
                    <tr><th scope='row'>Materi</th>  <td>$cek[materi]</td></tr>
                    <tr><th scope='row'>Keterangan</th>  <td>$cek[keterangan]</td></tr>
                    </td></tr>

                  </tbody>
              </table>
              </div>
            </div>";
            
