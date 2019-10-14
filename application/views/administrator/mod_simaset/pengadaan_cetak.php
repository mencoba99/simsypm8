<?php
	# Baca variabel URL
	$Kode = $_GET['kode'];
	# Perintah untuk mendapatkan data dari tabel pengadaan
	$myData = $this->db->query("SELECT pengadaan.*, supplier.nm_supplier, rb_guru.nama_guru FROM pengadaan 
				LEFT JOIN supplier ON pengadaan.id_supplier=supplier.id_supplier 
				LEFT JOIN rb_guru ON pengadaan.id_guru=rb_guru.id_guru 
				WHERE pengadaan.id_pengadaan='$Kode'")->row_array();

?>
<html>
<head>
<title>:: Cetak Pengadaan - Inventory Kantor ( Aset Kantor )</title>
<link href="<?php echo base_url(); ?>asset/admin/bootstrap/css/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="javascript:window.print()">
<h2> PENGADAAN BARANG </h2>
<table width="500" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="160"><b>No. Pengadaan </b></td>
    <td width="10"><b>:</b></td>
    <td width="302" valign="top"><strong><?php echo $myData['no_pengadaan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pengadaan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo tgl_indo($myData['tgl_pengadaan']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Jenis Pengadaan </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['jenis_pengadaan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7"><strong>DATA BARANG</strong></td>
  </tr>
  
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="50" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="269" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="247" bgcolor="#F5F5F5"><strong>Deskripsi</strong></td>
    <td width="114" align="center" bgcolor="#F5F5F5"><strong>Hrg. Beli(Rp)</strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="108" align="center" bgcolor="#F5F5F5"><strong>Hrg. Total(Rp)</strong> </td>
  </tr>
  <?php
$subTotalBeli=0; 
$grandTotalBeli = 0; 
$totalBarang = 0; 

$myQry = $this->db->query("SELECT pengadaan_item.*, barang.nm_barang, kategori.nm_kategori FROM pengadaan_item 
		 LEFT JOIN barang ON pengadaan_item.id_barang=barang.id_barang 
		 LEFT JOIN kategori ON barang.id_kategori=kategori.id_kategori
		 WHERE pengadaan_item.id_pengadaan='$Kode' ORDER BY pengadaan_item.id_barang");
$nomor=0; 
foreach ($myQry->result_array() as $myData) {
	$totalBarang	= $totalBarang + $myData['jumlah'];
	$subTotalBeli	= $myData['harga_beli'] * $myData['jumlah']; // harga beli dari tabel pengadaan_item (harga terbaru dari supplier)
	$grandTotalBeli	= $grandTotalBeli + $subTotalBeli;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['deskripsi']; ?></td>
    <td align="right"><?php echo rupiah($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo rupiah($subTotalBeli); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="5" align="right"><b> GRAND TOTAL  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo $totalBarang; ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo rupiah($grandTotalBeli); ?></strong></td>
  </tr>
</table>
<br/>

</body>
</html>