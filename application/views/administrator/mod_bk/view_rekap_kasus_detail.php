<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Detail Rekaman Pelanggaran</b></h3>
      <a class='btn btn-success btn-sm pull-right' target='_BLANK' href='<?php echo base_url().$this->uri->segment(1); ?>/print_rekap_kasus/<?php echo $this->uri->segment(3).'/'.$this->uri->segment(4);?>'><span class='glyphicon glyphicon-print'></span></a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped table-condensed">
        <tr><td width='120px'>NIPD</td>       <td style='border-bottom:1px solid #e3e3e3'><?php echo "$row[nipd]"; ?></td></tr>
        <tr><td>Nama Siswa</td> <td style='border-bottom:1px solid #e3e3e3'><?php echo "$row[nama]"; ?></td></tr>
        <tr><td>Kelas</td>      <td style='border-bottom:1px solid #e3e3e3'><?php echo "$row[nama_kelas]"; ?></td></tr>
      </table><br>

      <table class="table table-bordered table-striped">
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Jenis Pelanggaran</th>
            <th>Bobot</th>
            <th>Penemu Kasus</th>
            <th>Keterangan</th>
            <th>Jenis Sanksi</th>
            <th>Tindakan</th>
            <th>Pihak Terkait</th>
            <th>Ditindak Lanjuti</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        $sanksi = $this->db->query("SELECT * FROM rb_bk_sanksi_pelanggar where (".number_format($r['bobot'])." >=bobot_dari) AND (".number_format($r['bobot'])." <= bobot_sampai)")->row_array();
        echo "<tr><td>$no</td>
                  <td><b style='color:green'>$r[judul]</b> - $r[pelanggaran]</td>
                  <td>$r[bobot]</td>
                  <td>$r[nama_guru]</td>
                  <td>$r[ket_pelanggaran]</td>
                  <td>$sanksi[jenis_sanksi]</td>
                  <td>$r[tindakan]</td>
                  <td>$r[pihak_terkait]</td>
                  <td>$r[ditindak_lanjuti_oleh]</td>
                  </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>

