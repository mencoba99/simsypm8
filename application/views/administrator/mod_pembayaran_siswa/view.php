            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Keuangan Siswa</h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1); ?>/pembayaran_siswa' method='GET'>

                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php 
                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/pembayaran_siswa' method='GET'>";
                    // <table class='table table-condensed table-hover'>
                    //     <tbody>
                    //       <tr><th width='120px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
                    //       <option value=''>- Pilih -</option>";
                    //         foreach ($tahun as $k) {
                    //           if ($_GET['tahun']==$k['id_tahun_akademik']){
                    //             echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                    //           }else{
                    //             echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                    //           }
                    //         }

                    // echo "</select></td></tr>
                    //       <tr><th scope='row'>Kelas</th> <td><select name='kelas' style='padding:4px; width:300px'>
                    //            <option value=''>- Pilih -</option>";
                    //               foreach ($kelas as $k) {
                    //                 if ($this->input->get('kelas')==$k['id_kelas']){
                    //                   echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                    //                 }else{
                    //                   echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                    //                 }
                    //               }

                    //       echo "</select>";

                    //             if (isset($_GET['kelas']) AND isset($_GET['tahun'])){
                                  // echo "</td></tr><th scope='row'>Jenis Biaya</th> <td><select name='biaya' style='padding:4px; width:300px'>
                                  //         <option value=''>- Pilih -</option>";
                                  //         foreach ($jenis_biaya as $k) {
                                  //           if ($_GET['biaya']==$k['id_keuangan_jenis']){
                                  //             echo "<option value='$k[id_keuangan_jenis]' selected>$k[nama_jenis]</option>";
                                  //           }else{
                                  //             echo "<option value='$k[id_keuangan_jenis]'>$k[nama_jenis]</option>";
                                  //           }
                                  //         }

                                  // echo "</select>";
                                // }
                                echo "
                                 &nbsp; <h4 class='pull-right' style='margin-top:-4px;margin-left:px; color:green' >Lunas :</h4>
                                 <h4 class='pull-right' style='margin-top:-4px;margin-right:40px; color:red' >Belum Lunas :</h4></td></tr>
                        </tbody>
                    </table>
                    </form>";
                ?> 
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr><th width='30px'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <?php 
                          $j = $this->db->query("SELECT * FROM `rb_keuangan_jenis`")->row_array();
                          // if ($_GET['biaya'] != ''){
                            echo "<th>Jumlah Beban</th>
                                  <th>Total Bayar</th>";
                                  if ($j['total_beban'] != '0'){
                                    echo "<th>Status</th>";
                                  }
                          // }

                          // if ($_GET['biaya']!=''){
                          //   if ($j['total_beban'] != '0'){
                              echo "<th width='100px'>Action</th>";
                            // }else{
                              // echo "<th width='60px'>Action</th>";
                            // }
                          // } 
                          ?>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $t = $this->db->query("SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_keuangan_jenis='$_GET[biaya]' AND id_siswa='$r[id_siswa]'")->row_array();
                      if ($j['total_beban'] <= $t['total']) {
                        $status = 'Lunas'; $class = 'green'; 
                      }else{
                      $status = 'Belum Lunas'; $class = 'red'; 
                      }
                    echo "<tr><td>$no</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>";
                              // if ($_GET['biaya'] != ''){
                                  echo "<td>Rp ".number_format($j['total_beban'])."</td>
                                        <td>Rp ".number_format($t['total'])."</td>";
                                      if ($j['total_beban'] != '0'){
                                        echo "<td><i style='color:$class'>$status</i></td>";
                                      }
                              // }

                              // if ($_GET['biaya']!=''){
                              echo "<td><center>
                                  <a class='btn btn-info btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/detail_pembayaran_siswa?id_siswa=$r[id_siswa]'><span class='glyphicon glyphicon-usd'></span> Bayar</a> ";
                              echo "<a class='btn btn-success btn-xs' target='_BLANK' href='".base_url().$this->uri->segment(1)."/print_pembayaran_siswa?id_siswa=$r[id_siswa]'><span class='glyphicon glyphicon-print'></span></a></center></td>";
                              // }
                          echo "</tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>