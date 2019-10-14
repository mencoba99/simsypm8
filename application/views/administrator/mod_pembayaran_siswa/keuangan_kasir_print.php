<html>
<head>
<title>Data Rekap Keuangan Kasir</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
if (trim($_GET['tanggal'])==''){
  $tgl = "Hari ini (".date('d-m-y').")";
}else{
  $tgl = $_GET['tanggal'];
}
echo "<h3><center>Rekap Keuangan Kasir Pada $tgl</center></h3>
                <table width='100%' id='tablemodul1'>
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Petugas</th>
                        <th>Total Transaksi</th>
                      </tr>
                    </thead>
                    <tbody>";

                    $tampil = $this->db->query("SELECT * FROM rb_guru where finance='Ya' ORDER BY id_guru DESC");
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    if (trim($_GET['tanggal'])!=''){
                      $ex = explode(' - ', $_GET['tanggal']);
                      $tgl1 = tgl_simpan($ex[0]);
                      $tgl2 = tgl_simpan($ex[1]);

                      $tot = $this->db->query("SELECT sum(total_bayar) as total FROM rb_keuangan_bayar where id_user='$r[id_guru]' AND (SUBSTR(waktu_bayar,1,10) BETWEEN  '".$tgl1."' AND '".$tgl2."') ORDER BY id_user DESC")->row_array();
                    }else{
                      $tot = $this->db->query("SELECT sum(total_bayar) as total FROM rb_keuangan_bayar where id_user='$r[id_guru]' AND SUBSTR(waktu_bayar,1,10)='".date('Y-m-d')."' ORDER BY id_user DESC")->row_array();
                    }
                    echo "<tr><td>$no</td>
                              <td>$r[nama_guru]</td>
                              <td>Rp ".rupiah($tot['total'])."</td>
                          </tr>";
                      $no++;
                      }

                  ?>
                    </tbody>
                  </table>

</body>
</html>