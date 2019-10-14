<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Sanksi pelanggaran</b></h3>
      <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_sanksi_pelanggaran'>Tambahkan Data</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Jenis Sanksi</th>
            <th>Bobot</th>
            <th>Keterangan</th>
            <th style='width:80px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        echo "<tr><td>$no</td>
                  <td>$r[jenis_sanksi]</td>
                  <td>$r[bobot_dari] - $r[bobot_sampai]</td>
                  <td>$r[keterangan]</td>
                  <td><center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_sanksi_pelanggaran/$r[id_sanksi_pelanggar]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_sanksi_pelanggaran/$r[id_sanksi_pelanggar]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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

