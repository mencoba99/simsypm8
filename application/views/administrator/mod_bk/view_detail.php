<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Pelanggaran <b><?php echo $row['judul']; ?></b></h3>
      <a class='pull-right btn btn-warning btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/jenis_pelanggaran' style='margin-left:3px'>Kembali</a>
      <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_jenis_pelanggaran?id=<?php echo $_GET[id]; ?>'>Tambahkan Data</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Jenis Pelanggaran</th>
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
                  <td>$r[pelanggaran]</td>
                  <td>$r[bobot]</td>
                  <td>$r[keterangan]</td>
                  <td><center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_jenis_pelanggaran?id=$_GET[id]&jenis=$r[id_jenis_detail]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_jenis_pelanggaran_detail/$r[id_jenis_detail]/$_GET[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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

