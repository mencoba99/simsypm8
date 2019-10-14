<?php
  if (isset($_GET['tanggal'])){
    $title = "Data Rekap Keuangan Kasir pada : $_GET[tanggal]";
  }else{
    $title = "Data Rekap Keuangan Kasir";
  }
?> 
            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $title; ?> </h3>
                  <a class='btn btn-success btn-sm pull-right' target='_BLANK' style='margin-left:3px' href='<?php echo base_url().$this->uri->segment(1); ?>/print_keuangan_rekap?tanggal=<?php echo $_GET[tanggal]; ?>'>Print Rekap</a>
                  <hr>
                  <form style='margin-right:5px; margin-top:0px' action='' method='GET'>
                  <input type="hidden" name='view' value='rekapkeuangankasir'>
                  Filter Tanggal : <input type='text' class='form-control' id='rangepicker' style='display:inline-block; width:200px' value='<?php echo $_GET[tanggal]; ?>' name='tanggal' placeholder='DD-MM-YYYY - DD-MM-YYYY' autocomplete=off>
                  <input type="submit" name='submit' style='margin-top:-4px' class='btn btn-primary btn-sm' value='Lihat'>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Petugas</th>
                        <th>Total Transaksi</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                  $no=1;
                    foreach ($record->result_array() as $r) {
                    if ($r['nama_guru']==''){
                      $nama_guru = "<i style='color:green'>Anonymous</i>";
                      $id = $r['id_user'];
                    }else{
                      $nama_guru = "$r[nama_guru]";
                      $id = $r['id_guru'];
                    }

                    if (isset($_GET['tanggal'])){
                      $ex = explode(' - ', $_GET['tanggal']);
                      $tgl1 = tgl_simpan($ex[0]);
                      $tgl2 = tgl_simpan($ex[1]);
                      $tot = $this->db->query("SELECT sum(total_bayar) as total FROM rb_keuangan_bayar where id_user='$id' AND (SUBSTR(waktu_bayar,1,10) BETWEEN  '".$tgl1."' AND '".$tgl2."') ORDER BY id_user DESC")->row_array();
                    }else{
                      $tot = $this->db->query("SELECT sum(total_bayar) as total FROM rb_keuangan_bayar where id_user='$id' ORDER BY id_user DESC")->row_array();
                    }
                    echo "<tr><td>$no</td>
                              <td>$nama_guru</td>
                              <td>Rp ".rupiah($tot['total'])."</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' target='_BLANK' title='Print Data' href='".base_url().$this->uri->segment(1)."/print_keuangan_detail?kasir=$r[id_guru]&tanggal=$_GET[tanggal]'><span class='glyphicon glyphicon-print'></span> Print Detail</a>
                              </center></td>
                          </tr>";
                      $no++;
                      }

                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>