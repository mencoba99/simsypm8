<?php 
    echo "<div class='col-xs-12'>  
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>Cetak Raport UTS </h3>
                  <a class='btn btn-success btn-sm pull-right' href='".base_url().$this->uri->segment(1)."/cetak_uts/?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&ranking=true'><i class='fa fa-refresh'></i> Cek/Refresh Ranking</a>
              </div>
                <div class='box-body'>";
                if ($_GET['ranking']=='true'){
                    echo "<div class='alert alert-success'><b>Success</b> - Refresh jika ranking belum keluar atau jika belum update,..!</div>";
                }
                echo "<form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/cetak_uts' method='GET'>
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

                    echo "</select>";
                  if($this->session->level!='guru'){
                    echo "<tr><th scope='row'>Kelas</th>                   <td><select name='kelas' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($kelas as $k) {
                              if ($this->input->get('kelas')==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Tahun Akademik</th>                   <td><select name='tahun' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($this->input->get('tahun')==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[kode_tahun_akademik] - $k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[kode_tahun_akademik] - $k[nama_tahun]</option>";
                              }
                            }

                    echo "</select> <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>";
                  }else{
                    echo " <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                          <input type='hidden' name='kelas' value='".$this->input->get('kelas')."'>
                          <input type='hidden' name='tahun' value='".$this->input->get('tahun')."'>";
                  }
           echo "</tbody>
              </table>
              </form>
              <table class='table table-bordered table-striped'>
                  <thead>
                    <tr bgcolor=#e3e3e3>
                      <th style='width:40px'>No</th>
                      <th>NIPD</th>
                      <th>NISN</th>
                      <th>Nama siswa</th>
                      <th>Jenis Kelamin</th>
                      <th>Rank</th>
                      <th>Jumlah</th>
                      <th width='90px'>Action</th>
                    </tr>
                  </thead>
                  <tbody>";
                if ($this->input->get('angkatan')!='' AND $this->input->get('kelas')!='' AND $this->input->get('tahun')!=''){
                  $no = 1;
                  foreach ($record->result_array() as $r){
                  
                  if ($_GET['ranking']!='') {  
                      $rowp = $this->db->query("SELECT sum(a.nilai_pengetahuan) as nilai_pengetahuan, sum(a.nilai_keterampilan) as nilai_keterampilan, sum(a.nilai_pengetahuan+a.nilai_keterampilan) as total FROM `rb_nilai_borongan_uts` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND b.id_kelas='$_GET[kelas]'")->row_array();
                      $data = array('id_siswa'=>$r[id_siswa],
                                'id_tahun_akademik'=>$_GET['tahun'],
                                'pengetahuan'=>$rowp['nilai_pengetahuan'],
                                'keterampilan'=>$rowp['nilai_keterampilan'],
                                'nilai_total'=>$rowp['total'],
                                'jenis'=>'uts');
                      $cek = $this->db->query("SELECT * FROM rb_peringkat where id_siswa='$r[id_siswa]' AND id_tahun_akademik='$_GET[tahun]' AND jenis='uts'");
                      if ($cek->num_rows()>=1){
                        $where = array('id_siswa' => $r['id_siswa'],'id_tahun_akademik'=>$_GET['tahun']);
                        $this->model_app->update('rb_peringkat', $data, $where);
                      }else{
                        $this->model_app->insert('rb_peringkat',$data);
                      }
                  }
                  
                  $peringkat = $this->db->query("SELECT * FROM rb_peringkat where id_siswa='$r[id_siswa]' AND id_tahun_akademik='$_GET[tahun]' AND jenis='uts'")->row_array();
                  $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC")->num_rows();
                  echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td>$peringkat[rank]</td>
                            <td>$peringkat[nilai_total] = <span style='color:red'>".(number_format($peringkat['nilai_total']/($mapel*2),2))."</span></td>
                            <td><center>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Penilaian Diri' href='".base_url().$this->uri->segment(1)."/cetak_uts_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=1'><span class='glyphicon glyphicon-print'></span> 1</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Penilaian Diri' href='".base_url().$this->uri->segment(1)."/cetak_uts_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=2'><span class='glyphicon glyphicon-print'></span> 2</a>
                            </center></td>
                        </tr>";
                    $no++;
                    }
                  }else{
                    echo "<tr><td colspan='8'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Angkatan, Kelas dan Tahun Akademik Terlebih dahulu...</center></td></tr>";
                  }
                  
                    $rank = $this->db->query("SELECT * FROM rb_peringkat a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelas='$_GET[kelas]' AND a.jenis='uts' ORDER BY a.nilai_total DESC");
                    $ii = 1;
                    foreach ($rank->result_array() as $ra){
                      $this->db->query("UPDATE rb_peringkat SET rank='$ii' where id_siswa='$ra[id_siswa]' AND id_tahun_akademik='$ra[id_tahun_akademik]' AND jenis='uts'");
                      $ii++;
                    }
                    
                    echo "</tbody>
                  </table>
                </div>
              </div>
            </div>";