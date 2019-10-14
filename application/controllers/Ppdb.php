<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ppdb extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    // Controller Modul Menu Website
    function menuwebsite(){
        cek_session_akses('menuwebsite',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT * FROM rb_psb_menu ORDER BY urutan");
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_menu/view_menu',$data);
    }

    function tambah_menuwebsite(){
        cek_session_akses('menuwebsite',$this->session->id_session);
        if (isset($_POST['submit'])){
            $datadb = array('id_parent'=>$this->db->escape_str($this->input->post('b')),
                            'nama_menu'=>$this->db->escape_str($this->input->post('c')),
                            'link'=>$this->db->escape_str($this->input->post('a')),
                            'aktif'=>$this->db->escape_str('Ya'),
                            'position'=>$this->db->escape_str($this->input->post('d')),
                            'urutan'=>$this->db->escape_str($this->input->post('e')));
            $this->model_app->insert('rb_psb_menu',$datadb);
            redirect($this->uri->segment(1).'/menuwebsite');
        }else{
            $data['record'] = $this->db->query("SELECT * FROM rb_psb_menu where id_parent='0' ORDER BY urutan");
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_menu/view_menu_tambah',$data);
        }
    }

    function edit_menuwebsite(){
        cek_session_akses('menuwebsite',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $datadb = array('id_parent'=>$this->db->escape_str($this->input->post('b')),
                            'nama_menu'=>$this->db->escape_str($this->input->post('c')),
                            'link'=>$this->db->escape_str($this->input->post('a')),
                            'aktif'=>$this->db->escape_str($this->input->post('f')),
                            'position'=>$this->db->escape_str($this->input->post('d')),
                            'urutan'=>$this->db->escape_str($this->input->post('e')));
            $where = array('id_menu' => $this->input->post('id'));
            $this->model_app->update('rb_psb_menu', $datadb, $where);
            redirect($this->uri->segment(1).'/menuwebsite');
        }else{
            $data['record'] = $this->db->query("SELECT * FROM rb_psb_menu where id_parent='0' ORDER BY urutan");
            $data['rows'] = $this->db->query("SELECT * FROM rb_psb_menu where id_menu='$id'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_menu/view_menu_edit',$data);
        }
    }

    function delete_menuwebsite(){
        cek_session_akses('menuwebsite',$this->session->id_session);
        $id = array('id_menu' => $this->uri->segment(3));
        $this->model_app->delete('rb_psb_menu',$id);
        redirect($this->uri->segment(1).'/menuwebsite');
    }


    // Controller Modul Halaman Baru

    function halamanbaru(){
        cek_session_akses('halamanbaru',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_psb_halaman','id_halaman','DESC');
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_halaman/view_halaman',$data);
    }

    function tambah_halamanbaru(){
        cek_session_akses('halamanbaru',$this->session->id_session);
        if (isset($_POST['submit'])){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>seo_title($this->input->post('a')),
                                    'isi_halaman'=>$this->input->post('b'),
                                    'username'=>$this->session->username);
            $this->model_app->insert('rb_psb_halaman',$data);
            redirect($this->uri->segment(1).'/halamanbaru');
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_halaman/view_halaman_tambah');
        }
    }

    function edit_halamanbaru(){
        cek_session_akses('halamanbaru',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
                    $data = array('judul'=>$this->db->escape_str($this->input->post('a')),
                                    'judul_seo'=>seo_title($this->input->post('a')),
                                    'isi_halaman'=>$this->input->post('b'));
            $where = array('id_halaman' => $this->input->post('id'));
            $this->model_app->update('rb_psb_halaman', $data, $where);
            redirect($this->uri->segment(1).'/halamanbaru');
        }else{
            $proses = $this->model_app->edit('rb_psb_halaman', array('id_halaman' => $id))->row_array();
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_halaman/view_halaman_edit',$data);
        }
    }

    function delete_halamanbaru(){
        cek_session_akses('halamanbaru',$this->session->id_session);
        $id = array('id_halaman' => $this->uri->segment(3));
        $this->model_app->delete('rb_psb_halaman',$id);
        redirect($this->uri->segment(1).'/halamanbaru');
    }


    function rekening(){
        cek_session_akses('rekening',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_psb_rekening','id_rekening','DESC');
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_rekening/view',$data);
    }

    function tambah_rekening(){
        cek_session_akses('rekening',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_bank'=>$this->input->post('a'),
                            'nama_pemilik'=>$this->input->post('b'),
                            'no_rekening'=>$this->input->post('c'),
                            'id_user'=>$this->session->id_session);
            $this->model_app->insert('rb_psb_rekening',$data);
            redirect($this->uri->segment(1).'/rekening');
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_rekening/tambah',$data);
        }
    }

    function edit_rekening(){
        cek_session_akses('rekening',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_bank'=>$this->input->post('a'),
                            'nama_pemilik'=>$this->input->post('b'),
                            'no_rekening'=>$this->input->post('c'));
            $where = array('id_rekening' => $this->input->post('id'));
            $this->model_app->update('rb_psb_rekening', $data, $where);
            redirect($this->uri->segment(1).'/rekening');
        }else{
            $edit = $this->model_app->view_where('rb_psb_rekening', array('id_rekening'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_rekening/edit',$data);
        }
    }

    function delete_rekening(){
        cek_session_akses('rekening',$this->session->id_session);
        $id = array('id_rekening' => $this->uri->segment(3));
        $this->model_app->delete('rb_psb_rekening',$id);
        redirect($this->uri->segment(1).'/rekening');
    }

    function jadwal_pendaftaran(){
        cek_session_akses('jadwal_pendaftaran',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_psb_jadwal','id_jadwal','DESC');
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_jadwal/view',$data);
    }

    function tambah_jadwal_pendaftaran(){
        cek_session_akses('jadwal_pendaftaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_jenjang'=>$this->session->sekolah,
                            'id_gelombang'=>1,
                            'pelaksanaan'=>tgl_simpan($this->input->post('a')),
                            'pengumuman'=>tgl_simpan($this->input->post('b')),
                            'waktu_terbit'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_psb_jadwal',$data);
            redirect($this->uri->segment(1).'/jadwal_pendaftaran');
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_jadwal/tambah',$data);
        }
    }

    function edit_jadwal_pendaftaran(){
        cek_session_akses('jadwal_pendaftaran',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_jenjang'=>$this->session->sekolah,
                            'id_gelombang'=>1,
                            'pelaksanaan'=>tgl_simpan($this->input->post('a')),
                            'pengumuman'=>tgl_simpan($this->input->post('b')));
            $where = array('id_jadwal' => $this->input->post('id'));
            $this->model_app->update('rb_psb_jadwal', $data, $where);
            redirect($this->uri->segment(1).'/jadwal_pendaftaran');
        }else{
            $edit = $this->model_app->view_where('rb_psb_jadwal', array('id_jadwal'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_jadwal/edit',$data);
        }
    }

    function delete_jadwal_pendaftaran(){
        cek_session_akses('jadwal_pendaftaran',$this->session->id_session);
        $id = array('id_jadwal' => $this->uri->segment(3));
        $this->model_app->delete('rb_psb_jadwal',$id);
        redirect($this->uri->segment(1).'/jadwal_pendaftaran');
    }

    function uang_pangkal(){
        cek_session_akses('uang_pangkal',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_psb_uangpangkal','id_uangpangkal','DESC');
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_uang_pangkal/view',$data);
    }

    function tambah_uang_pangkal(){
        cek_session_akses('uang_pangkal',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_jenjang'=>$this->session->sekolah,
                            'id_gelombang'=>($this->input->post('g')),
                            'dari_nilai'=>($this->input->post('a')),
                            'sampai_nilai'=>($this->input->post('b')),
                            'grade'=>($this->input->post('c')),
                            'nominal'=>($this->input->post('d')));
            $this->model_app->insert('rb_psb_uangpangkal',$data);
            redirect($this->uri->segment(1).'/uang_pangkal');
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_uang_pangkal/tambah',$data);
        }
    }

    function edit_uang_pangkal(){
        cek_session_akses('uang_pangkal',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_jenjang'=>$this->session->sekolah,
                            'id_gelombang'=>($this->input->post('g')),
                            'dari_nilai'=>($this->input->post('a')),
                            'sampai_nilai'=>($this->input->post('b')),
                            'grade'=>($this->input->post('c')),
                            'nominal'=>($this->input->post('d')));
            $where = array('id_uangpangkal' => $this->input->post('id'));
            $this->model_app->update('rb_psb_uangpangkal', $data, $where);
            redirect($this->uri->segment(1).'/uang_pangkal');
        }else{
            $edit = $this->model_app->view_where('rb_psb_uangpangkal', array('id_uangpangkal'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_uang_pangkal/edit',$data);
        }
    }

    function delete_uang_pangkal(){
        cek_session_akses('jadwal_pendaftaran',$this->session->id_session);
        $id = array('id_uangpangkal' => $this->uri->segment(3));
        $this->model_app->delete('rb_psb_uangpangkal',$id);
        redirect($this->uri->segment(1).'/uang_pangkal');
    }

    function logo_header(){
        cek_session_akses('logo_header',$this->session->id_session);
        if (isset($_POST['submit'])) {
            $config['upload_path'] = 'psb/asset/logo/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('logo')) {
                $data = array('error' => $this->upload->display_errors());
                // var_dump($data);
                $this->template->load('administrator/template','administrator/mod_ppdb/view_logowebsite', $data);
            } else {
                $hasil=$this->upload->data();
                $data = array(
                    'id_identitas_sekolah' => $this->session->sekolah,
                    'gambar' => $hasil['file_name'],
                    'id_user' => $this->session->id_session,
                    'jenis' => 'psb_header'
                );
                $header = $this->db->query("SELECT * FROM rb_header_banner WHERE jenis='psb_header' LIMIT 1;")->row_array();
                // var_dump($header);
                if(!$header){
                    $this->model_app->insert('rb_header_banner', $data);                    
                }else{
                    unlink($this->input->post('foto'));
                    $datadb = array('gambar'=>$hasil['file_name']);
                    $where = array('id_header_banner' => $this->input->post('id'));
                    $this->model_app->update('rb_header_banner', $datadb, $where);
                }
                redirect($this->uri->segment(1).'/logo_header');
            }
        } else {
            // $data['record'] = $this->model_app->view_where('rb_header_banner', array('jenis' => 'psb_header'));
            $data = $this->db->query("SELECT * FROM rb_header_banner  LIMIT 1;")->row_array();
            $this->template->load('administrator/template', 'administrator/mod_ppdb/view_logowebsite', compact('data'));
            // var_dump($data);
        }
    }

    function banner(){
        cek_session_akses('banner',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_header_banner',array('jenis'=>'psb_banner'),'id_header_banner','DESC');
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_banner/view',$data);
    }

    function tambah_banner(){
        cek_session_akses('banner',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/banner/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                $data = array('error' => $this->upload->display_errors());
                $this->template->load('administrator/template', 'administrator/mod_ppdb/mod_banner/tambah', $data);
            } else {
                $hasil=$this->upload->data();
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                    'gambar'=>$hasil['file_name'],
                    'id_user'=>$this->session->id_session,
                    'jenis'=>'psb_banner');
                $this->model_app->insert('rb_header_banner',$data);
                redirect($this->uri->segment(1).'/banner');
            }
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_banner/tambah',$data);
        }
    }

    function edit_banner(){
        cek_session_akses('banner',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/banner/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                $data = array('error' => $this->upload->display_errors());
                $this->template->load('administrator/template', 'administrator/mod_ppdb/mod_banner/edit', $data);
            } else {
                // $this->load->helper("file");
                unlink($this->input->post('foto'));
                $hasil = $this->upload->data();
                $data = array(
                    'gambar' => $hasil['file_name']                );
                $where = array('id_header_banner' => $this->input->post('id'));
                $this->model_app->update('rb_header_banner', $data,$where);
                redirect($this->uri->segment(1) . '/banner');
            }
        }else{
            $edit = $this->model_app->view_where('rb_header_banner', array('id_header_banner'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_banner/edit',$data);
        }
    }

    function delete_banner(){
        
        cek_session_akses('banner',$this->session->id_session);
        $id = array('id_header_banner' => $this->uri->segment(3));
        $id_header_banner = $this->uri->segment(3);
        $banner = $this->db->query("SELECT * FROM rb_header_banner WHERE id_header_banner='$id_header_banner' LIMIT 1;")->row_array();
        unlink("asset/banner/".$banner['gambar']);
        $this->model_app->delete('rb_header_banner',$id);
        redirect($this->uri->segment(1).'/banner');
    }

    function pendaftaran(){
        cek_session_akses('pendaftaran',$this->session->id_session);
       
        if (isset($_GET['status'])){            
            $data = array('status_seleksi'=>$this->input->get('status'));
            $where = array('id_pendaftaran' => $this->input->get('id'));
            $this->model_app->update('rb_psb_pendaftaran', $data, $where);
        }
        if ($_GET['status']=='Terima') {
            // $pendaf = $this->db->query("SELECT * FROM rb_psb_pendaftaran where id_pendaftaran='".$this->input->get('id')."' ")->result_array()[0];
            $pendaf= $this->db->query("SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.* FROM rb_psb_pendaftaran a
                                JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                                JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                                JOIN rb_agama c ON a.id_agama=c.id_agama 
                                JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                                JOIN rb_agama e ON a.agama_ibu=e.id_agama
                                where a.id_pendaftaran='$_GET[id]'")->row_array();
            $jalur = $this->db->query("SELECT pilihan1 FROM rb_psb_pendaftaran_jalur where id_pendaftaran='".$this->input->get('id')."' ")->result_array()[0];
            $data = array(                
                        'id_identitas_sekolah'=>$this->session->sekolah,
                        // 'nipd'=>$this->input->post('nipd'),
                        'password'=>md5($pendaf['pass']),
                        'nama'=>htmlentities($pendaf['nama_lengkap']),
                        'id_jenis_kelamin'=>$pendaf['id_jenis_kelamin'],
                        'nisn'=>$pendaf['no_induk'],
                        'tempat_lahir'=>$pendaf['tempat_lahir'],
                        'tanggal_lahir'=>tgl_simpan($pendaf['tanggal_lahir']),
                        // 'nik'=>$this->input->post('nik'),
                        'id_agama'=>$pendaf['id_agama'],
                        // 'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                        'alamat'=>$pendaf['alamat_siswa'],
                        // 'rt'=>$rt_rw[0],
                        // 'rw'=>$rt_rw[1],
                        'dusun'=>$pendaf['dusun'],
                        'kelurahan'=>$pendaf['kelurahan'],
                        'kecamatan'=>$pendaf['kecamatan'],
                        'kode_pos'=>$pendaf['kode_pos'],
                        // 'jenis_tinggal'=>$pendaf['jenis_tinggal'],
                        // 'alat_transportasi'=>$pendaf['alat_transportasi'],
                        'telepon'=>$pendaf['no_telpon'],
                        'hp'=>$pendaf['no_telpon'],
                        'email'=>$pendaf['email'],
                        // 'skhun'=>$pendaf['skhun'],
                        // 'penerima_kps'=>$pendaf['penerima_kps'],
                        // 'no_kps'=>$pendaf['no_kps'],
                        // 'angkatan'=>$pendaf['angkatan'],
                        // 'status_awal'=>$pendaf['status_awal'],
                        // 'status_siswa'=>$pendaf['status_siswa'],
                        'id_kelas'=>$pendaf['diterima_dikelas'],
                        'id_jurusan'=>$jalur['pilihan1'],
                        'id_sesi'=>0,
                        // 'email_sekolah'=>$pendaf['email_sekolah'],
                        // 'no_rek'=>$pendaf['no_rek'],
                        'longitude'=>$pendaf['longitude'],
                        'latitude'=>$pendaf['latitude']);
            $this->model_app->insert('rb_siswa', $data);
            redirect($this->uri->segment(1).'/pendaftaran');
        }
        
        // $jalur = $this->db->query("SELECT pilihan1 FROM rb_psb_pendaftaran_jalur where id_pendaftaran='".$this->input->get('id')."' ")->result_array();
        // print_r($jalur); exit();

        $data['tampil'] = $this->db->query("SELECT * FROM rb_psb_akun where SUBSTR(waktu_daftar,1,4)='".date('Y')."' ORDER BY id_psb_akun DESC");
        
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/view',$data);
    }

    function print_psb_print(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        $this->load->view('administrator/mod_ppdb/mod_pendaftaran/print_psb_print',$data);
    }

    function pendaftaran_detailsiswa(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        $data['s'] = $this->db->query("SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.id_identitas_sekolah
                            FROM rb_psb_pendaftaran a
                            JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                            JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                            JOIN rb_agama c ON a.id_agama=c.id_agama 
                            JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                            JOIN rb_agama e ON a.agama_ibu=e.id_agama
                            where a.id_pendaftaran='$_GET[id]'")->row_array();
        $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/detail',$data);
    }

    function pendaftaran_editsiswa(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        if (isset($_GET['hapus'])){
            $id = array('id_psb_nilai' => $this->input->get('hapus'));
            $this->model_app->delete('rb_psb_nilai',$id);
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb']);
        }

        if (isset($_POST['update_keuangan'])){
            $id_keuangan_jenis = $this->input->post('id_keuangan_jenis');
            $keuangan_jenis=implode(',',$id_keuangan_jenis);

            $data = array('beban_biaya'=>$keuangan_jenis);
            $where = array('id_pendaftaran' => $this->input->get('id'));
            $this->model_app->update('rb_psb_pendaftaran', $data, $where);
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'#biaya');

        }elseif(isset($_POST['submit'])){
            $data = array('id_pendaftaran'=>$this->input->get('id'),
                                'keterangan'=>$this->input->post('a'),
                                'nilai'=>$this->input->post('b'));
            $this->model_app->insert('rb_psb_nilai',$data);
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'#nilai');

        }elseif (isset($_POST['update_rapor'])){
            for ($i=1; $i<=4; $i++){
             if (isset($_POST['sa'.$i])){
              $mapel = cetak($_POST['mapel'.$i]);
                $semester1 = $_POST['sa'.$i];
                $semester2 = $_POST['sb'.$i];
                $semester3 = $_POST['sc'.$i];
                $semester4 = $_POST['sd'.$i];
                $semester5 = $_POST['se'.$i];

                $data = array('semester1'=>$semester1,
                              'semester2'=>$semester2,
                              'semester3'=>$semester3,
                              'semester4'=>$semester4,
                              'semester5'=>$semester5);
                $where = array('nama_mapel' => $mapel, 'id_pendaftaran'=>$this->input->post('id_pendaftaran'));
                $this->model_app->update('rb_psb_pendaftaran_rapor', $data, $where);
             }
            }
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'#rapor');
        
        }elseif (isset($_POST['update_ortu'])){
            $data = array('nama_ayah'=>$this->input->post('aaa'),
                              'pekerjaan_ayah'=>$this->input->post('bbb'),
                              'telpon_rumah_ayah'=>$this->input->post('ccc'),
                              'nama_ibu'=>$this->input->post('ddd'),
                              'pekerjaan_ibu'=>$this->input->post('eee'),
                              'telpon_rumah_ibu'=>$this->input->post('fff'));
            $where = array('id_pendaftaran'=>$this->input->post('id_pendaftaran'));
            $this->model_app->update('rb_psb_pendaftaran', $data, $where);
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'#ortu');

        }elseif (isset($_POST['update_siswa'])){
            $longitude = cetak($_POST['longitude']);
            $latitude = cetak($_POST['latitude']);
            $optional = cetak($_POST['ss']).'=='.cetak($_POST['tt']).'=='.cetak($_POST['uu']);
            $cek_no = $this->db->query("SELECT * FROM rb_psb_pendaftaran where id_aktivasi='$_POST[id_aktivasi]' AND id_pendaftaran!='$_POST[id_pendaftaran]'")->num_rows();
            if ($cek_no>=1){
                $data = array('pass'=>$this->input->post('pass'),
                                'nama'=>$this->input->post('aa'),
                                'id_jenis_kelamin'=>$this->input->post('bb'),
                                'tempat_lahir'=>$this->input->post('cc'),
                                'tanggal_lahir'=>$this->input->post('dd'),
                                'id_agama'=>$this->input->post('ee'),
                                'alamat_siswa'=>$this->input->post('ff'),
                                'no_telpon'=>$this->input->post('gg'),
                                'email'=>$this->input->post('hh'),
                                'anak_ke'=>$this->input->post('ii'),
                                'jumlah_saudara'=>$this->input->post('jj'),
                                'status_dalam_keluarga'=>$this->input->post('kk'),

                                'prestasi_akademik'=>$this->input->post('oo'),
                                'prestasi_non_akademik'=>$this->input->post('pp'),
                                'sekolah_asal'=>$this->input->post('qq'),
                                'no_induk'=>$this->input->post('rr'),
                                'lainnya'=>$optional,
                                'longitude'=>$longitude,
                                'latitude'=>$latitude);
              $status = 'err';
            }else{
              $data = array('pass'=>$this->input->post('pass'),
                                'id_aktivasi'=>$this->input->post('id_aktivasi'),
                                'nama'=>$this->input->post('aa'),
                                'id_jenis_kelamin'=>$this->input->post('bb'),
                                'tempat_lahir'=>$this->input->post('cc'),
                                'tanggal_lahir'=>$this->input->post('dd'),
                                'id_agama'=>$this->input->post('ee'),
                                'alamat_siswa'=>$this->input->post('ff'),
                                'no_telpon'=>$this->input->post('gg'),
                                'email'=>$this->input->post('hh'),
                                'anak_ke'=>$this->input->post('ii'),
                                'jumlah_saudara'=>$this->input->post('jj'),
                                'status_dalam_keluarga'=>$this->input->post('kk'),

                                'prestasi_akademik'=>$this->input->post('oo'),
                                'prestasi_non_akademik'=>$this->input->post('pp'),
                                'sekolah_asal'=>$this->input->post('qq'),
                                'no_induk'=>$this->input->post('rr'),
                                'lainnya'=>$optional,
                                'longitude'=>$longitude,
                                'latitude'=>$latitude);
              $status = 'ok';
            }
            $where = array('id_pendaftaran'=>$this->input->post('id_pendaftaran'));
            $this->model_app->update('rb_psb_pendaftaran', $data, $where);

            $data1 = array('jalur'=>$this->input->post('ll'),
                              'pilihan1'=>$this->input->post('mm'),
                              'pilihan2'=>$this->input->post('nn'));
            $where1 = array('id_pendaftaran'=>$this->input->post('id_pendaftaran'));
            $this->model_app->update('rb_psb_pendaftaran_jalur', $data1, $where1);
            redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'&status='.$status.'#siswa');
        
        }elseif (isset($_POST['update'])){
          if (trim($_POST['d'])==''){
              $data1 = array('nama_lengkap'=>$this->input->post('a'),
                              'email'=>$this->input->post('b'),
                              'no_telpon'=>$this->input->post('c'));
          }else{
              $data1 = array('nama_lengkap'=>$this->input->post('a'),
                              'email'=>$this->input->post('b'),
                              'no_telpon'=>$this->input->post('c'),
                              'password'=>md5($this->input->post('d')));
          }
            $where1 = array('id_psb_akun'=>$this->input->get('psb'));
            $this->model_app->update('rb_psb_akun', $data1, $where1);
          redirect($this->uri->segment(1).'/pendaftaran_editsiswa?id='.$_GET['id'].'&psb='.$_GET['psb'].'#akun');

        }else{
            $data['s'] = $this->db->query("SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.* FROM rb_psb_pendaftaran a
                                JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                                JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                                JOIN rb_agama c ON a.id_agama=c.id_agama 
                                JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                                JOIN rb_agama e ON a.agama_ibu=e.id_agama
                                where a.id_pendaftaran='$_GET[id]'")->row_array();
            print_r($data['s']); exit();
            $data['cl'] = $this->db->query("SELECT * FROM rb_psb_akun where id_psb_akun='$_GET[psb]'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/edit_siswa',$data);
        }
    }

    function pendaftaran_hapusnilai(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        $id = array('id_psb_nilai' => $this->uri->segment(4));
        $this->model_app->delete('rb_psb_nilai',$id);
        redirect($this->uri->segment(1).'/pendaftaran_detailsiswa/'.$this->uri->segment(3));
    }

    function pendaftaran_hapussiswa(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        $id = array('id_pendaftaran' => $this->uri->segment(3));
        $id_akun = array('id_psb_akun' => $this->uri->segment(4));
        $this->model_app->delete('rb_psb_pendaftaran',$id);
        $this->model_app->delete('rb_psb_pendaftaran_jalur',$id);
        $this->model_app->delete('rb_psb_pendaftaran_rapor',$id);
        $this->model_app->delete('rb_psb_pendaftaran_saudara',$id);
        $this->model_app->delete('rb_psb_akun',$id_akun);

        redirect($this->uri->segment(1).'/pendaftaran');
    }

    function export_siswa(){
        cek_session_akses('pendaftaran',$this->session->id_session);
        $this->load->view('administrator/mod_ppdb/mod_pendaftaran/export_siswa',$data);
    }

    function informasi_sukses(){
        cek_session_akses('informasi_sukses',$this->session->id_session);
        if (isset($_POST['update'])){
            $data = array('informasi'=>$this->input->post('b'));
            $where = array('status' => 'psb_success');
            $this->model_app->update('rb_psb_info', $data, $where);
            redirect($this->uri->segment(1).'/informasi_sukses');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_psb_info where status='psb_success'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/view_success',$data);
        }
    }

    function informasi_valid(){
        cek_session_akses('informasi_valid',$this->session->id_session);
        if (isset($_POST['update'])){
            $data = array('informasi'=>$this->input->post('b'));
            $where = array('status' => 'psb_valid');
            $this->model_app->update('rb_psb_info', $data, $where);
            redirect($this->uri->segment(1).'/informasi_valid');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_psb_info where status='psb_valid'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/view_valid',$data);
        }
    }

    function beban_biaya(){
        cek_session_akses('beban_biaya',$this->session->id_session);
        if ($_GET['hapus']){
            $id = array('id_keuangan_jenis' => $this->input->get('hapus'));
            $this->model_app->delete('rb_psb_keuangan_jenis',$id);
            redirect($this->uri->segment(1).'/beban_biaya');
        }

        if (isset($_POST['update'])){
          $id_keuangan_jenis = $this->input->post('id_keuangan_jenis');
          $keuangan_jenis=implode(',',$id_keuangan_jenis);

            $data = array('id_keuangan_jenis'=>$keuangan_jenis);
            $where = array('id_identitas_sekolah' => $this->session->sekolah);
            $this->model_app->update('rb_psb_keuangan', $data, $where);
            redirect($this->uri->segment(1).'/beban_biaya');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_psb_info where status='psb_valid'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/beban_biaya',$data);
        }
    }

    function beban_biaya_tambah(){
        cek_session_akses('beban_biaya',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'keuangan_jenis'=>$this->input->post('b'),
                                'nominal'=>$this->input->post('c'),
                                'id_coa'=>$this->input->post('d'),
                                'id_sub_coa'=>$this->input->post('e'));
            $this->model_app->insert('rb_psb_keuangan_jenis',$data);
            redirect($this->uri->segment(1).'/beban_biaya');
        }else{
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/beban_biaya_tambah',$data);
        }
    }

    function setting(){
        cek_session_akses('setting',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('formulir'=>$this->input->post('a'),
                                'id_coa'=>$this->input->post('c'),
                                'id_sub_coa'=>$this->input->post('d'),
                                'aktif'=>$this->input->post('e'));
            $where = array('id_setting' => 1);
            $this->model_app->update('rb_psb_setting', $data, $where);
            redirect($this->uri->segment(1).'/setting');
        }else{
            $data['s'] = $this->db->query("SELECT * FROM rb_psb_setting where id_setting='1'")->row_array();
            $this->template->load('administrator/template','administrator/mod_ppdb/mod_pendaftaran/setting',$data);
        }
    }
}
