<div class="box box-danger">
  <div class="box-header with-border">
  <i class="fa fa-th-large" style='color:#014282'></i>
    <h3 class="box-title" style='color:#014282'>Login History</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
      <?php 
        $guru_aktif = $this->db->query("SELECT * FROM (SELECT b.nip, b.nama_guru, COUNT(*) as total FROM `rb_users_aktivitas` a JOIN rb_guru b ON a.identitas=b.id_guru where a.id_identitas_sekolah='".$this->session->sekolah."' AND a.status='guru' AND substr(tanggal,1,7)='".date('Y-m')."' GROUP BY a.identitas) as z ORDER BY total DESC LIMIT 3");
        $noo = 1;
        if ($guru_aktif->num_rows()>=1){
            echo "Berikut ini adalah Nama-nama Guru Paling aktif bulan ini : <br>";
            foreach ($guru_aktif->result_array() as $row) {
                echo "<b>$noo. $row[nama_guru]</b> <i style='color:red'>($row[total] Point)</i> <br>";
                $noo++;
            }
            echo "<hr style='margin: 10px;'>";
        }
      ?>
    <table class="table table-condensed table-bordered">
        <?php 
          $login = $this->db->query("SELECT * FROM rb_users_aktivitas where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_users_aktivitas DESC LIMIT 8");
          foreach ($login->result_array() as $row) {
            if($row['status']=='siswa'){
                $cek = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$row['identitas']))->row_array();
                $nama_user = $cek['nama'];
            }elseif($row['status']=='orang_tua'){
                $cek = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$row['identitas']))->row_array();
                $nama_user = $cek['nama'];
            }elseif($row['status']=='guru'){
                $cek = $this->model_app->view_where('rb_guru',array('id_guru'=>$row['identitas']))->row_array();
                $nama_user = $cek['nama_guru'];
            }elseif($row['status']=='admin'){
                $cek = $this->model_app->view_where('rb_users',array('id_user'=>$row['identitas']))->row_array();
                $nama_user = $cek['nama_lengkap'];
            }
            echo "<tr>
                    <td><i>$nama_user</i></td>
                    <td style='text-transform:capitalize; color:green'><i>$row[status]</i></td>
                    <td style='color:blue'><i>$row[os]</i></td>
                    <td style='color:red'><i>$row[browser]</i></td>
                    <td><i>".cek_terakhir($row['tanggal'].' '.$row['jam'])."</i></td>
                  </tr>";
          }
        ?>
    </table>
  </div>
  <!-- /.box-body -->
</div>