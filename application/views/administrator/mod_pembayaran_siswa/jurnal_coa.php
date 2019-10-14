<?php            
echo "<div class='col-xs-12'>  
  <div class='box'>
    <div class='box-header'>
      <h3 class='box-title'>Data Keuangan Per-COA</h3>
    </div>
    <div class='box-body'>
      <table class='table table-bordered'>
          <thead>
          <tr>
            <th width='40px'>No</th>
            <th>Kode</th>
            <th>Nama Coa</th>
            <th>Kredit</th>
            </tr>
        </thead>
        <tbody>";

        $tampil = $this->db->query("SELECT * FROM rb_keuangan_coa ORDER BY id_coa ASC");
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $kr1 = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_keuangan_bayar` a JOIN rb_keuangan_jenis b ON a.id_keuangan_jenis=b.id_keuangan_jenis where b.id_coa='$r[id_coa]'")->row_array();
        echo "<tr class='success'><td>$no</td>
                  <td>$r[kode_coa]</td>
                  <td>$r[nama_coa]</td>
                  <td>Rp ".number_format($kr1['total'])."</td>
              </tr>";
          $no++;
            $subcoa = $this->db->query("SELECT * FROM rb_keuangan_sub_coa where id_coa='$r[id_coa]' ORDER BY id_sub_coa ASC");
            foreach ($subcoa->result_array() as $row) {
              $krs1 = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_keuangan_bayar` a JOIN rb_keuangan_jenis b ON a.id_keuangan_jenis=b.id_keuangan_jenis where b.id_coa='$r[id_coa]' AND b.id_sub_coa='$row[id_sub_coa]'")->row_array();
              echo "<tr><td>-</td>
                    <td>$row[kode_sub_coa]</td>
                    <td>$row[nama_sub_coa]</td>
                    <td>Rp ".number_format($krs1['total'])."</td>
                </tr>";
            }
          }
      ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>