<html>
<head>
<title>Data Rekap Keuangan Kasir</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
if (trim($_GET['tanggal'])==''){
  $tgl = "Hari ini (".date('d-m-Y').")";
}else{
  $tgl = $_GET['tanggal'];
}
echo "<h3><center>Rekap Keuangan Kasir Pada $tgl</center></h3>
                <table width='100%' id='tablemodul1'>
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Biaya</th>
                        <th>Total Terima</th>
                        <th>Waktu Terima</th>
                      </tr>
                    </thead>
                    <tbody>";

                    if (trim($_GET['tanggal'])!=''){
                      $ex = explode(' - ', $_GET['tanggal']);
                      $tgl1 = tgl_simpan($ex[0]);
                      $tgl2 = tgl_simpan($ex[1]);
                      $tampil = $this->db->query("SELECT a.*, b.nisn, b.nama, c.nama_jenis FROM rb_keuangan_bayar a JOIN rb_siswa b ON a.id_siswa=b.id_siswa JOIN rb_keuangan_jenis c ON a.id_keuangan_jenis=c.id_keuangan_jenis where a.id_user='$_GET[kasir]' AND (SUBSTR(waktu_bayar,1,10) BETWEEN  '".$tgl1."' AND '".$tgl2."') ORDER BY id_keuangan_bayar DESC");
                    }else{
                      $tampil = $this->db->query("SELECT a.*, b.nisn, b.nama, c.nama_jenis FROM rb_keuangan_bayar a JOIN rb_siswa b ON a.id_siswa=b.id_siswa JOIN rb_keuangan_jenis c ON a.id_keuangan_jenis=c.id_keuangan_jenis where a.id_user='$_GET[kasir]' ORDER BY id_keuangan_bayar DESC");
                    }
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    echo "<tr><td>$no</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[nama_jenis]</td>
                              <td>Rp ".rupiah($r['total_bayar'])."</td>
                              <td>$r[waktu_bayar]</td>
                          </tr>";
                      $no++;
                      }

                  ?>
                    </tbody>
                  </table>

</body>
</html>