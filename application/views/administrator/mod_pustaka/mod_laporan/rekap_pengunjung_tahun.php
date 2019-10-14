<?php 
if ($_GET['tahun']!=''){
    $tahun = $_GET['tahun'];
  }else{
    $tahun = date('Y');
  }
?>
<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Rekap pengunjung Perpustakaan  </h3>
      <?php
        echo "<a target='_BLANK' href='".base_url().$this->uri->segment(1)."/rekap_pengunjung_tahun/print?tahun=$tahun' class='btn btn-success btn-sm pull-right'><span class='glyphicon glyphicon-print'></span></a>";
      ?>
      <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1); ?>/rekap_pengunjung_tahun' method='GET'>
          <input type="number" name='tahun' style='padding:3px; width:80px; text-align:center' value='<?php echo "$tahun"; ?>'>
          <input type="submit" style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'>
      </form>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th rowspan='2'>Bulan</th>
            <th colspan='31'><center>Tanggal</center></th>
            <th rowspan='2'>Jumlah</th>
          </tr>
          <tr>
            <?php 
              for ($i=1; $i <=31 ; $i++) { 
                echo "<th bgcolor='#e3e3e3'>$i</th>";
              }
            ?>
          </tr>
        </thead>
        <tbody>
      <?php 
        for ($i=1; $i <=12 ; $i++) { 
          if (strlen($i)==1){ $bulan = '0'.$i; }else{ $bulan = $i; }
          if ($i%2==0){ $bg = '#e3e3e3'; }else{ $bg = ''; }
          echo "<tr bgcolor='$bg'>
                  <td>".getBulan($i)."</td>";
                  for ($ii=1; $ii <=31 ; $ii++) { 
                    if (strlen($ii)==1){ $tanggal = '0'.$ii; }else{ $tanggal = $ii; }
                    $kunjungan = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,10)='$tahun-$bulan-$tanggal'")->num_rows();
                    echo "<td>$kunjungan</td>";
                  }
                  $kunjungan_bulan = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,7)='$tahun-$bulan'")->num_rows();
                echo "
                  <td align=center>$kunjungan_bulan</td>
                </tr>";
        }
        $kunjungan_tahun = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,4)='$tahun'")->num_rows();
          echo "<tr align=center class='alert alert-success'><td></td><td colspan='31'><b>Jumlah</b></td><td>$kunjungan_tahun</td></tr>";
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>