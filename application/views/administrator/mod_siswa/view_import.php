            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Siswa </h3>
                  <?php 
                      if (trim($this->input->get('kelas')) != ''){
                        echo "<a class='pull-right btn btn-danger btn-sm' style='margin-left:5px' href='index.php?view=siswa&act=deletesiswa&kelas=$_GET[kelas]&angkatan=$_GET[angkatan]' onclick=\"return confirm('Apa anda yakin untuk hapus Semua data ini?')\">Delete All</a>
                              <a class='pull-right btn btn-success btn-sm' target='_BLANK' href='print/print-siswa.php?kelas=$_GET[kelas]&angkatan=$_GET[angkatan]'>Print Siswa</a>
                              <a style='margin-right:5px' class='pull-right btn btn-primary btn-sm' href='".base_url()."".$this->uri->segment(1)."/tambah_siswa'>Tambahkan Data</a>";
                      }

                  echo "
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_siswa/import_siswa' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/download/import/format_data_siswa.xls'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a> 
                    <input type='hidden' name='angkatan' value='$_GET[angkatan]'>
                    <input type='hidden' name='kelas' value='$_GET[kelas]'>
                    <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>

                </div>
                <div class='box-body'>
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/siswa' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Angkatan</th> <td><select name='angkatan' style='padding:4px; width:300px'>
                        <option value='' selected>- Pilih -</option>";
                            foreach ($angkatan->result_array() as $k) {
                              if ($this->input->get('angkatan')==$k['angkatan']){
                                echo "<option value='$k[angkatan]' selected>Angkatan $k[angkatan]</option>";
                              }else{
                                echo "<option value='$k[angkatan]'>Angkatan $k[angkatan]</option>";
                              }
                            }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Kelas</th>                   <td><select name='kelas' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($kelas as $k) {
                              if ($this->input->get('kelas')==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }

                    echo "</select>
                          <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                  </tbody>
              </table>
              </form>";

        ini_set('memory_limit', '-1');
        $inputFileName = './asset/'.$directory.'/'.$filename;
        try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        } catch(Exception $e) {
        die('Error loading file :' . $e->getMessage());
        }

        $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $numRows = count($worksheet);
        echo "<a href='".base_url().$this->uri->segment(1)."/siswa?angkatan=".$this->input->post('angkatan')."&kelas=".$this->input->post('kelas')."'>Selesai / Kembali</a><hr>";
        for ($i=2; $i < ($numRows+1) ; $i++) { 
          $data1 = $worksheet[$i]['A'];
          $data2 = md5(trim($worksheet[$i]['B']));
          $data3 = $worksheet[$i]['C'];
          $data4 = $worksheet[$i]['D'];
          $data5 = $worksheet[$i]['E'];
          $data6 = $worksheet[$i]['F'];
          $data7 = $worksheet[$i]['G'];
          $data8 = $worksheet[$i]['H'];
          $data9 = $worksheet[$i]['I'];
          $data10 = $worksheet[$i]['J'];
          $data11 = $worksheet[$i]['K'];
          $data12 = $worksheet[$i]['L'];
          $data13 = $worksheet[$i]['M'];
          $data14 = $worksheet[$i]['N'];
          $data15 = $worksheet[$i]['O'];
          $data16 = $worksheet[$i]['P'];
          $data17 = $worksheet[$i]['Q'];
          $data18 = $worksheet[$i]['R'];
          $data19 = $worksheet[$i]['S'];
          $data20 = $worksheet[$i]['T'];
          $data21 = $worksheet[$i]['U'];
          $data22 = $worksheet[$i]['V'];
          $data23 = $worksheet[$i]['W'];
          $data24 = $worksheet[$i]['X'];
          $data25 = $worksheet[$i]['Y'];
          $data26 = $worksheet[$i]['Z'];
          $data27 = $worksheet[$i]['AA'];
          $data28 = $worksheet[$i]['AB'];
          $data29 = $worksheet[$i]['AC'];
          $data30 = $worksheet[$i]['AD'];
          $data31 = $worksheet[$i]['AE'];
          $data32 = $worksheet[$i]['AF'];
          $data33 = $worksheet[$i]['AG'];
          $data34 = $worksheet[$i]['AH'];
          $data35 = $worksheet[$i]['AI'];
          $data36 = $worksheet[$i]['AJ'];
          $data37 = $worksheet[$i]['AK'];
          $data38 = $worksheet[$i]['AL'];
          $data39 = $worksheet[$i]['AM'];
          $data40 = $worksheet[$i]['AN'];
          $data41 = $worksheet[$i]['AO'];
          $data42 = $worksheet[$i]['AP'];
          $data43 = $worksheet[$i]['AQ'];
          $data44 = $worksheet[$i]['AR'];
          $data45 = $worksheet[$i]['AS'];
          $data46 = $worksheet[$i]['AT'];
          $data47 = $worksheet[$i]['AU'];
          $data48 = $worksheet[$i]['AV'];
          $data49 = $worksheet[$i]['AW'];
          $data50 = str_replace(" ",".",$worksheet[$i]['AX']);
          $data51 = $worksheet[$i]['AY'];
          $data52 = $worksheet[$i]['AZ'];
          if (trim($data5)==''){ $data5x = rand(10000,99999999); }else{ $data5x = $data5; }
          if (trim($data5)==''){ $data5x = rand(10000,99999999); }else{ $data5x = $data5; }
          if (trim($data22)==''){ $data22x = 'siswa@schoolmedia.id'; }else{ $data22x = $data22; }
          $cek = $this->db->query("SELECT * FROM rb_siswa where (nipd='$data1' OR nisn='$data5x') AND id_identitas_sekolah='".$this->session->sekolah."'");
          $kelas = $this->db->query("SELECT id_kelas FROM rb_kelas where kode_kelas='$data50' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          $jurusan = $this->db->query("SELECT id_jurusan FROM rb_jurusan where kode_jurusan='$data51' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          if ($cek->num_rows()<=0 AND trim($data3)!=''){
            $ins = array(
                    "id_siswa"              => '',
                    "id_identitas_sekolah"  => $this->session->sekolah,
                    "nipd"                  => $data1,
                    "password"              => $data2,
                    "nama"                  => $data3,
                    "id_jenis_kelamin"      => $data4,
                    "nisn"                  => $data5x,
                    "tempat_lahir"          => $data6,
                    "tanggal_lahir"         => $data7,
                    "nik"                   => $data8,
                    "id_agama"              => $data9,
                    "kebutuhan_khusus"      => $data10,
                    "alamat"                => $data11,
                    "rt"                    => $data12,
                    "rw"                    => $data13,
                    "dusun"                 => $data14,
                    "kelurahan"             => $data15,
                    "kecamatan"             => $data16,
                    "kode_pos"              => $data17,
                    "jenis_tinggal"         => $data18,
                    "alat_transportasi"     => $data19,
                    "telepon"               => $data20,
                    "hp"                    => $data21,
                    "email"                 => $data22x,
                    "skhun"                 => $data23,
                    "penerima_kps"          => $data24,
                    "no_kps"                => $data25,
                    "foto"                  => $data26,
                    "nama_ayah"             => $data27,
                    "tahun_lahir_ayah"      => $data28,
                    "pendidikan_ayah"       => $data29,
                    "pekerjaan_ayah"        => $data30,
                    "penghasilan_ayah"      => $data31,
                    "kebutuhan_khusus_ayah" => $data32,
                    "no_telpon_ayah"        => $data33,
                    "nama_ibu"              => $data34,
                    "tahun_lahir_ibu"       => $data35,
                    "pendidikan_ibu"        => $data36,
                    "pekerjaan_ibu"         => $data37,
                    "penghasilan_ibu"       => $data38,
                    "kebutuhan_khusus_ibu"  => $data39,
                    "no_telpon_ibu"         => $data40,
                    "nama_wali"             => $data41,
                    "tahun_lahir_wali"      => $data42,
                    "pendidikan_wali"       => $data43,
                    "pekerjaan_wali"        => $data44,
                    "penghasilan_wali"      => $data45,
                    "angkatan"              => $data46,
                    "status_awal"           => $data47,
                    "status_siswa"          => $data48,
                    "tingkat"               => $data49,
                    "id_kelas"              => $kelas['id_kelas'],
                    "id_jurusan"            => $jurusan['id_jurusan'],
                    "id_sesi"               => $data52,
                    "email_sekolah"         => '',
                    "no_rek"                => '');
            $this->db->insert('rb_siswa', $ins);
            echo "Sukses - <b><span style='color:green'>$data1 / $data5x</span></b>, a/n <b> $data3</b> Sukses di import,.. <br>";
          }else{
            foreach ($cek->result_array() as $row) {
                echo "<b>Gagal - <span style='color:red'>$row[nipd] / $row[nisn]</span></b>, a/n <b> $row[nama]</b> sudah ada di database,.. <br>";
            }
          }
        }

    echo "</div>
  </div>
</div>";"