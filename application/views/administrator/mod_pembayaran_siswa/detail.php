<?php 
$sisa = $t['total']-$j['total_beban'];
if ($j['total_beban'] <= $t['total']) { $status = 'Lunas'; $class = 'success'; }else{ $status = 'Belum Lunas'; $class = 'danger'; }
            echo "<div class='col-xs-12'>  
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>Data Keuangan Siswa</h3>
                  <a class='pull-right btn btn-success btn-sm' style='margin-left:3px' target='_BLANK' href='".base_url().$this->uri->segment(1)."/print_pembayaran_siswa?tahun=$_GET[tahun]&kelas=$_GET[kelas]&biaya=$_GET[biaya]&id_siswa=$_GET[id_siswa]'><span class='glyphicon glyphicon-print'></span></a>
                  <a class='pull-right btn btn-sm btn-warning' href='".base_url().$this->uri->segment(1)."/pembayaran_siswa?tahun=$_GET[tahun]&kelas=$_GET[kelas]&biaya=$_GET[biaya]'>Kembali</a>
                </div>
                <div class='box-body'>
                  <div class='col-md-12'>
                    <div class='col-xs-6'>  
                      <table class='table table-condensed table-hover'>
                          <tbody>
                            <tr><th width='120px' scope='row'>Nama Kelas</th> <td>$d[nama_kelas]</td></tr>
                            <tr><th scope='row'>Nama Siswa</th>           <td>$d[nama]</td></tr>
                            <tr><th scope='row'>Jenis Biaya</th>           <td>
                              <select class='form-control' style='padding:4px; border:1px solid green' onchange=\"document.location.href=this.value\">
                                <option value='".base_url().$this->uri->segment(1)."/detail_pembayaran_siswa?tahun=".$this->input->get('tahun')."&kelas=".$this->input->get('kelas')."&biaya=".$this->input->get('biaya')."&id_siswa=".$this->input->get('id_siswa')."'>- Pilih Jenis Biaya -</option>";
                                $biaya = $this->db->query("SELECT * FROM rb_keuangan_jenis a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where a.id_kelas='".$this->input->get('kelas')."' AND b.id_identitas_sekolah='".$this->session->sekolah."'");
                                foreach ($biaya->result_array() as $k) {
                                  if ($this->input->get('biaya')==$k['id_keuangan_jenis']){
                                    echo "<option value='".base_url().$this->uri->segment(1)."/detail_pembayaran_siswa?tahun=".$this->input->get('tahun')."&kelas=".$this->input->get('kelas')."&biaya=".$k['id_keuangan_jenis']."&id_siswa=".$this->input->get('id_siswa')."' selected>$k[nama_jenis]</option>";
                                  }else{
                                    echo "<option value='".base_url().$this->uri->segment(1)."/detail_pembayaran_siswa?tahun=".$this->input->get('tahun')."&kelas=".$this->input->get('kelas')."&biaya=".$k['id_keuangan_jenis']."&id_siswa=".$this->input->get('id_siswa')."'>$k[nama_jenis]</option>";
                                  }
                                }
                        echo "</select>
                            </td></tr>";

                          echo "</tbody>
                      </table>
                    </div>

                    <div class='col-xs-6'>  
                      <table class='table table-condensed table-hover'>
                          <tbody>";
                            echo "<tr><th width='120px' scope='row'>Total Beban</th>           <td>Rp ".number_format($j['total_beban'])."</td></tr>
                                    <tr><th scope='row'>Total Bayar</th>           <td>Rp ".number_format($t['total'])."</td></tr>
                                    <tr><th scope='row'>Sisa</th>           <td>Rp ".number_format($t['total']-$j['total_beban'])."</td></tr>";

                          echo "</tbody>
                      </table>
                    </div>
                  </div><hr><br>";

                  if ($sisa < 0 OR $j['total_beban']=='0'){
                        echo "<div style='clear:both'></div><div class='box-header'><h3 class='box-title'>Transaksi Pembayaran</h3></div>
                        <div class='col-xs-12'>  
                        <form action='".base_url().$this->uri->segment(1)."/detail_pembayaran_siswa?tahun=$_GET[tahun]&kelas=$_GET[kelas]&biaya=$_GET[biaya]&id_siswa=$_GET[id_siswa]' method='POST'>
                            <table class='table table-condensed table-hover'>
                                <tr><th scope='row' width='120px'>No Transaksi</th>           <td><input type='text' class='form-control' name='kode' value='TRX-".date('YmdHis')."'></td></tr>
                                <tr><th scope='row' width='120px'>Metode Bayar</th>           <td><select class='form-control' name='metode'>
                                                                                                    <option value='' selected>- Pilih -</option>
                                                                                                    <option value='Cash'>Cash</option>
                                                                                                    <option value='EDC'>EDC</option>
                                                                                                    <option value='Transfer'>Transfer</option>
                                                                                                  </select></td></tr>
                                <tr><th scope='row' width='120px'>Bayar Sisa</th>           <td><input type='text' class='form-control' name='bayar' value=''></td></tr>
                                <tr><td><input class='btn btn-primary btn-sm' type='submit' name='proses' value='Proses'></td></tr>
                            </table>
                        </form>
                        </div>";
                  }

                  echo "<table id='example' class='table table-bordered table-striped'>
                    <thead>
                      <tr bgcolor='#cecece'>
                        <th style='width:20px'>No</th>
                        <th>Kode</th>
                        <th>Metode Bayar</th>
                        <th>Total Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                      
                    $no = 1;
                    foreach ($pembayaran as $r) {
                    $ex = explode(' ',$r['waktu_bayar']);
                    echo "<tr><td>$no</td>
                              <td>$r[kode]</td>
                              <td>$r[metode]</td>
                              <td>Rp ".number_format($r['total_bayar'])."</td>
                              <td>".tgl_indo($ex[0])." ".$ex[1]." WIB</td>
                              <td style='width:80px !important'><center>
                                  <a class='btn btn-danger btn-xs' title='Delete Data' href='index.php?view=pembayaransiswa&act=detail&sekolah=$_GET[sekolah]&tahun=$_GET[tahun]&kelas=$_GET[kelas]&biaya=$_GET[biaya]&id_siswa=$_GET[id_siswa]&hapus=$r[id_keuangan_bayar]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                          </tr>";
                      $no++;
                      }

                    echo "<tbody>
                  </table>
                </div>
              </div>
            </div>";