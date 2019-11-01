<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Semua Data Pendaftaran Tahun <?php echo date('Y'); ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php          
    echo "<form class='pull-right' target='_BLANK'  method='GET' action='".base_url().$this->uri->segment(1)."/export_siswa'>
        <table class='table table-condensed'>
        <tr><td> Filter : <select style='padding:4px; width:150px;' name='tahun'>
            <option value=''>- Semua Tahun -</option>";
            for ($i=2018; $i <= date('Y') ; $i++) { 
              echo "<option value='$i'>$i</option>";
            }
          echo "</select>          
          <select style='padding:4px; width:150px;' name='jalur'>
            <option value='00'>- Semua Jalur -</option>";
            $data = array('Seleksi Rapor','Jalur Tes');
            for ($i=0; $i < count($data) ; $i++) { 
              echo "<option value='".$data[$i]."'>".$data[$i]."</option>";
            }
          echo "</select>
          
          <select style='padding:4px; width:180px;'  name='jurusan'>
            <option value='00'>- Semua Jurusan -</option>";
            $data = array('Teknik Pemesinan',
                  'Multimedia',
                  'Teknik Elektronika Industri',
                  'Teknik Kendaraan Ringan Otomotif',
                );
            for ($i=0; $i < count($data) ; $i++) { 
              echo "<option value='$i'>".$data[$i]."</option>";
            }
          echo "</select>
          
          <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'>Import Excel</button></td>
          </tr>
        </table>
        </form>

        <div style='clear:both'></div>

    <table id='example1' class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>No</th>
          <th>Pendaf.</th>
          <th>Nama Siswa</th>
          <th>No Telp / Email</th>
          <th style='width:210px'>Pilihan Jalur dan Jurusan</th>
          <th>Formulir</th>
          <th>Rata-rata\n Rapor</th>
          <th style='width:200px'><center>Action</center></th>
        </tr>
      </thead>
      <tbody>";
      $no = 1;
      foreach ($tampil->result_array() as $r) {
      $pendaftar = $this->db->query("SELECT * FROM rb_psb_pendaftaran where id_psb_akun='$r[id_psb_akun]'");
      $cek = $pendaftar->row_array();

      $rapor = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$cek[id_pendaftaran]'")->result_array();

      $jumlah = 0; 
      
      foreach ($rapor as $rapor_) {
        $mean1 = ($rapor_[semester1] + $rapor_[semester2] + $rapor_[semester3] + $rapor_[semester4] + $rapor_[semester5]) / 5;
        $jumlah += $mean1;
      }
      $mean = $jumlah / 4;

      if ($cek['status_seleksi']=='Terima'){ 
        $color = 'success'; 
        $status = 'Sudah Valid';
      }else{ 
        $color = 'warning'; 
        $status = 'Belum Valid';
      }

      if ($pendaftar->num_rows()>=1){
        $formulir = "<i style='color:green'>Sudah Isi</i>";
        $col = 'info';
        $telpon = $cek['no_telpon'];
      }else{
        $formulir = "<i style='color:red'>Belum Isi</i>";
        $col = 'default';
        $telpon = $r['no_telpon'];
      }

      if ($cek['id_aktivasi']!=''){
        $id_aktivasi = $cek['id_aktivasi'];
        $password = $cek['pass'];
      }else{
        $id_aktivasi = '-';
        $password = '-';
      }
      
      $jal = $this->db->query("SELECT * FROM rb_psb_pendaftaran_jalur where id_pendaftaran='$cek[id_pendaftaran]'")->row_array();
      if ($jal['pilihan1']=='0'){ $pilihan1 = 'Kimia Industri, '; }elseif($jal['pilihan1']=='1'){ $pilihan1 = 'Teknik Otomasi Industri'; }else{ $pilihan1 = '.........?'; }
      if ($jal['pilihan2']=='0'){ $pilihan2 = 'Kimia Industri, '; }elseif($jal['pilihan2']=='1'){ $pilihan2 = 'Teknik Otomasi Industri'; }else{ $pilihan2 = '.........?'; }

      echo "<tr>
                <td>";
                if ($pendaftar->num_rows()>=1){
                  echo "<a target='_BLANK' style='margin:0px 3px' class='btn btn-info btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/print_psb_print?id=$cek[id_pendaftaran]'><span class='glyphicon glyphicon-print'></span></a>";
                }else{
                  echo "<a style='margin:0px 3px' class='btn btn-default btn-xs' title='Lihat Detail' href='#' onclick=\"return confirm('Calon siswa ini belum di isi Formulir!')\"><span class='glyphicon glyphicon-print'></span></a>";
                }
                echo "$no</td>
                <td><span style='color:Red'>$id_aktivasi</span> <br> <b>Pass</b> : $password</td>
                <td>$r[nama_lengkap]</td>
                <td>$telpon<br> $r[email]</td>";              
                if ($pendaftar->num_rows()>=1){
                  echo "<td style='width:210px !important'><b>$jal[jalur] :</b><br><span style='color:blue'>1. $pilihan1</span> <br><span style='color:blue'>2. $pilihan2</span></td>";
                }else{
                  echo "<td><i style='color:red'>Belum Isi Formulir!</i></td>"; 
                }
                $jal['nilai'] = 0;
                if ($jal['jalur']=='Seleksi Rapor'){
                      $nilai = $mean;
                }else{
                      $nilai = 9;
                }
                echo "<td>$formulir</td>
                  <td>$nilai</td>
                  <td style='width:200px'><center>
                    <div class='btn-group'> 
                      <button type='button' class='btn btn-$color btn-xs'>$status</button> 
                      <button type='button' class='btn btn-$color btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <span class='caret'></span> <span class='sr-only'>Toggle Dropdown</span> </button> 
                        <ul class='dropdown-menu'> 
                          <li><a href='".base_url().$this->uri->segment(1)."/pendaftaran?id=$cek[id_pendaftaran]&status=Terima' onclick=\"return confirm('Apa anda yakin untuk datanya Sudah Valid?')\" value='btn'><span class='glyphicon glyphicon-ok'></span> Sudah Valid</a></li> 
                          <li><a href='".base_url().$this->uri->segment(1)."/pendaftaran?id=$cek[id_pendaftaran]&status=Pending' onclick=\"return confirm('Apa anda yakin ubah status jadi Belum Valid?')\"><span class='glyphicon glyphicon-remove'></span> Belum Valid</a></li>
                        </ul>
                    </div>";
                    if ($pendaftar->num_rows()>=1){
                      echo "<a style='margin:0px 3px' class='btn btn-info btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/pendaftaran_detailsiswa?id=$cek[id_pendaftaran]'><span class='glyphicon glyphicon-search'></span></a>";
                    }else{
                      echo "<a style='margin:0px 3px' class='btn btn-default btn-xs' title='Lihat Detail' href='#' onclick=\"return confirm('Calon siswa ini belum di isi Formulir!')\"><span class='glyphicon glyphicon-search'></span></a>";
                    }
                    echo "<a class='btn btn-success btn-xs' title='Edit Siswa' href='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$cek[id_pendaftaran]&psb=$r[id_psb_akun]'><span class='glyphicon glyphicon-edit'></span></a>
                          <a class='btn btn-danger btn-xs' title='Delete Siswa' href='".base_url().$this->uri->segment(1)."/pendaftaran_hapussiswa/$cek[id_pendaftaran]/$r[id_psb_akun]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>";
              echo "</tr>";
        $no++;
        }

        
    ?>
      </tbody>
    </table>
    
    <?php 
      /* $cek_double = $this->db->query("SELECT id_aktivasi, COUNT(*) as total FROM rb_psb_pendaftaran GROUP BY id_aktivasi HAVING ( COUNT(id_aktivasi) > 1 )");
      if ($cek_double->num_rows()>=1){
          foreach ($cek_double->result_array() as $d) {
              echo "<div style='padding:5px; margin:2px; border-radius:0px' class='alert alert-danger'>No Pendaftaran <b>$d[id_aktivasi]</b> Terdapat Duplikat Total : <b>$d[total]</b></div>";
          }
      } */
    ?>
</div>
</div>
</div>