<html>
<head>
<title>Nota Penjualan</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$trx = $this->db->query("SELECT a.kode_penjualan, a.id_siswa, a.metode, a.jumlah_bayar, a.deskripsi, a.id_guru, a.waktu_penjualan, b.id_identitas_sekolah FROM rb_koperasi_penjualan a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_penjualan='$_GET[id]'")->row_array();
$s = $this->db->query("SELECT a.*, b.*, c.nama_guru as walikelas, c.nip FROM rb_siswa a 
                                      JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                        LEFT JOIN rb_guru c ON b.id_guru=c.id_guru where a.id_siswa='$trx[id_siswa]' AND a.id_identitas_sekolah='$trx[id_identitas_sekolah]'")->row_array();
$iden = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$trx[id_identitas_sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
echo "<h2><center>NOTA PENJUALAN<br><span style='font-size:12px'>$trx[kode_penjualan]</span></center></h2>";
echo "<table width=100%>
        <tr><td width=140px>Nama Sekolah</td> <td> : $iden[nama_sekolah] </td></tr>
        <tr><td>Alamat</td>                   <td> : $iden[alamat_sekolah] </td></tr>
        <tr><td>Nama Peserta Didik</td>       <td> : <b>$s[nama]</b> </td></tr>
        <tr><td>No Induk/NISN</td>            <td> : $s[nipd] / $s[nisn]</td></tr>
        <tr><td>Kelas</td>            <td> : $s[kode_kelas]</td></tr>
      </table><hr>";

            echo "<table width='100%' id='tablemodul1'>
                    <thead>
                      <tr bgcolor=#cecece>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Sub-Total</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    $ex = explode(' ',$r['waktu_bayar']);
                    echo "<tr><td>$no</td>
                              <td>$r[nama_barang]</td>
                              <td>$r[jumlah_jual] $r[satuan]</td>
                              <td>Rp ".rupiah($r['harga'])."</td>
                              <td>Rp ".rupiah($r['diskon'])."</td>
                              <td>Rp ".rupiah(($r['harga']*$r['jumlah_jual'])-$r['diskon'])."</td>
                          </tr>";
                      $no++;
                      }
                      $jml = $this->db->query("SELECT sum(harga) as harga, sum((jumlah_jual*harga)-diskon) as total, sum(diskon) as diskon FROM `rb_koperasi_penjualan_detail` a where a.id_penjualan='$_GET[id]'")->row_array();
                      echo "<tr bgcolor=#cecece>
                              <td colspan='3'><b>Total</b></td>
                              <td><b></b></td>
                              <td><b></b></td>
                              <td><b>Rp ".rupiah($jml['total'])."</b></td>
                            </tr>";
                      echo "<tr bgcolor=#cecece>
                              <td colspan='5'><b>Bayar</b></td>
                              <td><b>Rp ".rupiah($trx['jumlah_bayar'])."</b></td>
                            </tr>";
                      echo "<tr bgcolor=#cecece>
                              <td colspan='5'><b>Kembali</b></td>
                              <td><b>Rp ".rupiah($trx['jumlah_bayar']-$jml['total'])."</b></td>
                            </tr>";
                  ?>
                    </tbody>
                  </table>
</body>
</html>