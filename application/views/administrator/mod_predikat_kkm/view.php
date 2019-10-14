<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Predikat Penilaian Mapel (Global)</h3>
      <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_predikat_kkm'>Tambahkan Data</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Dari</th>
            <th>Sampai</th>
            <th>Predikat</th>
            <th>KKM</th>
            <th>Keterangan</th>
            <th style='width:70px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($record as $r){
        echo "<tr><td>$no</td>
                  <td>$r[nilaia]</td>
                  <td>$r[nilaib]</td>
                  <td>$r[predikat_kkm]</td>
                  <td>$r[nilai_kkm]</td>
                  <td>$r[keterangan]</td>
                  <td><center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_predikat_kkm/$r[id_predikat_kkm]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_predikat_kkm/$r[id_predikat_kkm]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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

<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="alert alert-danger" style='padding:5px; border-radius:0px; margin:0px'>
        <p>Data Predikat Mapel Tampil Di Raport</p>
      </div>
      <table class="table table-bordered table-striped table-condensed">
        <form action='' method='POST'>
        <?php
          if ($this->input->get('edit')!=''){
            $rows = $this->db->query("SELECT * FROM rb_kkm_raport where id_kkm_raport='".$this->input->get('edit')."'")->row_array();
            echo "<tr>
              <td><input type='hidden' name='id' value='$rows[id_kkm_raport]'></td> 
              <td><input type='text' name='a' class='form-control' value='$rows[predikat]'></td> 
              <td><input type='text' name='b' class='form-control' value='$rows[kkm]'></td> 
              <td><select class='form-control' name='c'>
                    <option value=''>- Pilih- </option>";
                      $data = array('predikat','kkm');
                      for ($i=0; $i <count($data) ; $i++) { 
                        if ($rows['status']==$data[$i]){
                          echo "<option value='".$data[$i]."' selected>".$data[$i]."</option>";
                        }else{
                          echo "<option value='".$data[$i]."'>".$data[$i]."</option>";
                        }
                      }
                  echo "</select>
              </td>
              <td><input type='submit' name='update' value='Simpan' class='btn btn-sm btn-primary'></td>
            </tr>";
          }else{
            echo "<tr>
              <td></td> 
              <td><input type='text' name='a' class='form-control'></td> 
              <td><input type='text' name='b' class='form-control'></td> 
              <td><select class='form-control' name='c'>
                    <option value=''>- Pilih- </option>";
                      $data = array('predikat','kkm');
                      for ($i=0; $i <count($data) ; $i++) { 
                        echo "<option value='".$data[$i]."'>".$data[$i]."</option>";
                      }
                  echo "</select>
              </td>
              <td><input type='submit' name='submit' value='Simpan' class='btn btn-sm btn-primary'></td>
            </tr>";
          }
        ?>

        </form>
        <thead>
          <tr bgcolor='#e3e3e3'>
            <th style='width:40px'>No</th>
            <th>Predikat</th>
            <th>KKM</th>
            <th>Status</th>
            <th style='width:70px'>Action</th>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        $kkm_raport = $this->db->query("SELECT * FROM rb_kkm_raport where id_identitas_sekolah='".$this->session->sekolah."'");
        foreach ($kkm_raport->result_array() as $r){
        echo "<tr><td>$no</td>
                  <td>$r[predikat]</td>
                  <td>$r[kkm]</td>
                  <td>$r[status]</td>
                  <td><center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/predikat_kkm?edit=$r[id_kkm_raport]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_predikat_kkm_rapor/$r[id_kkm_raport]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>
                  </tr>";
          $no++;
          }
      ?>
        </tbody>
      </table>

      <div class="alert alert-success" style='padding:5px; border-radius:0px; margin:0px'>
        <p>Preview / Tampil Di Raport</p>
      </div>
      <?php 
        echo "<center>Table Interval Predikat Berdasarkan KKM
              <table id='tablemodul1' width=80% border=1>";
              $a = $this->db->query("SELECT * FROM rb_kkm_raport where status='kkm' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
              $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                echo "<tr>
                  <td align=center rowspan='3'>$a[predikat]</td>
                </tr>
                <tr>
                  <td align=center colspan='".$kkm->num_rows()."'>Predikat</td>
                </tr>
                <tr>";
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[predikat]</td>";
                  }
                echo "</tr>

                <tr>
                  <td align=center>$a[kkm]</td>";
                  $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[kkm]</td>";
                  }
                echo "</tr>
              </tr>
            </table></center>";
      ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>