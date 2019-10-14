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
	$excel->setActiveSheetIndex(0)->setCellValue('B3', "ID SISWA");
	$excel->setActiveSheetIndex(0)->setCellValue('C3', "NIPD");
	$excel->setActiveSheetIndex(0)->setCellValue('D3', "NISN");
	$excel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA LENGKAP");
	$excel->setActiveSheetIndex(0)->setCellValue('F3', "JENIS KELAMIN");
	$excel->setActiveSheetIndex(0)->setCellValue('G3', "Tempat Lahir");
	$excel->setActiveSheetIndex(0)->setCellValue('H3', "Tanggal Lahir");	
	$excel->setActiveSheetIndex(0)->setCellValue('I3', "Agama");
	$excel->setActiveSheetIndex(0)->setCellValue('J3', "ALAMAT");
	$excel->setActiveSheetIndex(0)->setCellValue('K3', "KEBUTUHAN KHUSUS");
	$excel->setActiveSheetIndex(0)->setCellValue('L3', "RT");
	$excel->setActiveSheetIndex(0)->setCellValue('M3', "RW");
	$excel->setActiveSheetIndex(0)->setCellValue('N3', "DUSUN");
	$excel->setActiveSheetIndex(0)->setCellValue('O3', "KELURAHAN");
	$excel->setActiveSheetIndex(0)->setCellValue('P3', "KECAMATAN");
	$excel->setActiveSheetIndex(0)->setCellValue('Q3', "KODE POS");
	$excel->setActiveSheetIndex(0)->setCellValue('R3', "JENIS TINGGAL");	
	$excel->setActiveSheetIndex(0)->setCellValue('S3', "ALAT TRANSPORTASI");
	$excel->setActiveSheetIndex(0)->setCellValue('T3', "NO TELEPON");
	$excel->setActiveSheetIndex(0)->setCellValue('U3', "EMAIL");
	$excel->setActiveSheetIndex(0)->setCellValue('V3', "SKHUN");
	$excel->setActiveSheetIndex(0)->setCellValue('W3', "PENERIMA KPS");
	$excel->setActiveSheetIndex(0)->setCellValue('X3', "NO KPS");
	$excel->setActiveSheetIndex(0)->setCellValue('Y3', "FOTO");

	$excel->setActiveSheetIndex(0)->setCellValue('Z3', "NAMA AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AA3', "TAHUN LAHIR AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AB3', "PENDIDIKAN AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AC3', "PEKERJAAN AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AD3', "PENGHASILAN AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AE3', "KEBUTUHAN KHUSUS AYAH");
	$excel->setActiveSheetIndex(0)->setCellValue('AF3', "TELEPON AYAH");

	$excel->setActiveSheetIndex(0)->setCellValue('AG3', "NAMA IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AH3', "TAHUN LAHIR IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AI3', "PENDIDIKAN IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AJ3', "PEKERJAAN IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AK3', "PENGHASILAN IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AL3', "KEBUTUHAN KHUSUS IBU");
	$excel->setActiveSheetIndex(0)->setCellValue('AM3', "TELEPON IBU");

	$excel->setActiveSheetIndex(0)->setCellValue('AN3', "NAMA WALI");
	$excel->setActiveSheetIndex(0)->setCellValue('AO3', "TAHUN LAHIR WALI");
	$excel->setActiveSheetIndex(0)->setCellValue('AP3', "PENDIDIKAN WALI");
	$excel->setActiveSheetIndex(0)->setCellValue('AQ3', "PEKERJAAN WALI");
	$excel->setActiveSheetIndex(0)->setCellValue('AR3', "PENGHASILAN WALI");

	$excel->setActiveSheetIndex(0)->setCellValue('AS3', "ANGKATAN");
	$excel->setActiveSheetIndex(0)->setCellValue('AT3', "STATUS SISWA");
	$excel->setActiveSheetIndex(0)->setCellValue('AU3', "KELAS");
	$excel->setActiveSheetIndex(0)->setCellValue('AV3', "JURUSAN");
	$excel->setActiveSheetIndex(0)->setCellValue('AW3', "NO REKENING");
	
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
	
	// Set height baris ke 1, 2 dan 3
	$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
	$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
		
	$no = 0;
	$numrow = 3;

	foreach ($siswa as $row) {
		$dataSiswa = $this->db->query("SELECT * FROM rb_siswa where id_siswa='".$row['id_siswa']."'")->result_array()[0];
		$agama = $this->db->query("SELECT * FROM rb_agama where id_agama='".$dataSiswa['id_agama']."'")->result_array()[0];
		// print_r([$dataSiswa,$row,$agama['nama_agama']]); exit();
		$ex = explode('==',$row['lainnya']);
		$no++;
		$numrow++;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row['id_siswa']);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$numrow, $dataSiswa['nipd'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$numrow, $dataSiswa['nisn'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $dataSiswa['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numrow, $row['jenis_kelamin'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$numrow, $dataSiswa['tempat_lahir'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$numrow, $dataSiswa['tanggal_lahir'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$numrow, $agama['nama_agama'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$numrow, $dataSiswa['alamat'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$numrow, $dataSiswa['kebutuhan_khusus'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$numrow, $dataSiswa['rt'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$numrow, $dataSiswa['rw'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$numrow, $dataSiswa['dusun'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$numrow, $dataSiswa['kelurahan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$numrow, $dataSiswa['kecamatan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$numrow, $dataSiswa['kode_pos'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$numrow, $dataSiswa['jenis_tinggal'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$numrow, $dataSiswa['alat_transportasi'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$numrow, $dataSiswa['hp'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('U'.$numrow, $dataSiswa['email'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$numrow, $dataSiswa['skhun'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$numrow, $dataSiswa['penerima_kps'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('X'.$numrow, $dataSiswa['no_kps'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$numrow, $dataSiswa['foto'], PHPExcel_Cell_DataType::TYPE_STRING);

		$excel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$numrow, $dataSiswa['nama_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AA'.$numrow, $dataSiswa['tahun_lahir_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AB'.$numrow, $dataSiswa['pendidikan_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AC'.$numrow, $dataSiswa['pekerjaan_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AD'.$numrow, $dataSiswa['penghasilan_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AE'.$numrow, $dataSiswa['kebutuhan_khusus_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AF'.$numrow, $dataSiswa['no_telpon_ayah'], PHPExcel_Cell_DataType::TYPE_STRING);

		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AG'.$numrow, $dataSiswa['nama_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AH'.$numrow, $dataSiswa['tahun_lahir_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AI'.$numrow, $dataSiswa['pendidikan_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AJ'.$numrow, $dataSiswa['pekerjaan_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AK'.$numrow, $dataSiswa['penghasilan_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AL'.$numrow, $dataSiswa['kebutuhan_khusus_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AM'.$numrow, $dataSiswa['no_telpon_ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AN'.$numrow, $dataSiswa['nama_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AO'.$numrow, $dataSiswa['tahun_lahir_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AP'.$numrow, $dataSiswa['pendidikan_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AQ'.$numrow, $dataSiswa['pekerjaan_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AR'.$numrow, $dataSiswa['penghasilan_wali'], PHPExcel_Cell_DataType::TYPE_STRING);
		
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AS'.$numrow, $dataSiswa['angkatan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AT'.$numrow, $dataSiswa['status_siswa'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AU'.$numrow, $row['nama_kelas'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AV'.$numrow, $row['nama_jurusan'], PHPExcel_Cell_DataType::TYPE_STRING);
		$excel->setActiveSheetIndex(0)->setCellValueExplicit('AW'.$numrow, $dataSiswa['no_rek'], PHPExcel_Cell_DataType::TYPE_STRING);		
			
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
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(50); // Set width kolom D
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
	$excel->getActiveSheet()->getColumnDimension('U')->setWidth(30); // Set width kolom D
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
	
	// Set orientasi kertas jadi LANDSCAPE
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	// Set judul file excel nya
	$excel->getActiveSheet(0)->setTitle("Data Siswa PSB");
	$excel->setActiveSheetIndex(0);
	// Proses file excel
	// $objWriter = new PHPExcel_Writer_Excel2007($excel);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="data_siswa.xls"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');
	$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	// $write = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
	$write->save('php://output');
	exit;
?>