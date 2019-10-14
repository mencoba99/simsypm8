<?php
	$excel = new PHPExcel();
	// Settingan awal file excel
	$excel->getProperties()->setCreator('b1em8in')
             ->setLastModifiedBy('')
             ->setTitle("Data Siswa")
             ->setSubject("siswa")
             ->setDescription("Data Siswa PSB")
             ->setKeywords("Data Siswa");
    //Style kolom
    $style_col = array(
		'font' => array('bold' => true), // Set font nya jadi bold
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);
	//Style row
	$style_row = array(
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		)
	);
	//Set header
	$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA PSB");
	$excel->getActiveSheet()->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai F1
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// Buat header tabel nya pada baris ke 3
	$excel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
	$excel->setActiveSheetIndex(0)->setCellValue('B3', "No Pendaft.");
	$excel->setActiveSheetIndex(0)->setCellValue('C3', "Pass");
	$excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Siswa");
	$excel->setActiveSheetIndex(0)->setCellValue('E3', "ID Jenis Kelamin");
	$excel->setActiveSheetIndex(0)->setCellValue('F3', "No Induk");
	$excel->setActiveSheetIndex(0)->setCellValue('G3', "Tempat Lahir");
	$excel->setActiveSheetIndex(0)->setCellValue('H3', "Tanggal Lahir");
	
	$excel->setActiveSheetIndex(0)->setCellValue('I3', "Id Agama");
	$excel->setActiveSheetIndex(0)->setCellValue('J3', "Anak Ke");
	$excel->setActiveSheetIndex(0)->setCellValue('K3', "Jumlah Saudara");
	$excel->setActiveSheetIndex(0)->setCellValue('L3', "Status dikeluarga");
	$excel->setActiveSheetIndex(0)->setCellValue('M3', "Alamat Siswa");
	$excel->setActiveSheetIndex(0)->setCellValue('N3', "No Telpon");
	$excel->setActiveSheetIndex(0)->setCellValue('O3', "Berat Badan");
	$excel->setActiveSheetIndex(0)->setCellValue('P3', "Tinggi Badan");
	$excel->setActiveSheetIndex(0)->setCellValue('Q3', "Golongan Darah");
	$excel->setActiveSheetIndex(0)->setCellValue('R3', "Penyakit Pernah derita");
	
	$excel->setActiveSheetIndex(0)->setCellValue('S3', "Sekolah Asal");
	$excel->setActiveSheetIndex(0)->setCellValue('T3', "Alamat Sekolah Asal");
	$excel->setActiveSheetIndex(0)->setCellValue('U3', "Nama Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('V3', "Tempat Lahir Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('W3', "Tanggal Lahir Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('X3', "Agama ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('Y3', "Pendidikan Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('Z3', "Pekerjaan Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('AA3', "Alamat Rumah Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('AB3', "Telpon Rumah Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('AC3', "Alamat Kantor Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('AD3', "Telpon Kantor Ayah");
	$excel->setActiveSheetIndex(0)->setCellValue('AE3', "Nama Ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AF3', "Tempat Lahir Ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AG3', "Tanggal Lahir Ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AH3', "Agama Ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AI3', "Pendidikan Ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AJ3', "Pekerjaan ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AK3', "Alamat Rumah ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AL3', "Telpon Rumah ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AM3', "Alamat Kantor ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AN3', "Telpon Kantor ibu");
	$excel->setActiveSheetIndex(0)->setCellValue('AO3', "Nama Wali");
	$excel->setActiveSheetIndex(0)->setCellValue('AP3', "Alamat Wali");
	$excel->setActiveSheetIndex(0)->setCellValue('AQ3', "No Telpon Wali");
	
	$excel->setActiveSheetIndex(0)->setCellValue('AR3', "Dusun");
	$excel->setActiveSheetIndex(0)->setCellValue('AS3', "Kelurahan");
	$excel->setActiveSheetIndex(0)->setCellValue('AT3', "Kecamatan");
	$excel->setActiveSheetIndex(0)->setCellValue('AU3', "Kode Pos");
	$excel->setActiveSheetIndex(0)->setCellValue('AV3', "Email");
	$excel->setActiveSheetIndex(0)->setCellValue('AW3', "Prestasi Akademik");
	$excel->setActiveSheetIndex(0)->setCellValue('AX3', "Prestasi Non-Akademik");
	
	$excel->setActiveSheetIndex(0)->setCellValue('AY3', "Tahun Lulus");
	$excel->setActiveSheetIndex(0)->setCellValue('AZ3', "Akreditasi Sekolah");
	$excel->setActiveSheetIndex(0)->setCellValue('BA3', "Tahu SMK ini Dari");
	
	$excel->setActiveSheetIndex(0)->setCellValue('BB3', "longitude");
	$excel->setActiveSheetIndex(0)->setCellValue('BC3', "latitude");
	$excel->setActiveSheetIndex(0)->setCellValue('BD3', "Status");
	
	// if ($_GET['jalur']=='Seleksi Rapor'){
	//     $excel->setActiveSheetIndex(0)->setCellValue('BE3', "IPA");
	//     $excel->setActiveSheetIndex(0)->setCellValue('BF3', "Matematika");
	//     $excel->setActiveSheetIndex(0)->setCellValue('BG3', "Bahasa Inggris");
	//     $excel->setActiveSheetIndex(0)->setCellValue('BH3', "Bahasa Indonesia");
	// }
	
	// Apply style header yang telah kita buat tadi ke masing-masing kolom header
	$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AK3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AL3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AM3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AN3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AO3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AP3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AQ3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AR3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AS3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AT3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AU3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AV3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AW3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AX3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AY3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('AZ3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('BA3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('BB3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('BC3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('BD3')->applyFromArray($style_col);
	
	// if ($_GET['jalur']=='Seleksi Rapor'){
	//     $excel->getActiveSheet()->getStyle('BE3')->applyFromArray($style_col);
 //    	$excel->getActiveSheet()->getStyle('BF3')->applyFromArray($style_col);
 //    	$excel->getActiveSheet()->getStyle('BG3')->applyFromArray($style_col);
 //    	$excel->getActiveSheet()->getStyle('BH3')->applyFromArray($style_col);
	// }
	
	// Set height baris ke 1, 2 dan 3
	$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
	print_r($_GET['tahun']); exit();
	if ($_GET['tahun']!=''){
	    if ($_GET['jalur']=='00' AND $_GET['jurusan']=='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran where SUBSTR(waktu_daftar,1,4)='$_GET[tahun]' ORDER BY id_pendaftaran DESC");
    	}elseif ($_GET['jalur']!='00' AND $_GET['jurusan']!='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE b.jalur='$_GET[jalur]' AND (b.pilihan1='$_GET[jurusan]' OR pilihan2='$_GET[jurusan]') AND SUBSTR(a.waktu_daftar,1,4)='$_GET[tahun]' ORDER BY a.id_pendaftaran DESC");
    	}elseif ($_GET['jalur']!='00' AND $_GET['jurusan']=='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE b.jalur='$_GET[jalur]' AND SUBSTR(a.waktu_daftar,1,4)='$_GET[tahun]' ORDER BY a.id_pendaftaran DESC");
    	}elseif ($_GET['jalur']=='00' AND $_GET['jurusan']!='00'){
    	   $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE (b.pilihan1='$_GET[jurusan]' OR pilihan2='$_GET[jurusan]') AND SUBSTR(a.waktu_daftar,1,4)='$_GET[tahun]' ORDER BY a.id_pendaftaran DESC"); 
    	}
	}else{
	    if ($_GET['jalur']=='00' AND $_GET['jurusan']=='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran ORDER BY id_pendaftaran DESC");
    	}elseif ($_GET['jalur']!='00' AND $_GET['jurusan']!='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE b.jalur='$_GET[jalur]' AND (b.pilihan1='$_GET[jurusan]' OR pilihan2='$_GET[jurusan]') ORDER BY a.id_pendaftaran DESC");
    	}elseif ($_GET['jalur']!='00' AND $_GET['jurusan']=='00'){
    	    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE b.jalur='$_GET[jalur]' ORDER BY a.id_pendaftaran DESC");
    	}elseif ($_GET['jalur']=='00' AND $_GET['jurusan']!='00'){
    	   $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran a JOIN rb_psb_pendaftaran_jalur b ON a.id_pendaftaran=b.id_pendaftaran WHERE (b.pilihan1='$_GET[jurusan]' OR pilihan2='$_GET[jurusan]') ORDER BY a.id_pendaftaran DESC"); 
    	}
	}
    $sql = $this->db->query("SELECT * FROM rb_psb_pendaftaran ORDER BY id_pendaftaran DESC");
	
	$no = 0;
	$numrow = 3;
	foreach ($sql->result_array() as $row) {
	    // if ($row['status_seleksi']=='Terima'){ 
     //      $status = 'Valid';
     //    }else{ 
     //      $status = '-';
     //    }
                    
	    $ex = explode('==',$row['lainnya']);
	    
		$no++;
		$numrow++;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['id_aktivasi']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$numrow, $row['pass'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numrow, $row['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $row['id_jenis_kelamin'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numrow, $row['no_induk'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$numrow, $row['tempat_lahir'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$numrow, $row['tanggal_lahir'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$numrow, $row['id_agama'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$numrow, $row['anak_ke'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$numrow, $row['jumlah_saudara'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$numrow, $row['status_dalam_keluarga'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$numrow, $row['alamat_siswa'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$numrow, $row['no_telpon'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$numrow, $row['berat_badan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$numrow, $row['tinggi_badan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$numrow, $row['golongan_darah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$numrow, $row['penyakit_pernah_diderita'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$numrow, $row['sekolah_asal'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$numrow, $row['alamat_sekolah_asal'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('U'.$numrow, $row['nama_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$numrow, $row['tempat_lahir_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$numrow, $row['tanggal_lahir_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('X'.$numrow, $row['agama_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$numrow, $row['pendidikan_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$numrow, $row['pekerjaan_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AA'.$numrow, $row['alamat_rumah_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AB'.$numrow, $row['telpon_rumah_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AC'.$numrow, $row['alamat_kantor_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AD'.$numrow, $row['telpon_kantor_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AE'.$numrow, $row['nama_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AF'.$numrow, $row['tempat_lahir_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AG'.$numrow, $row['tanggal_lahir_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AH'.$numrow, $row['agama_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AI'.$numrow, $row['pendidikan_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AJ'.$numrow, $row['pekerjaan_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AK'.$numrow, $row['alamat_rumah_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AL'.$numrow, $row['telpon_rumah_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AM'.$numrow, $row['alamat_kantor_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AN'.$numrow, $row['telpon_kantor_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AO'.$numrow, $row['nama_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AP'.$numrow, $row['alamat_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AQ'.$numrow, $row['no_telpon_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AR'.$numrow, $row['dusun'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AS'.$numrow, $row['kelurahan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AT'.$numrow, $row['kecamatan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AU'.$numrow, $row['kode_pos'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AV'.$numrow, $row['email'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AW'.$numrow, $row['prestasi_akademik'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AX'.$numrow, $row['prestasi_non_akademik'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AY'.$numrow, $ex['0'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AZ'.$numrow, $ex['1'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('BA'.$numrow, $ex['2'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('BB'.$numrow, $row['longitude'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('BC'.$numrow, $row['latitude'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('BD'.$numrow, $status, PHPExcel_Cell_DataType::TYPE_STRING);
		
		if ($_GET['jalur']=='Seleksi Rapor'){
		    $ipa = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$row[id_pendaftaran]' AND nama_mapel='IPA'")->row_array();
		    $mtk = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$row[id_pendaftaran]' AND nama_mapel='Matematika'")->row_array();
		    $bing = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$row[id_pendaftaran]' AND nama_mapel='Bahasa Inggris'")->row_array();
		    $bind = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$row[id_pendaftaran]' AND nama_mapel='Bahasa Indonesia'")->row_array();
		    
		    $nilai1 = $ipa['semester1'].', '.$ipa['semester2'].', '.$ipa['semester3'].', '.$ipa['semester4'].', '.$ipa['semester5'];
		    $nilai2 = $mtk['semester1'].', '.$mtk['semester2'].', '.$mtk['semester3'].', '.$mtk['semester4'].', '.$mtk['semester5'];
		    $nilai3 = $bing['semester1'].', '.$bing['semester2'].', '.$bing['semester3'].', '.$bing['semester4'].', '.$bing['semester5'];
		    $nilai4 = $bind['semester1'].', '.$bind['semester2'].', '.$bind['semester3'].', '.$bind['semester4'].', '.$bind['semester5'];
		    
		    $excel->setActiveSheetIndex(0)->setCellValueExplicit('BE'.$numrow, $nilai1, PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->setActiveSheetIndex(0)->setCellValueExplicit('BF'.$numrow, $nilai2, PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->setActiveSheetIndex(0)->setCellValueExplicit('BG'.$numrow, $nilai3, PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->setActiveSheetIndex(0)->setCellValueExplicit('BH'.$numrow, $nilai4, PHPExcel_Cell_DataType::TYPE_STRING);
		}
		
		// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);
		
		$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AQ'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AR'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AS'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AT'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AU'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AV'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AW'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AX'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AY'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('AZ'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('BA'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('BB'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('BC'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('BD'.$numrow)->applyFromArray($style_row);
		if ($_GET['jalur']=='Seleksi Rapor'){
		    $excel->getActiveSheet()->getStyle('BE'.$numrow)->applyFromArray($style_row);
    		$excel->getActiveSheet()->getStyle('BF'.$numrow)->applyFromArray($style_row);
    		$excel->getActiveSheet()->getStyle('BG'.$numrow)->applyFromArray($style_row);
    		$excel->getActiveSheet()->getStyle('BH'.$numrow)->applyFromArray($style_row);  
		}
		$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
		
	}
	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); // Set width kolom B
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('T')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('U')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('V')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('W')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('X')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20); // Set width kolom D
	
	$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20); // Set width kolom A
	$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20); // Set width kolom B
	$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20); // Set width kolom C
	$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AU')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AV')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AW')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AX')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AY')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(20); // Set width kolom D
	
	$excel->getActiveSheet()->getColumnDimension('BA')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('BB')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('BC')->setWidth(20); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension('BD')->setWidth(20); // Set width kolom D
	
	if ($_GET['jalur']=='Seleksi Rapor'){
	    $excel->getActiveSheet()->getColumnDimension('BE')->setWidth(20); // Set width kolom D
    	$excel->getActiveSheet()->getColumnDimension('BF')->setWidth(20); // Set width kolom D
    	$excel->getActiveSheet()->getColumnDimension('BG')->setWidth(20); // Set width kolom D
    	$excel->getActiveSheet()->getColumnDimension('BH')->setWidth(20); // Set width kolom D
	}
	
	// Set orientasi kertas jadi LANDSCAPE
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	// Set judul file excel nya
	$excel->getActiveSheet(0)->setTitle("Data Siswa PSB");
	$excel->setActiveSheetIndex(0);
	// Proses file excel
	// $objWriter = new PHPExcel_Writer_Excel2007($excel); 
	if ($_GET['jalur']=='Seleksi Rapor'){
	    $jalur = 'seleksi_rapor';
	}elseif ($_GET['jalur']=='Jalur Tes'){
	    $jalur = 'jalur_tes';
	}else{
	    $jalur = 'semua_jalur';
	}
	
	if ($_GET['jurusan']=='0'){
	    $jurusan = 'kimia_industri';
	}elseif ($_GET['jurusan']=='1'){
	    $jurusan = 'teknik_otomatisasi_industri';
	}else{
	    $jurusan = 'semua_jurusan';
	}
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="siswa_psb_'.$jalur.'_'.$jurusan.'.xls"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');
	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	// $write = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
	$write->save('php://output');
	exit;
?>