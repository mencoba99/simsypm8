<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Jenis Pelanggaran </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <form action="<?php echo  base_url().$this->uri->segment(1); ?>/jenis_pelanggaran" method='POST'>
          <?php 
            if ($_GET['id']!=''){
              $row = $this->db->query("SELECT * FROM rb_bk_jenis where id_jenis='$_GET[id]'")->row_array();
              $a = $row['judul'];
              $button = 'update';
              $text = 'Update Data';
              echo "<input type='hidden' value='$_GET[id]' name='id'>";
            }else{
              $a = $row['judul'];
              $button = 'submit';
              $text = 'Tambahkan Data';
            }
          ?>
          <tr>
            <th style='width:40px'></th>
            <th colspan="2"><input type="text" class='form-control' name='a' value='<?php echo $a; ?>' placeholder='Tulis jenis Pelanggaran...'></th>
            <th><input style='width:150px' type="submit" name='<?php echo $button; ?>' value='<?php echo $text; ?>' class='btn btn-primary btn-sm'></th>
          </tr>
          </form>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Jenis</th>
            <th width='180px'></th>
            <th style='width:180px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record->result_array() as $r){
        $cek = $this->model_app->view_where('rb_bk_jenis_detail',array('id_jenis'=>$r['id_jenis']));
        echo "<tr><td>$no</td>
                  <td>$r[judul]</td>
                  <td>Ada ".$cek->num_rows()." Pelanggaran</td>
                  <td><center>
                    <a class='btn btn-primary btn-xs' title='Detail Data' href='".base_url().$this->uri->segment(1)."/jenis_pelanggaran_detail?id=$r[id_jenis]'><span class='glyphicon glyphicon-search'></span> Pelanggaran</a>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/jenis_pelanggaran?id=$r[id_jenis]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_jenis_pelanggaran/$r[id_jenis]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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

