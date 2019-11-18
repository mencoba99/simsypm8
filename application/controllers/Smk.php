<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smk extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
        
}

    function index(){
        redirect($this->uri->segment(1).'/home');
    }

    function reset_password(){
        if (isset($_POST['submit'])){
            $usr = $this->model_app->edit('rb_users', array('id_user' => $this->input->post('id_session')));
            if ($usr->num_rows()>=1){
                if ($this->input->post('a')==$this->input->post('b')){
                    $data = array('password'=>hash("sha512", md5($this->input->post('a'))));
                    $where = array('id_user' => $this->input->post('id_session'));
                    $this->model_app->update('rb_users', $data, $where);

                    $row = $usr->row_array();
                    $this->session->set_userdata('upload_image_file_manager',true);
                    $this->session->set_userdata(array('username'=>$row['username'],
                                       'level'=>$row['level'],
                                       'id_session'=>$row['id_user']));
                    redirect($this->uri->segment(1).'/home');
                }else{
                    $data['title'] = 'Password Tidak sama!';
                    $this->load->view('administrator/view_reset',$data);
                }
            }else{
                $data['title'] = 'Terjadi Kesalahan!';
                $this->load->view('administrator/view_reset',$data);
            }
        }else{
            $this->session->set_userdata(array('id_session'=>$this->uri->segment(3)));
            $data['title'] = 'Reset Password';
            $this->load->view('administrator/view_reset',$data);
        }
    }

    function lupapassword(){
        if (isset($_POST['lupa'])){
            $email = strip_tags($this->input->post('email'));
            $cekemail = $this->model_app->edit('rb_users', array('email' => $email));
            if ($cekemail->num_rows() <= 0){
                $data['title'] = 'Alamat email tidak ditemukan';
                $this->load->view('administrator/view_login',$data);
            }else{
                $cekemail->row_array();
                $iden = $this->model_app->edit('rb_identitas_sekolah', array('id_identitas_sekolah' => $cekemail['id_identitas_sekolah']))->row_array();
                $usr = $this->model_app->edit('rb_users', array('email' => $email))->row_array();
                $this->load->library('email');

                $tgl = date("d-m-Y H:i:s");
                $subject      = 'Lupa Password ...';
                $message      = "<html><body>
                                    <table style='margin-left:25px'>
                                        <tr><td>Halo $usr[nama_lengkap],<br>
                                        Seseorang baru saja meminta untuk mengatur ulang kata sandi Anda di <span style='color:red'>".base_url()."</span>.<br>
                                        Klik <a href='".base_url()."$iden[keyword]/reset_password/$usr[id_user]'> di sini</a> untuk mengganti kata sandi Anda.<br>
                                        Atau Anda dapat copas (Copy Paste) url dibawah ini ke address Bar Browser anda :<br>
                                        <a href='".base_url()."$iden[keyword]/reset_password/$usr[id_user]'>".base_url()."$iden[keyword]/reset_password/$usr[id_user]</a><br><br>

                                        Tidak meminta penggantian ini?<br>
                                        Jika Anda tidak meminta kata sandi baru, segera beri tahu kami.<br>
                                        Email. $iden[email], No Telp. $iden[no_telp]</td></tr>
                                    </table>
                                </body></html> \n";
                
                $this->email->from($iden['email'], $iden['nama_sekolah']);
                $this->email->to($usr['email']);
                $this->email->cc('');
                $this->email->bcc('');

                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->set_mailtype("html");
                $this->email->send();
                
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $data['title'] = 'Password terkirim ke '.$usr['email'];
                $this->load->view('administrator/view_login',$data);
            }
        }else{
            redirect('administrator');
        }
    }

    function home(){
        if ($this->session->level=='admin'){
              $this->template->load('administrator/template','administrator/home/view_home_admin');
        }elseif($this->session->level=='guru'){
          $data['users'] = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session))->row_array();
          $this->template->load('administrator/template','administrator/home/view_home_guru',$data);
        }elseif($this->session->level=='siswa'){
          $data['users'] = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->session->id_session))->row_array();
          $data['modul'] = $this->db->query("SELECT * FROM rb_siswa a JOIN users_modul b ON a.id_siswa=b.id_user where b.level='siswa' ORDER BY id_umod DESC");
          $this->template->load('administrator/template','administrator/home/view_home_siswa',$data);
        }else{
          $data['users'] = $this->model_app->view_where('rb_users',array('username'=>$this->session->username))->row_array();
          $data['modul'] = $this->db->query("SELECT * FROM rb_users a JOIN users_modul b ON a.id_user=b.id_user where b.level='user' ORDER BY id_umod DESC");
          $this->template->load('administrator/template','administrator/home/view_home_users',$data);
        }
    }

    function bikang()
    {
        $otherdb = $this->load->database('sub', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

        $query = $otherdb->select('*')->get('users');
        return var_dump($query->result_array());
    }

    function sekolah(){
        cek_session_akses('sekolah',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/logo/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $this->load->library('upload', $config);

            $this->upload->do_upload('foto1');
            $hasil1 = $this->upload->data();

            $this->upload->do_upload('foto2');
            $hasil2 = $this->upload->data();

            $cek = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            if($hasil1['file_name']==''){ $logo1 = $cek['logo1']; }else{ $logo1 = $hasil1['file_name']; }
            if($hasil2['file_name']==''){ $logo2 = $cek['logo2']; }else{ $logo2 = $hasil2['file_name']; }
            $data = array('nama_sekolah'=>$this->db->escape_str($this->input->post('a')),
                            'npsn'=>$this->db->escape_str($this->input->post('b')),
                            'nss'=>$this->db->escape_str($this->input->post('c')),
                            'alamat_sekolah'=>$this->input->post('d'),
                            'kode_pos'=>$this->db->escape_str($this->input->post('e')),
                            'no_telpon'=>$this->db->escape_str($this->input->post('f')),
                            'kelurahan'=>$this->input->post('g'),
                            'kecamatan'=>$this->db->escape_str($this->input->post('h')),
                            'kabupaten_kota'=>$this->db->escape_str($this->input->post('i')),
                            'provinsi'=>$this->db->escape_str($this->input->post('j')),
                            'website'=>$this->db->escape_str($this->input->post('k')),
                            'email'=>$this->db->escape_str($this->input->post('l')),
                            'logo1'=>$logo1,
                            'logo2'=>$logo2,
                            'tanggal_rapor1'=>$this->db->escape_str($this->input->post('tanggal_rapor1')),
                            'tanggal_rapor2'=>$this->db->escape_str($this->input->post('tanggal_rapor2')));

            $where = array('id_identitas_sekolah' => $this->session->sekolah);
            $this->model_app->update('rb_identitas_sekolah', $data, $where);
            redirect($this->uri->segment(1).'/sekolah');
        }else{
            $proses = $this->model_app->edit('rb_identitas_sekolah', array('id_identitas_sekolah' => $this->session->sekolah))->row_array();
            $data = array('s' => $proses);
            $this->template->load('administrator/template','administrator/mod_identitas/view',$data);
        }
    }

  function hitung_kkm(){
    cek_session_akses('hitung_kkm',$this->session->id_session);
    if (isset($_POST['submit'])){
      $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                      'kompleksitas_materi'=>$this->input->post('a'),
                      'kualitas_perserta_didik'=>$this->input->post('b'),
                      'guru_daya_dukung'=>$this->input->post('c'));
      $cek = $this->model_app->view_where('rb_kkm_kd',array('id_identitas_sekolah'=>$this->session->sekolah));
      if ($cek->num_rows()>=1){
        $where = array('id_identitas_sekolah' => $this->session->sekolah);
        $this->model_app->update('rb_kkm_kd', $data, $where);
      }else{
        $this->model_app->insert('rb_kkm_kd',$data);
      }
      redirect($this->uri->segment(1).'/hitung_kkm');
    }else{
      $proses = $this->model_app->edit('rb_kkm_kd', array('id_identitas_sekolah' => $this->session->sekolah))->row_array();
      $data = array('s' => $proses);
      $this->template->load('administrator/template','administrator/mod_penilaian/view_hitung_kkm',$data);
    }
  }

  function jenis_penilaian(){
    cek_session_akses('jenis_penilaian',$this->session->id_session);
    if (isset($_POST['submit'])){
      $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                      'lisan'=>$this->input->post('a'),
                      'tertulis'=>$this->input->post('b'),
                      'penugasan'=>$this->input->post('c'),
                      'uts'=>$this->input->post('cc'),
                      'akhir_semester'=>$this->input->post('d'),
                      'aktif'=>$this->input->post('f'),
                      'praktek'=>$this->input->post('v'),
                      'produk'=>$this->input->post('w'),
                      'proyek'=>$this->input->post('x'),
                      'portofolio'=>$this->input->post('y'),
                      'aktif_keterampilan'=>$this->input->post('z'));
      $cek = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah));
      if ($cek->num_rows()>=1){
        $where = array('id_identitas_sekolah' => $this->session->sekolah);
        $this->model_app->update('rb_jenis_penilaian_bobot', $data, $where);
      }else{
        $this->model_app->insert('rb_jenis_penilaian_bobot',$data);
      }
      redirect($this->uri->segment(1).'/jenis_penilaian');
    }else{
      $proses = $this->model_app->edit('rb_jenis_penilaian_bobot', array('id_identitas_sekolah' => $this->session->sekolah))->row_array();
      $data = array('s' => $proses);
      $this->template->load('administrator/template','administrator/mod_penilaian/view_jenis_penilaian',$data);
    }
  }

  // Controller Modul kegiatan_siswa
  
    function kegiatan_siswa(){
        cek_session_akses('kegiatan_siswa',$this->session->id_session);
        if ($this->session->level=='siswa'){
            $data['record'] = $this->db->query("SELECT a.*, b.nama_kelas FROM rb_siswa_kegiatan a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where b.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_kelas='".$this->session->id_kelas."'");
            $this->template->load('administrator/template','administrator/mod_siswa_kegiatan/view_siswa',$data);
        }else{
            $data['record'] = $this->db->query("SELECT a.*, b.nama_kelas FROM rb_siswa_kegiatan a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where b.id_identitas_sekolah='".$this->session->sekolah."'");
            $this->template->load('administrator/template','administrator/mod_siswa_kegiatan/view',$data);
        }
    }

    function tambah_kegiatan_siswa(){
        cek_session_akses('kegiatan_siswa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $ex1 = explode(' ', $this->input->post('b'));
            $waktu_kegiatan = tgl_simpan($ex1[0]).' '.$ex1[1];

            $data = array('id_kelas'=>$this->input->post('a'),
                            'waktu_kegiatan'=>$waktu_kegiatan,
                            'kegiatan'=>$this->input->post('c'),
                            'tempat'=>$this->input->post('d'),
                            'penanggung_jawab'=>$this->input->post('e'),
                            'durasi'=>$this->input->post('f'));
            $this->model_app->insert('rb_siswa_kegiatan',$data);
            redirect($this->uri->segment(1).'/kegiatan_siswa');
        }else{
            $this->template->load('administrator/template','administrator/mod_siswa_kegiatan/tambah');
        }
    }

    function edit_kegiatan_siswa(){
        cek_session_akses('kegiatan_siswa',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $ex1 = explode(' ', $this->input->post('b'));
            $waktu_kegiatan = tgl_simpan($ex1[0]).' '.$ex1[1];
            $data = array('id_kelas'=>$this->input->post('a'),
                            'waktu_kegiatan'=>$waktu_kegiatan,
                            'kegiatan'=>$this->input->post('c'),
                            'tempat'=>$this->input->post('d'),
                            'penanggung_jawab'=>$this->input->post('e'),
                            'durasi'=>$this->input->post('f'));
            $where = array('id_siswa_kegiatan' => $this->input->post('id'));
            $this->model_app->update('rb_siswa_kegiatan', $data, $where);
            redirect($this->uri->segment(1).'/kegiatan_siswa');
        }else{
            $edit = $this->model_app->view_where('rb_siswa_kegiatan', array('id_siswa_kegiatan'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_siswa_kegiatan/edit',$data);
        }
    }

    function delete_kegiatan_siswa(){
        cek_session_akses('kegiatan_siswa',$this->session->id_session);
        $id = array('id_siswa_kegiatan' => $this->uri->segment(3));
        $this->model_app->delete('rb_siswa_kegiatan',$id);
        redirect($this->uri->segment(1).'/kegiatan_siswa');
    }


    // Controller Modul Aspek Penilaian

    function aspek_penilaian(){
        cek_session_akses('aspek_penilaian',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_aspek',array('id_identitas_sekolah'=>$this->session->sekolah),'id_aspek','ASC');
        $this->template->load('administrator/template','administrator/mod_aspek_penilaian/view',$data);
    }

    function tambah_aspek_penilaian(){
        cek_session_akses('aspek_penilaian',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_aspek'=>$this->input->post('a'),
                            'penilaian'=>$this->input->post('b'));
            $this->model_app->insert('rb_aspek',$data);
            redirect($this->uri->segment(1).'/aspek_penilaian');
        }else{
            $this->template->load('administrator/template','administrator/mod_aspek_penilaian/tambah');
        }
    }

    function edit_aspek_penilaian(){
        cek_session_akses('aspek_penilaian',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_aspek'=>$this->input->post('a'),
                            'penilaian'=>$this->input->post('b'));
            $where = array('id_aspek' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_aspek', $data, $where);
            redirect($this->uri->segment(1).'/aspek_penilaian');
        }else{
            $edit = $this->model_app->view_where('rb_aspek', array('id_aspek'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_aspek_penilaian/edit',$data);
        }
    }

    function delete_aspek_penilaian(){
        cek_session_akses('aspek_penilaian',$this->session->id_session);
        $id = array('id_aspek' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_aspek',$id);
        redirect($this->uri->segment(1).'/aspek_penilaian');
    }


    // Controller Modul Deskripsi Penilaian Sikap

    function deskripsi_penilaian_sikap(){
        cek_session_akses('deskripsi_penilaian_sikap',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_nilai_sikap_deskripsi',array('id_identitas_sekolah'=>$this->session->sekolah),'id_nilai_sikap_deskripsi','ASC');
        $this->template->load('administrator/template','administrator/mod_deskripsi_penilaian_sikap/view',$data);
    }

    function tambah_deskripsi_penilaian_sikap(){
        cek_session_akses('deskripsi_penilaian_sikap',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'deskripsi_sikap'=>$this->input->post('a'),
                            'penilaian'=>$this->input->post('b'));
            $this->model_app->insert('rb_nilai_sikap_deskripsi',$data);
            redirect($this->uri->segment(1).'/deskripsi_penilaian_sikap');
        }else{
            $this->template->load('administrator/template','administrator/mod_deskripsi_penilaian_sikap/tambah');
        }
    }

    function edit_deskripsi_penilaian_sikap(){
        cek_session_akses('deskripsi_penilaian_sikap',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('deskripsi_sikap'=>$this->input->post('a'),
                            'penilaian'=>$this->input->post('b'));
            $where = array('id_nilai_sikap_deskripsi' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_nilai_sikap_deskripsi', $data, $where);
            redirect($this->uri->segment(1).'/deskripsi_penilaian_sikap');
        }else{
            $edit = $this->model_app->view_where('rb_nilai_sikap_deskripsi', array('id_nilai_sikap_deskripsi'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_deskripsi_penilaian_sikap/edit',$data);
        }
    }

    function delete_deskripsi_penilaian_sikap(){
        cek_session_akses('deskripsi_penilaian_sikap',$this->session->id_session);
        $id = array('id_nilai_sikap_deskripsi' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_nilai_sikap_deskripsi',$id);
        redirect($this->uri->segment(1).'/deskripsi_penilaian_sikap');
    }


    // Controller Modul Predikat KKM

    function predikat_kkm(){
        cek_session_akses('predikat_kkm',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'predikat'=>$this->input->post('a'),
                            'kkm'=>$this->input->post('b'),
                            'status'=>$this->input->post('c'));
            $this->model_app->insert('rb_kkm_raport',$data);
            redirect($this->uri->segment(1).'/predikat_kkm');
        }elseif (isset($_POST['update'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'predikat'=>$this->input->post('a'),
                            'kkm'=>$this->input->post('b'),
                            'status'=>$this->input->post('c'));
            $where = array('id_kkm_raport' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_kkm_raport', $data, $where);
            redirect($this->uri->segment(1).'/predikat_kkm');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('rb_predikat_kkm',array('id_identitas_sekolah'=>$this->session->sekolah),'id_predikat_kkm','ASC');
            $this->template->load('administrator/template','administrator/mod_predikat_kkm/view',$data);
        }
    }

    function tambah_predikat_kkm(){
        cek_session_akses('predikat_kkm',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_kkm'=>$this->input->post('c'),
                            'nilai_kkm'=>$this->input->post('d'),
                            'keterangan'=>$this->input->post('e'));
            $this->model_app->insert('rb_predikat_kkm',$data);
            redirect($this->uri->segment(1).'/predikat_kkm');
        }else{
            $this->template->load('administrator/template','administrator/mod_predikat_kkm/tambah');
        }
    }

    function edit_predikat_kkm(){
        cek_session_akses('predikat_kkm',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_kkm'=>$this->input->post('c'),
                            'nilai_kkm'=>$this->input->post('d'),
                            'keterangan'=>$this->input->post('e'));
            $where = array('id_predikat_kkm' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_predikat_kkm', $data, $where);
            redirect($this->uri->segment(1).'/predikat_kkm');
        }else{
            $edit = $this->model_app->view_where('rb_predikat_kkm', array('id_predikat_kkm'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_predikat_kkm/edit',$data);
        }
    }

    function delete_predikat_kkm(){
        cek_session_akses('predikat_kkm',$this->session->id_session);
        $id = array('id_predikat_kkm' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_predikat_kkm',$id);
        redirect($this->uri->segment(1).'/predikat_kkm');
    }

    function delete_predikat_kkm_rapor(){
        cek_session_akses('predikat_kkm',$this->session->id_session);
        $id = array('id_kkm_raport' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kkm_raport',$id);
        redirect($this->uri->segment(1).'/predikat_kkm');
    }

        // Controller Modul Predikat Sikap

    function predikat_sikap(){
        cek_session_akses('predikat_sikap',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_predikat_sikap',array('id_identitas_sekolah'=>$this->session->sekolah),'id_predikat_sikap','ASC');
        $this->template->load('administrator/template','administrator/mod_predikat_sikap/view',$data);
    }

    function tambah_predikat_sikap(){
        cek_session_akses('predikat_sikap',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_sikap'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_predikat_sikap',$data);
            redirect($this->uri->segment(1).'/predikat_sikap');
        }else{
            $this->template->load('administrator/template','administrator/mod_predikat_sikap/tambah');
        }
    }

    function edit_predikat_sikap(){
        cek_session_akses('predikat_sikap',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_sikap'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $where = array('id_predikat_sikap' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_predikat_sikap', $data, $where);
            redirect($this->uri->segment(1).'/predikat_sikap');
        }else{
            $edit = $this->model_app->view_where('rb_predikat_sikap', array('id_predikat_sikap'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_predikat_sikap/edit',$data);
        }
    }

    function delete_predikat_sikap(){
        cek_session_akses('predikat_sikap',$this->session->id_session);
        $id = array('id_predikat_sikap' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_predikat_sikap',$id);
        redirect($this->uri->segment(1).'/predikat_sikap');
    }


    // Controller Modul Kurikulum

    function kurikulum(){
        cek_session_akses('kurikulum',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_kurikulum','id_identitas_sekolah','ASC');
        $this->template->load('administrator/template','administrator/mod_kurikulum/view',$data);
    }

    function edit_kurikulum(){
        cek_session_akses('kurikulum',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_kurikulum'=>$this->db->escape_str($this->input->post('a')));
            $where = array('kode_kurikulum' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_kurikulum', $data, $where);
            redirect($this->uri->segment(1).'/kurikulum');
        }else{
            $edit = $this->model_app->view_where('rb_kurikulum', array('kode_kurikulum'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_kurikulum/edit',$data);
        }
    }

    function delete_kurikulum(){
        cek_session_akses('kurikulum',$this->session->id_session);
        $id = array('kode_kurikulum' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kurikulum',$id);
        redirect($this->uri->segment(1).'/kurikulum');
    }


    // Controller Modul Tingkat

    function tingkat(){
        cek_session_akses('tingkat',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_tingkat.* ,nama_kurikulum','rb_tingkat','rb_kurikulum','kode_kurikulum',array('rb_tingkat.id_identitas_sekolah'=>$this->session->sekolah),'id_tingkat','ASC');
        $this->template->load('administrator/template','administrator/mod_tingkat/view',$data);
    }

    function tambah_tingkat(){
        cek_session_akses('tingkat',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_tingkat'=>$this->input->post('a'),
                            'kode_kurikulum'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'),
                            'id_raport'=>$this->input->post('d'));
            $this->model_app->insert('rb_tingkat',$data);
            redirect($this->uri->segment(1).'/tingkat');
        }else{
            $kurikulum = $this->model_app->view_ordering('rb_kurikulum','kode_kurikulum','ASC');
            $data = array('kurikulum' => $kurikulum);
            $this->template->load('administrator/template','administrator/mod_tingkat/tambah',$data);
        }
    }

    function edit_tingkat(){
        cek_session_akses('tingkat',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kode_tingkat'=>$this->input->post('a'),
                            'kode_kurikulum'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'),
                            'id_raport'=>$this->input->post('d'));
            $where = array('id_tingkat' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_tingkat', $data, $where);
            redirect($this->uri->segment(1).'/tingkat');
        }else{
            $edit = $this->model_app->view_where('rb_tingkat', array('id_tingkat'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $kurikulum = $this->model_app->view_ordering('rb_kurikulum','kode_kurikulum','ASC');
            $data = array('s' => $edit,'kurikulum' => $kurikulum);
            $this->template->load('administrator/template','administrator/mod_tingkat/edit',$data);
        }
    }

    function delete_tingkat(){
        cek_session_akses('tingkat',$this->session->id_session);
        $id = array('id_tingkat' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_tingkat',$id);
        redirect($this->uri->segment(1).'/tingkat');
    }


    // Controller Modul Tahun Akademik

    function akademik(){
        cek_session_akses('akademik',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $this->template->load('administrator/template','administrator/mod_tahun_akademik/view',$data);
    }

    function aktif_akademik(){
        cek_session_akses('akademik',$this->session->id_session);
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4)=='Ya'){ $aktif = 'Tidak'; }else{ $aktif = 'Ya'; }

        $data = array('aktif'=>$aktif);
        $where = array('id_tahun_akademik' => $id,'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->update('rb_tahun_akademik', $data, $where);

        $dataa = array('aktif'=>'Tidak');
        $wheree = array('id_tahun_akademik !=' => $id,'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->update('rb_tahun_akademik', $dataa, $wheree);

        redirect($this->uri->segment(1).'/akademik');
    }

    function tambah_akademik(){
        cek_session_akses('akademik',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_tahun_akademik'=>$this->input->post('a'),
                            'nama_tahun'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'),
                            'aktif'=>$this->input->post('d'));
            $this->model_app->insert('rb_tahun_akademik',$data);
            redirect($this->uri->segment(1).'/akademik');
        }else{
            $this->template->load('administrator/template','administrator/mod_tahun_akademik/tambah');
        }
    }

    function edit_akademik(){
        cek_session_akses('akademik',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_tahun_akademik'=>$this->input->post('a'),
                            'nama_tahun'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'),
                            'aktif'=>$this->input->post('d'));
            $where = array('id_tahun_akademik' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_tahun_akademik', $data, $where);
            redirect($this->uri->segment(1).'/akademik');
        }else{
            $edit = $this->model_app->view_where('rb_tahun_akademik', array('id_tahun_akademik'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_tahun_akademik/edit',$data);
        }
    }

    function delete_akademik(){
        cek_session_akses('akademik',$this->session->id_session);
        $id = array('id_tahun_akademik' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_tahun_akademik',$id);
        redirect($this->uri->segment(1).'/akademik');
    }


    // Controller Modul Gedung

    function gedung(){
        cek_session_akses('gedung',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_gedung',array('id_identitas_sekolah'=>$this->session->sekolah),'id_gedung','ASC');
        $this->template->load('administrator/template','administrator/mod_gedung/view',$data);
    }

    function tambah_gedung(){
        cek_session_akses('gedung',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/asset_sekolah/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();         
            if ($_FILES["foto"]['name']==''){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_gedung'=>$this->input->post('a'),
                            'nama_gedung'=>$this->input->post('b'),
                            'jumlah_lantai'=>$this->input->post('c'),
                            'panjang'=>$this->input->post('d'),
                            'tinggi'=>$this->input->post('e'),
                            'lebar'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('g'),
                            'aktif'=>$this->input->post('h'));
            }else{
                 $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_gedung'=>$this->input->post('a'),
                            'nama_gedung'=>$this->input->post('b'),
                            'jumlah_lantai'=>$this->input->post('c'),
                            'panjang'=>$this->input->post('d'),
                            'tinggi'=>$this->input->post('e'),
                            'lebar'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('g'),
                            'foto'=>$hasil['file_name'],
                            'aktif'=>$this->input->post('h'));
            }
            $this->model_app->insert('rb_gedung',$data);
            redirect($this->uri->segment(1).'/gedung');
        }else{
            $this->template->load('administrator/template','administrator/mod_gedung/tambah');
        }
    }

    function edit_gedung(){
        cek_session_akses('gedung',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/asset_sekolah/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();         
            if ($_FILES["foto"]['name']==''){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_gedung'=>$this->input->post('a'),
                            'nama_gedung'=>$this->input->post('b'),
                            'jumlah_lantai'=>$this->input->post('c'),
                            'panjang'=>$this->input->post('d'),
                            'tinggi'=>$this->input->post('e'),
                            'lebar'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('g'),
                            'aktif'=>$this->input->post('h'));
            }else{
                 $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_gedung'=>$this->input->post('a'),
                            'nama_gedung'=>$this->input->post('b'),
                            'jumlah_lantai'=>$this->input->post('c'),
                            'panjang'=>$this->input->post('d'),
                            'tinggi'=>$this->input->post('e'),
                            'lebar'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('g'),
                            'foto'=>$hasil['file_name'],
                            'aktif'=>$this->input->post('h'));
            }
            $where = array('id_gedung' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_gedung', $data, $where);
            redirect($this->uri->segment(1).'/gedung');
        }else{
            $edit = $this->model_app->view_where('rb_gedung', array('id_gedung'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_gedung/edit',$data);
        }
    }

    function delete_gedung(){
        cek_session_akses('gedung',$this->session->id_session);
        $id = array('id_gedung' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_gedung',$id);
        redirect($this->uri->segment(1).'/gedung');
    }

    
    function laboratorium(){
        cek_session_akses('laboratorium',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
        $this->template->load('administrator/template','administrator/mod_jurusan/view',$data);
    }

    function ruangan(){
        cek_session_akses('ruangan',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_ruangan.* ,nama_gedung','rb_ruangan','rb_gedung','id_gedung',array('rb_gedung.id_identitas_sekolah'=>$this->session->sekolah),'id_ruangan','ASC');
        $this->template->load('administrator/template','administrator/mod_ruangan/view',$data);
    }
    
    public function import_excel_ruangan(){
        $config['upload_path'] = 'asset/ruangan/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_ruangan($this->uri->segment(3),$filename);
            $flash = "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Import data ruangan Sukses..!</strong>
                          </div>";
            $this->session->set_flashdata('data',$flash); 
            redirect($this->uri->segment(1).'/ruangan?sukses');
        }
    }

    function tambah_ruangan(){
        cek_session_akses('ruangan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/asset_sekolah/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();         
            if ($_FILES["foto"]['name']==''){
            $data = array('id_gedung'=>$this->input->post('a'),
                            'kode_ruangan'=>$this->input->post('b'),
                            'nama_ruangan'=>$this->input->post('c'),
                            'kapasitas_belajar'=>$this->input->post('d'),
                            'kapasitas_ujian'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'aktif'=>$this->input->post('g'));
            }else{
                $data = array('id_gedung'=>$this->input->post('a'),
                            'kode_ruangan'=>$this->input->post('b'),
                            'nama_ruangan'=>$this->input->post('c'),
                            'kapasitas_belajar'=>$this->input->post('d'),
                            'kapasitas_ujian'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'foto'=>$hasil['file_name'],
                            'aktif'=>$this->input->post('g'));
            }
            $this->model_app->insert('rb_ruangan',$data);
            redirect($this->uri->segment(1).'/ruangan');
        }else{
            $gedung = $this->model_app->view_where_ordering('rb_gedung',array('id_identitas_sekolah'=>$this->session->sekolah),'id_gedung','ASC');
            $data = array('gedung' => $gedung);
            $this->template->load('administrator/template','administrator/mod_ruangan/tambah',$data);
        }
    }

    function edit_ruangan(){
        cek_session_akses('ruangan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
             $config['upload_path'] = 'asset/asset_sekolah/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();
            if ($_FILES["foto"]['name']==''){            
            $data = array('id_gedung'=>$this->input->post('a'),
                            'kode_ruangan'=>$this->input->post('b'),
                            'nama_ruangan'=>$this->input->post('c'),
                            'kapasitas_belajar'=>$this->input->post('d'),
                            'kapasitas_ujian'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'aktif'=>$this->input->post('g'));
            }else{
                $data = array('id_gedung'=>$this->input->post('a'),
                            'kode_ruangan'=>$this->input->post('b'),
                            'nama_ruangan'=>$this->input->post('c'),
                            'kapasitas_belajar'=>$this->input->post('d'),
                            'kapasitas_ujian'=>$this->input->post('e'),
                            'keterangan'=>$this->input->post('f'),
                            'foto'=>$hasil['file_name'],
                            'aktif'=>$this->input->post('g'));
            }           
            $where = array('id_ruangan' => $this->input->post('id'));
            $this->model_app->update('rb_ruangan', $data, $where);
            redirect($this->uri->segment(1).'/ruangan');
        }else{
            $edit = $this->model_app->view_where('rb_ruangan', array('id_ruangan'=>$id))->row_array();
            $gedung = $this->model_app->view_where_ordering('rb_gedung',array('id_identitas_sekolah'=>$this->session->sekolah),'id_gedung','ASC');
            $data = array('s' => $edit,'gedung' => $gedung);
            $this->template->load('administrator/template','administrator/mod_ruangan/edit',$data);
        }
    }

    function delete_ruangan(){
        cek_session_akses('ruangan',$this->session->id_session);
        $id = array('id_ruangan' => $this->uri->segment(3));
        $this->model_app->delete('rb_ruangan',$id);
        redirect($this->uri->segment(1).'/ruangan');
    }


    // Controller Modul Golongan

    function golongan(){
        cek_session_akses('golongan',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_golongan','id_golongan','ASC');
        $this->template->load('administrator/template','administrator/mod_golongan/view',$data);
    }

    function tambah_golongan(){
        cek_session_akses('golongan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_golongan'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $this->model_app->insert('rb_golongan',$data);
            redirect($this->uri->segment(1).'/golongan');
        }else{
            $this->template->load('administrator/template','administrator/mod_golongan/tambah');
        }
    }

    function edit_golongan(){
        cek_session_akses('golongan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_golongan'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $where = array('id_golongan' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_golongan', $data, $where);
            redirect($this->uri->segment(1).'/golongan');
        }else{
            $edit = $this->model_app->view_where('rb_golongan', array('id_golongan'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_golongan/edit',$data);
        }
    }

    function delete_golongan(){
        cek_session_akses('golongan',$this->session->id_session);
        $id = array('id_golongan' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_golongan',$id);
        redirect($this->uri->segment(1).'/golongan');
    }


    // Controller Modul Jenis PTK

    function jenis_ptk(){
        cek_session_akses('jenis_ptk',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_jenis_ptk','id_jenis_ptk','ASC');
        $this->template->load('administrator/template','administrator/mod_jenis_ptk/view',$data);
    }

    function tambah_jenis_ptk(){
        cek_session_akses('jenis_ptk',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'jenis_ptk'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $this->model_app->insert('rb_jenis_ptk',$data);
            redirect($this->uri->segment(1).'/jenis_ptk');
        }else{
            $this->template->load('administrator/template','administrator/mod_jenis_ptk/tambah');
        }
    }

    function edit_jenis_ptk(){
        cek_session_akses('jenis_ptk',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'jenis_ptk'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $where = array('id_jenis_ptk' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_jenis_ptk', $data, $where);
            redirect($this->uri->segment(1).'/jenis_ptk');
        }else{
            $edit = $this->model_app->view_where('rb_jenis_ptk', array('id_jenis_ptk'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_jenis_ptk/edit',$data);
        }
    }

    function delete_jenis_ptk(){
        cek_session_akses('jenis_ptk',$this->session->id_session);
        $id = array('id_jenis_ptk' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_jenis_ptk',$id);
        redirect($this->uri->segment(1).'/jenis_ptk');
    }


    // Controller Modul Jurusan

    function jurusan(){
        cek_session_akses('jurusan',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
        $this->template->load('administrator/template','administrator/mod_jurusan/view',$data);
    }

    function tambah_jurusan(){
        cek_session_akses('jurusan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_guru'=>$this->input->post('aa'),
                            'kode_jurusan'=>$this->input->post('a'),
                            'nama_jurusan'=>$this->input->post('b'),
                            'nama_jurusan_en'=>$this->input->post('c'),
                            'bidang_keahlian'=>'',
                            'kompetensi_umum'=>$this->input->post('e'),
                            'kompetensi_khusus'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('i'),
                            'aktif'=>$this->input->post('j'));
            $this->model_app->insert('rb_jurusan',$data);
            redirect($this->uri->segment(1).'/jurusan');
        }else{
            $pejabat = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $data = array('pejabat' => $pejabat);
            $this->template->load('administrator/template','administrator/mod_jurusan/tambah',$data);
        }
    }

    function edit_jurusan(){
        cek_session_akses('jurusan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'id_guru'=>$this->input->post('aa'),
                            'kode_jurusan'=>$this->input->post('a'),
                            'nama_jurusan'=>$this->input->post('b'),
                            'nama_jurusan_en'=>$this->input->post('c'),
                            'bidang_keahlian'=>'',
                            'kompetensi_umum'=>$this->input->post('e'),
                            'kompetensi_khusus'=>$this->input->post('f'),
                            'keterangan'=>$this->input->post('i'),
                            'aktif'=>$this->input->post('j'));
            $where = array('id_jurusan' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_jurusan', $data, $where);
            redirect($this->uri->segment(1).'/jurusan');
        }else{
            $edit = $this->model_app->view_where('rb_jurusan', array('id_jurusan'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $pejabat = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $data = array('s' => $edit, 'pejabat' => $pejabat);
            $this->template->load('administrator/template','administrator/mod_jurusan/edit',$data);
        }
    }

    function delete_jurusan(){
        cek_session_akses('jurusan',$this->session->id_session);
        $id = array('id_jurusan' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_jurusan',$id);
        redirect($this->uri->segment(1).'/jurusan');
    }

    // Controller Modul Kelas

    function kelas(){
        cek_session_akses('kelas',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT a.id_kelas, a.kode_kelas, a.nama_kelas, a.aktif, a.nilai, b.nama_guru, c.nama_jurusan, d.nama_ruangan, e.nama_gedung, f.kode_tingkat 
                                                FROM `rb_kelas` a LEFT JOIN rb_guru b ON a.id_guru=b.id_guru 
                                                    LEFT JOIN rb_jurusan c ON a.id_jurusan=c.id_jurusan
                                                        LEFT JOIN rb_ruangan d ON a.id_ruangan=d.id_ruangan
                                                            LEFT JOIN rb_gedung e ON d.id_gedung=e.id_gedung
                                                                LEFT JOIN rb_tingkat f ON a.id_tingkat=f.id_tingkat
                                                                    where a.id_identitas_sekolah='".$this->session->sekolah."'");
        $this->template->load('administrator/template','administrator/mod_kelas/view',$data);
    }

    function tambah_kelas(){
        cek_session_akses('kelas',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_kelas'=>$this->input->post('a'),
                            'id_guru'=>$this->input->post('b'),
                            'id_jurusan'=>$this->input->post('c'),
                            'id_ruangan'=>$this->input->post('d'),
                            'id_tingkat'=>$this->input->post('e'),
                            'nama_kelas'=>$this->input->post('f'),
                            'aktif'=>$this->input->post('g'),
                            'nilai'=>$this->input->post('h'));
            $this->model_app->insert('rb_kelas',$data);
            redirect($this->uri->segment(1).'/kelas');
        }else{
            $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tingkat','ASC');
            $wali_kelas = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $ruangan = $this->model_app->view_where_ruangan();
            $data = array('tingkat' => $tingkat,'wali_kelas' => $wali_kelas,'jurusan' => $jurusan,'ruangan' => $ruangan);
            $this->template->load('administrator/template','administrator/mod_kelas/tambah',$data);
        }
    }

    function edit_kelas(){
        cek_session_akses('kelas',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_kelas'=>$this->input->post('a'),
                            'id_guru'=>$this->input->post('b'),
                            'id_jurusan'=>$this->input->post('c'),
                            'id_ruangan'=>$this->input->post('d'),
                            'id_tingkat'=>$this->input->post('e'),
                            'nama_kelas'=>$this->input->post('f'),
                            'aktif'=>$this->input->post('g'),
                            'nilai'=>$this->input->post('h'),
                            'daftar_ulang'=>$this->input->post('i'));
            $where = array('id_kelas' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_kelas', $data, $where);
            redirect($this->uri->segment(1).'/kelas');
        }else{
            $edit = $this->model_app->view_where('rb_kelas', array('id_kelas'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tingkat','ASC');
            $wali_kelas = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $ruangan = $this->model_app->view_where_ruangan();
            $data = array('s' => $edit,'tingkat' => $tingkat,'wali_kelas' => $wali_kelas,'jurusan' => $jurusan,'ruangan' => $ruangan);
            $this->template->load('administrator/template','administrator/mod_kelas/edit',$data);
        }
    }

    function delete_kelas(){
        cek_session_akses('kelas',$this->session->id_session);
        $id = array('id_kelas' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kelas',$id);
        redirect($this->uri->segment(1).'/kelas');
    }



    // Controller Modul Status Kepegawaian

    function status_kepegawaian(){
        cek_session_akses('status_kepegawaian',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_status_kepegawaian',array('id_identitas_sekolah'=>$this->session->sekolah),'id_status_kepegawaian','ASC');
        $this->template->load('administrator/template','administrator/mod_status_kepegawaian/view',$data);
    }

    function tambah_status_kepegawaian(){
        cek_session_akses('status_kepegawaian',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'status_kepegawaian'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $this->model_app->insert('rb_status_kepegawaian',$data);
            redirect($this->uri->segment(1).'/status_kepegawaian');
        }else{
            $this->template->load('administrator/template','administrator/mod_status_kepegawaian/tambah');
        }
    }

    function edit_status_kepegawaian(){
        cek_session_akses('status_kepegawaian',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'status_kepegawaian'=>$this->input->post('a'),
                            'keterangan'=>$this->input->post('b'));
            $where = array('id_status_kepegawaian' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_status_kepegawaian', $data, $where);
            redirect($this->uri->segment(1).'/status_kepegawaian');
        }else{
            $edit = $this->model_app->view_where('rb_status_kepegawaian', array('id_status_kepegawaian'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_status_kepegawaian/edit',$data);
        }
    }

    function delete_status_kepegawaian(){
        cek_session_akses('status_kepegawaian',$this->session->id_session);
        $id = array('id_status_kepegawaian' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_status_kepegawaian',$id);
        redirect($this->uri->segment(1).'/status_kepegawaian');
    }

    function unduh_siswa(){
        cek_session_akses('siswa',$this->session->id_session);
        $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'))->result_array();        
        $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC")->result_array();
        $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
        $data = array('siswa' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas);

        $this->load->view('administrator/mod_siswa/unduh_semua_siswa',$data);
    }
    // Controller Modul siswa

    function siswa(){
        cek_session_akses('siswa',$this->session->id_session);
        
        if (isset($_POST['pindahkelas'])){
          if ($this->input->post('angkatan')!='' AND $this->input->post('kelas') != ''){
            $jml = $this->model_app->view_where("rb_siswa", array('id_kelas'=>$this->input->post('kelas'),'angkatan'=>$this->input->post('angkatan')))->num_rows();
          }elseif ($this->input->post('angkatan')=='' AND $this->input->post('kelas') != ''){
            $jml = $this->model_app->view_where("rb_siswa", array('id_kelas'=>$this->input->post('kelas')))->num_rows();
          }elseif ($this->input->post('angkatan')!='' AND $this->input->post('kelas') == ''){
            $jml = $jml = $this->model_app->view_where("rb_siswa", array('angkatan'=>$this->input->post('angkatan')))->num_rows();
          }

           $kelas = $this->input->post('kelaspindah');
           $angkatan = $this->input->post('angkatanpindah');
           for ($i=0; $i<=$jml; $i++){
             if (isset($_POST['pilih'.$i])){
                $id_siswa = $_POST['pilih'.$i];
                if ($angkatan != '' AND $kelas != ''){
                  $data = array('angkatan'=>$angkatan,
                                'id_kelas'=>$kelas);
                }elseif ($angkatan == '' AND $kelas != ''){
                  $data = array('id_kelas'=>$kelas);
                }elseif ($angkatan != '' AND $kelas == ''){
                  $data = array('angkatan'=>$angkatan);
                }
                $where = array('id_siswa' => $id_siswa,'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_siswa', $data, $where);
             }
           }
           redirect($this->uri->segment(1).'/siswa?angkatan='.$this->input->post('angkatanpindah').'&kelas='.$this->input->post('kelaspindah'));
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_siswa/view',$data);
        }
    }
    
    function daftar_siswa(){
        cek_session_akses('daftar_siswa',$this->session->id_session);
        $this->template->load('administrator/template','administrator/mod_siswa/view_daftar_ulang',$data);
    }
    
    function daftar_ulang(){
        cek_session_akses('daftar_ulang',$this->session->id_session);
        $cek = $this->db->query("SELECT * FROM rb_siswa_temp where id_siswa='".$this->session->id_session."'");
        if (isset($_POST['submit'])){
            if ($cek->num_rows()<=0){
                $this->db->query("INSERT INTO rb_siswa_temp VALUES('".$this->session->id_session."','0','$_POST[nama_siswa]','$_POST[id_jenis_kelamin]','$_POST[nisn]','$_POST[nik]','$_POST[tempat_lahir]','$_POST[tanggal_lahir]','$_POST[no_reg_akta]','$_POST[id_agama]','$_POST[kewarganegaraan]','$_POST[tinggi_badan]','$_POST[berat_badan]',
                '$_POST[id_jurusan]','$_POST[asal_sekolah]','$_POST[diterima_pada]','$_POST[keb_khusus]','$_POST[rt_rw]','$_POST[nama_dusun]','$_POST[desa_kelurahan]','$_POST[kecamatan]','$_POST[kode_pos]','$_POST[lintang]','$_POST[bujur]','$_POST[tempat_tinggal]','$_POST[anak_ke]','$_POST[penerima_kps]','$_POST[usulan_sekolah]','$_POST[penerima_kip]','$_POST[no_kip]',
                '$_POST[nama_di_kip]','$_POST[terima_kartu_kip]','$_POST[nama_ayah]','$_POST[nik_ayah]','$_POST[tahun_lahir_ayah]','$_POST[pendidikan_ayah]','$_POST[pekerjaan_ayah]','$_POST[penghasilan_ayah]','$_POST[keb_khusus_ayah]','$_POST[nama_ibu]','$_POST[nik_ibu]','$_POST[tahun_lahir_ibu]','$_POST[pendidikan_ibu]','$_POST[pekerjaan_ibu]','$_POST[penghasilan_ibu]','$_POST[keb_khusus_ibu]','$_POST[nama_wali]',
                '$_POST[nik_wali]','$_POST[tahun_lahir_wali]','$_POST[pendidikan_wali]','$_POST[pekerjaan_wali]','$_POST[hubungan_wali]','$_POST[telp_rumah_wali]','$_POST[no_hp_wali]','$_POST[sumber_dana]','".date('Y-m-d H:i:s')."')");
            
                redirect($this->uri->segment(1).'/daftar_ulang');
            }elseif($cek->num_rows()>=1){
                $this->db->query("UPDATE rb_siswa_temp SET nama_siswa='$_POST[nama_siswa]',
                                                                    id_jenis_kelamin='$_POST[id_jenis_kelamin]',
                                                                    nisn='$_POST[nisn]',
                                                                    nik='$_POST[nik]',
                                                                    tempat_lahir='$_POST[tempat_lahir]',
                                                                    tanggal_lahir='$_POST[tanggal_lahir]',
                                                                    no_reg_akta='$_POST[no_reg_akta]',
                                                                    id_agama='$_POST[id_agama]',
                                                                    kewarganegaraan='$_POST[kewarganegaraan]',
                                                                    tinggi_badan='$_POST[tinggi_badan]',
                                                                    berat_badan='$_POST[berat_badan]',
                                                                    id_jurusan='$_POST[id_jurusan]',
                                                                    asal_sekolah='$_POST[asal_sekolah]',
                                                                    diterima_pada='$_POST[diterima_pada]',
                                                                    keb_khusus='$_POST[keb_khusus]',
                                                                    rt_rw='$_POST[rt_rw]',
                                                                    nama_dusun='$_POST[nama_dusun]',
                                                                    desa_kelurahan='$_POST[desa_kelurahan]',
                                                                    kecamatan='$_POST[kecamatan]',
                                                                    kode_pos='$_POST[kode_pos]',
                                                                    lintang='$_POST[lintang]',
                                                                    bujur='$_POST[bujur]',
                                                                    tempat_tinggal='$_POST[tempat_tinggal]',
                                                                    anak_ke='$_POST[anak_ke]',
                                                                    penerima_kps='$_POST[penerima_kps]',
                                                                    usulan_sekolah='$_POST[usulan_sekolah]',
                                                                    penerima_kip='$_POST[penerima_kip]',
                                                                    no_kip='$_POST[no_kip]',
                                                                    nama_di_kip='$_POST[nama_di_kip]',
                                                                    terima_kartu_kip='$_POST[terima_kartu_kip]',
                                                                    nama_ayah='$_POST[nama_ayah]',
                                                                    nik_ayah='$_POST[nik_ayah]',
                                                                    tahun_lahir_ayah='$_POST[tahun_lahir_ayah]',
                                                                    pendidikan_ayah='$_POST[pendidikan_ayah]',
                                                                    pekerjaan_ayah='$_POST[pekerjaan_ayah]',
                                                                    penghasilan_ayah='$_POST[penghasilan_ayah]',
                                                                    keb_khusus_ayah='$_POST[keb_khusus_ayah]',
                                                                    nama_ibu='$_POST[nama_ibu]',
                                                                    nik_ibu='$_POST[nik_ibu]',
                                                                    tahun_lahir_ibu='$_POST[tahun_lahir_ibu]',
                                                                    pendidikan_ibu='$_POST[pendidikan_ibu]',
                                                                    pekerjaan_ibu='$_POST[pekerjaan_ibu]',
                                                                    penghasilan_ibu='$_POST[penghasilan_ibu]',
                                                                    keb_khusus_ibu='$_POST[keb_khusus_ibu]',
                                                                    nama_wali='$_POST[nama_wali]',
                                                                    nik_wali='$_POST[nik_wali]',
                                                                    tahun_lahir_wali='$_POST[tahun_lahir_wali]',
                                                                    pendidikan_wali='$_POST[pendidikan_wali]',
                                                                    pekerjaan_wali='$_POST[pekerjaan_wali]',
                                                                    hubungan_wali='$_POST[hubungan_wali]',
                                                                    telp_rumah_wali='$_POST[telp_rumah_wali]',
                                                                    no_hp_wali='$_POST[no_hp_wali]',
                                                                    sumber_dana='$_POST[sumber_dana]' where id_siswa = '".$this->session->id_session."'");
            }
        redirect($this->uri->segment(1).'/daftar_ulang');
        }else{
            $this->template->load('administrator/template','administrator/mod_siswa/siswa_daftar_ulang',$data);
        }
    }
    
    function daftar_siswa_tambah(){
        cek_session_akses('daftar_siswa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $this->db->query("INSERT INTO rb_siswa_temp VALUES('','0','$_POST[nama_siswa]','$_POST[id_jenis_kelamin]','$_POST[nisn]','$_POST[nik]','$_POST[tempat_lahir]','$_POST[tanggal_lahir]','$_POST[no_reg_akta]','$_POST[id_agama]','$_POST[kewarganegaraan]','$_POST[tinggi_badan]','$_POST[berat_badan]',
            '$_POST[id_jurusan]','$_POST[asal_sekolah]','$_POST[diterima_pada]','$_POST[keb_khusus]','$_POST[rt_rw]','$_POST[nama_dusun]','$_POST[desa_kelurahan]','$_POST[kecamatan]','$_POST[kode_pos]','$_POST[lintang]','$_POST[bujur]','$_POST[tempat_tinggal]','$_POST[anak_ke]','$_POST[penerima_kps]','$_POST[usulan_sekolah]','$_POST[penerima_kip]','$_POST[no_kip]',
            '$_POST[nama_di_kip]','$_POST[terima_kartu_kip]','$_POST[nama_ayah]','$_POST[nik_ayah]','$_POST[tahun_lahir_ayah]','$_POST[pendidikan_ayah]','$_POST[pekerjaan_ayah]','$_POST[penghasilan_ayah]','$_POST[keb_khusus_ayah]','$_POST[nama_ibu]','$_POST[nik_ibu]','$_POST[tahun_lahir_ibu]','$_POST[pendidikan_ibu]','$_POST[pekerjaan_ibu]','$_POST[penghasilan_ibu]','$_POST[keb_khusus_ibu]','$_POST[nama_wali]',
            '$_POST[nik_wali]','$_POST[tahun_lahir_wali]','$_POST[pendidikan_wali]','$_POST[pekerjaan_wali]','$_POST[hubungan_wali]','$_POST[telp_rumah_wali]','$_POST[no_hp_wali]','$_POST[sumber_dana]','".date('Y-m-d H:i:s')."')");
        
            redirect($this->uri->segment(1).'/daftar_siswah');
        }else{
            $this->template->load('administrator/template','administrator/mod_siswa/tambah_daftar_ulang',$data);
        }
    }
    
    function daftar_siswa_edit(){
        cek_session_akses('daftar_siswa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $this->db->query("UPDATE rb_siswa_temp SET nama_siswa='$_POST[nama_siswa]',
                                                                id_jenis_kelamin='$_POST[id_jenis_kelamin]',
                                                                nisn='$_POST[nisn]',
                                                                nik='$_POST[nik]',
                                                                tempat_lahir='$_POST[tempat_lahir]',
                                                                tanggal_lahir='$_POST[tanggal_lahir]',
                                                                no_reg_akta='$_POST[no_reg_akta]',
                                                                id_agama='$_POST[id_agama]',
                                                                kewarganegaraan='$_POST[kewarganegaraan]',
                                                                tinggi_badan='$_POST[tinggi_badan]',
                                                                berat_badan='$_POST[berat_badan]',
                                                                id_jurusan='$_POST[id_jurusan]',
                                                                asal_sekolah='$_POST[asal_sekolah]',
                                                                diterima_pada='$_POST[diterima_pada]',
                                                                keb_khusus='$_POST[keb_khusus]',
                                                                rt_rw='$_POST[rt_rw]',
                                                                nama_dusun='$_POST[nama_dusun]',
                                                                desa_kelurahan='$_POST[desa_kelurahan]',
                                                                kecamatan='$_POST[kecamatan]',
                                                                kode_pos='$_POST[kode_pos]',
                                                                lintang='$_POST[lintang]',
                                                                bujur='$_POST[bujur]',
                                                                tempat_tinggal='$_POST[tempat_tinggal]',
                                                                anak_ke='$_POST[anak_ke]',
                                                                penerima_kps='$_POST[penerima_kps]',
                                                                usulan_sekolah='$_POST[usulan_sekolah]',
                                                                penerima_kip='$_POST[penerima_kip]',
                                                                no_kip='$_POST[no_kip]',
                                                                nama_di_kip='$_POST[nama_di_kip]',
                                                                terima_kartu_kip='$_POST[terima_kartu_kip]',
                                                                nama_ayah='$_POST[nama_ayah]',
                                                                nik_ayah='$_POST[nik_ayah]',
                                                                tahun_lahir_ayah='$_POST[tahun_lahir_ayah]',
                                                                pendidikan_ayah='$_POST[pendidikan_ayah]',
                                                                pekerjaan_ayah='$_POST[pekerjaan_ayah]',
                                                                penghasilan_ayah='$_POST[penghasilan_ayah]',
                                                                keb_khusus_ayah='$_POST[keb_khusus_ayah]',
                                                                nama_ibu='$_POST[nama_ibu]',
                                                                nik_ibu='$_POST[nik_ibu]',
                                                                tahun_lahir_ibu='$_POST[tahun_lahir_ibu]',
                                                                pendidikan_ibu='$_POST[pendidikan_ibu]',
                                                                pekerjaan_ibu='$_POST[pekerjaan_ibu]',
                                                                penghasilan_ibu='$_POST[penghasilan_ibu]',
                                                                keb_khusus_ibu='$_POST[keb_khusus_ibu]',
                                                                nama_wali='$_POST[nama_wali]',
                                                                nik_wali='$_POST[nik_wali]',
                                                                tahun_lahir_wali='$_POST[tahun_lahir_wali]',
                                                                pendidikan_wali='$_POST[pendidikan_wali]',
                                                                pekerjaan_wali='$_POST[pekerjaan_wali]',
                                                                hubungan_wali='$_POST[hubungan_wali]',
                                                                telp_rumah_wali='$_POST[telp_rumah_wali]',
                                                                no_hp_wali='$_POST[no_hp_wali]',
                                                                sumber_dana='$_POST[sumber_dana]' where id_siswa = '$_POST[id_siswa]'");
        
            redirect($this->uri->segment(1).'/daftar_siswa');
        }else{
            $this->template->load('administrator/template','administrator/mod_siswa/edit_daftar_ulang',$data);
        }
    }
    
    function daftar_siswa_print(){
        $this->load->view('administrator/mod_siswa/print_daftar_ulang',$data);
    }
    
    function daftar_siswa_delete(){
        cek_session_akses('daftar_siswa',$this->session->id_session);
        $id = array('id_siswa' => $this->uri->segment(3));
        $this->model_app->delete('rb_siswa_temp',$id);
        redirect($this->uri->segment(1).'/daftar_siswa');
    }

    function siswa_lulus(){
        cek_session_akses('siswa',$this->session->id_session);
        if (isset($_POST['pindahkelas'])){
          if ($this->input->post('angkatan')!='' AND $this->input->post('kelas') != ''){
            $jml = $this->model_app->view_where("rb_siswa", array('id_kelas'=>$this->input->post('kelas'),'angkatan'=>$this->input->post('angkatan')))->num_rows();
          }elseif ($this->input->post('angkatan')=='' AND $this->input->post('kelas') != ''){
            $jml = $this->model_app->view_where("rb_siswa", array('id_kelas'=>$this->input->post('kelas')))->num_rows();
          }elseif ($this->input->post('angkatan')!='' AND $this->input->post('kelas') == ''){
            $jml = $jml = $this->model_app->view_where("rb_siswa", array('angkatan'=>$this->input->post('angkatan')))->num_rows();
          }

            $ex = explode(' ',$this->input->post('waktu'));
            $waktu = tgl_simpan($ex[0]).' '.$ex[1];
           for ($i=0; $i<=$jml; $i++){
             if (isset($_POST['pilih'.$i])){
                $kelulusan = $_POST['pilih'.$i];
                $id_siswa = $_POST['siswa'.$i];
                $cek = $this->db->query("SELECT * FROM rb_siswa_kelulusan where id_identitas_sekolah='".$this->session->sekolah."' AND id_siswa='$id_siswa'")->num_rows();
                
                  $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_siswa'=>$id_siswa,
                                'status'=>$kelulusan,
                                'waktu_lulus'=>$waktu);
                if ($cek>0){
                  $where = array('id_siswa'=>$id_siswa,'id_identitas_sekolah'=>$this->session->sekolah);
                  $this->model_app->update('rb_siswa_kelulusan', $data, $where);  
                }else{
                  $this->model_app->insert('rb_siswa_kelulusan',$data);
                }
             }
           }
           
           $dataket = array('id_identitas_sekolah'=>$this->session->sekolah,
                         'keterangan_lulus'=>$this->input->post('lulus'),
                         'keterangan_tidaklulus'=>$this->input->post('tidaklulus'),
                         'waktu_pengumuman'=>$waktu);
           $whereket = array('id_identitas_sekolah'=>$this->session->sekolah);
           $this->model_app->update('rb_siswa_kelulusan_ket', $dataket, $whereket);  
                  
           redirect($this->uri->segment(1).'/siswa_lulus?angkatan='.$this->input->post('angkatan').'&kelas='.$this->input->post('kelas'));
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_siswa/view_lulus',$data);
        }
    }

    function tambah_siswa(){
        cek_session_akses('siswa',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_siswa/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                $rt_rw = explode('/',$this->input->post('rt_rw'));
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nipd'=>$this->input->post('nipd'),
                                'password'=>md5($this->input->post('password')),
                                'nama'=>htmlentities($this->input->post('nama')),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'nisn'=>$this->input->post('nisn'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                'alamat'=>$this->input->post('alamat'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'dusun'=>$this->input->post('dusun'),
                                'kelurahan'=>$this->input->post('kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'skhun'=>$this->input->post('skhun'),
                                'penerima_kps'=>$this->input->post('penerima_kps'),
                                'no_kps'=>$this->input->post('no_kps'),
                                'angkatan'=>$this->input->post('angkatan'),
                                'status_awal'=>$this->input->post('status_awal'),
                                'status_siswa'=>$this->input->post('status_siswa'),
                                'id_kelas'=>$this->input->post('id_kelas'),
                                'id_jurusan'=>$this->input->post('id_jurusan'),
                                'id_sesi'=>0,
                                'email_sekolah'=>$this->input->post('email_sekolah'),
                                'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude'));
            }else{
                $rt_rw = explode('/',$this->input->post('rt_rw'));
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nipd'=>$this->input->post('nipd'),
                                'password'=>md5($this->input->post('password')),
                                'nama'=>htmlentities($this->input->post('nama')),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'nisn'=>$this->input->post('nisn'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                'alamat'=>$this->input->post('alamat'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'dusun'=>$this->input->post('dusun'),
                                'kelurahan'=>$this->input->post('kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'skhun'=>$this->input->post('skhun'),
                                'penerima_kps'=>$this->input->post('penerima_kps'),
                                'no_kps'=>$this->input->post('no_kps'),
                                'foto'=>$hasil['file_name'],
                                'angkatan'=>$this->input->post('angkatan'),
                                'status_awal'=>$this->input->post('status_awal'),
                                'status_siswa'=>$this->input->post('status_siswa'),
                                'id_kelas'=>$this->input->post('id_kelas'),
                                'id_jurusan'=>$this->input->post('id_jurusan'),
                                'id_sesi'=>0,
                                'email_sekolah'=>$this->input->post('email_sekolah'),
                                'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude'));
            }
            $this->model_app->insert('rb_siswa',$data);
            redirect($this->uri->segment(1).'/siswa');
        }else{
            $jk = $this->model_app->view('rb_jenis_kelamin');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $agama = $this->model_app->view('rb_agama');
            $data = array('jk' => $jk,'kelas' => $kelas,'jurusan' => $jurusan,'agama' => $agama);
            $this->template->load('administrator/template','administrator/mod_siswa/tambah',$data);
        }
    }

    function edit_siswa(){
        cek_session_akses('siswa',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['update1'])){
            $config['upload_path'] = 'asset/foto_siswa/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();
            if ($_FILES["foto"]['name']==''){
                if (trim($this->input->post('password'))!=''){
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'nipd'=>$this->input->post('nipd'),
                                    'password'=>md5($this->input->post('password')),
                                    'nama'=>htmlentities($this->input->post('nama')),
                                    'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                    'nisn'=>$this->input->post('nisn'),
                                    'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                    'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                    'nik'=>$this->input->post('nik'),
                                    'id_agama'=>$this->input->post('id_agama'),
                                    'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                    'alamat'=>$this->input->post('alamat'),
                                    'rt'=>$rt_rw[0],
                                    'rw'=>$rt_rw[1],
                                    'dusun'=>$this->input->post('dusun'),
                                    'kelurahan'=>$this->input->post('kelurahan'),
                                    'kecamatan'=>$this->input->post('kecamatan'),
                                    'kode_pos'=>$this->input->post('kode_pos'),
                                    'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                    'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                    'telepon'=>$this->input->post('telepon'),
                                    'hp'=>$this->input->post('hp'),
                                    'email'=>$this->input->post('email'),
                                    'skhun'=>$this->input->post('skhun'),
                                    'penerima_kps'=>$this->input->post('penerima_kps'),
                                    'no_kps'=>$this->input->post('no_kps'),
                                    'angkatan'=>$this->input->post('angkatan'),
                                    'status_awal'=>$this->input->post('status_awal'),
                                    'status_siswa'=>$this->input->post('status_siswa'),
                                    'id_kelas'=>$this->input->post('id_kelas'),
                                    'id_jurusan'=>$this->input->post('id_jurusan'),
                                    'id_sesi'=>0,
                                    'email_sekolah'=>$this->input->post('email_sekolah'),
                                    'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude'));
                }else{
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'nipd'=>$this->input->post('nipd'),
                                    'nama'=>htmlentities($this->input->post('nama')),
                                    'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                    'nisn'=>$this->input->post('nisn'),
                                    'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                    'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                    'nik'=>$this->input->post('nik'),
                                    'id_agama'=>$this->input->post('id_agama'),
                                    'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                    'alamat'=>$this->input->post('alamat'),
                                    'rt'=>$rt_rw[0],
                                    'rw'=>$rt_rw[1],
                                    'dusun'=>$this->input->post('dusun'),
                                    'kelurahan'=>$this->input->post('kelurahan'),
                                    'kecamatan'=>$this->input->post('kecamatan'),
                                    'kode_pos'=>$this->input->post('kode_pos'),
                                    'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                    'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                    'telepon'=>$this->input->post('telepon'),
                                    'hp'=>$this->input->post('hp'),
                                    'email'=>$this->input->post('email'),
                                    'skhun'=>$this->input->post('skhun'),
                                    'penerima_kps'=>$this->input->post('penerima_kps'),
                                    'no_kps'=>$this->input->post('no_kps'),
                                    'angkatan'=>$this->input->post('angkatan'),
                                    'status_awal'=>$this->input->post('status_awal'),
                                    'status_siswa'=>$this->input->post('status_siswa'),
                                    'id_kelas'=>$this->input->post('id_kelas'),
                                    'id_jurusan'=>$this->input->post('id_jurusan'),
                                    'id_sesi'=>0,
                                    'email_sekolah'=>$this->input->post('email_sekolah'),
                                    'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude')); 
                }
            }else{
                if (trim($this->input->post('password'))!=''){
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'nipd'=>$this->input->post('nipd'),
                                    'password'=>md5($this->input->post('password')),
                                    'nama'=>htmlentities($this->input->post('nama')),
                                    'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                    'nisn'=>$this->input->post('nisn'),
                                    'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                    'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                    'nik'=>$this->input->post('nik'),
                                    'id_agama'=>$this->input->post('id_agama'),
                                    'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                    'alamat'=>$this->input->post('alamat'),
                                    'rt'=>$rt_rw[0],
                                    'rw'=>$rt_rw[1],
                                    'dusun'=>$this->input->post('dusun'),
                                    'kelurahan'=>$this->input->post('kelurahan'),
                                    'kecamatan'=>$this->input->post('kecamatan'),
                                    'kode_pos'=>$this->input->post('kode_pos'),
                                    'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                    'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                    'telepon'=>$this->input->post('telepon'),
                                    'hp'=>$this->input->post('hp'),
                                    'email'=>$this->input->post('email'),
                                    'skhun'=>$this->input->post('skhun'),
                                    'penerima_kps'=>$this->input->post('penerima_kps'),
                                    'no_kps'=>$this->input->post('no_kps'),
                                    'foto'=>$hasil['file_name'],
                                    'angkatan'=>$this->input->post('angkatan'),
                                    'status_awal'=>$this->input->post('status_awal'),
                                    'status_siswa'=>$this->input->post('status_siswa'),
                                    'id_kelas'=>$this->input->post('id_kelas'),
                                    'id_jurusan'=>$this->input->post('id_jurusan'),
                                    'id_sesi'=>0,
                                    'email_sekolah'=>$this->input->post('email_sekolah'),
                                    'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude'));
                }else{
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'nipd'=>$this->input->post('nipd'),
                                    'nama'=>htmlentities($this->input->post('nama')),
                                    'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                    'nisn'=>$this->input->post('nisn'),
                                    'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                    'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                    'nik'=>$this->input->post('nik'),
                                    'id_agama'=>$this->input->post('id_agama'),
                                    'kebutuhan_khusus'=>$this->input->post('kebutuhan_khusus'),
                                    'alamat'=>$this->input->post('alamat'),
                                    'rt'=>$rt_rw[0],
                                    'rw'=>$rt_rw[1],
                                    'dusun'=>$this->input->post('dusun'),
                                    'kelurahan'=>$this->input->post('kelurahan'),
                                    'kecamatan'=>$this->input->post('kecamatan'),
                                    'kode_pos'=>$this->input->post('kode_pos'),
                                    'jenis_tinggal'=>$this->input->post('jenis_tinggal'),
                                    'alat_transportasi'=>$this->input->post('alat_transportasi'),
                                    'telepon'=>$this->input->post('telepon'),
                                    'hp'=>$this->input->post('hp'),
                                    'email'=>$this->input->post('email'),
                                    'skhun'=>$this->input->post('skhun'),
                                    'penerima_kps'=>$this->input->post('penerima_kps'),
                                    'no_kps'=>$this->input->post('no_kps'),
                                    'foto'=>$hasil['file_name'],
                                    'angkatan'=>$this->input->post('angkatan'),
                                    'status_awal'=>$this->input->post('status_awal'),
                                    'status_siswa'=>$this->input->post('status_siswa'),
                                    'id_kelas'=>$this->input->post('id_kelas'),
                                    'id_jurusan'=>$this->input->post('id_jurusan'),
                                    'id_sesi'=>0,
                                    'email_sekolah'=>$this->input->post('email_sekolah'),
                                    'no_rek'=>$this->input->post('no_rek'),
                                'longitude'=>$this->input->post('longitude'),
                                'latitude'=>$this->input->post('latitude')); 
                }
            }
            $where = array('id_siswa' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_siswa', $data, $where);
            redirect($this->uri->segment(1).'/edit_siswa/'.$this->input->post('id'));

        }elseif (isset($_POST['update2'])){
            $data = array('nama_ayah'=>$this->input->post('nama_ayah'),
                            'tahun_lahir_ayah'=>$this->input->post('tahun_lahir_ayah'),
                            'pendidikan_ayah'=>$this->input->post('pendidikan_ayah'),
                            'pekerjaan_ayah'=>$this->input->post('pekerjaan_ayah'),
                            'penghasilan_ayah'=>$this->input->post('penghasilan_ayah'),
                            'kebutuhan_khusus_ayah'=>$this->input->post('kebutuhan_khusus_ayah'),
                            'no_telpon_ayah'=>$this->input->post('no_telpon_ayah'),
                            'nama_ibu'=>$this->input->post('nama_ibu'),
                            'tahun_lahir_ibu'=>$this->input->post('tahun_lahir_ibu'),
                            'pendidikan_ibu'=>$this->input->post('pendidikan_ibu'),
                            'pekerjaan_ibu'=>$this->input->post('pekerjaan_ibu'),
                            'penghasilan_ibu'=>$this->input->post('penghasilan_ibu'),
                            'kebutuhan_khusus_ibu'=>$this->input->post('kebutuhan_khusus_ibu'),
                            'no_telpon_ibu'=>$this->input->post('no_telpon_ibu'),
                            'nama_wali'=>$this->input->post('nama_wali'),
                            'tahun_lahir_wali'=>$this->input->post('tahun_lahir_wali'),
                            'pendidikan_wali'=>$this->input->post('pendidikan_wali'),
                            'pekerjaan_wali'=>$this->input->post('pekerjaan_wali'),
                            'penghasilan_wali'=>$this->input->post('penghasilan_wali'));
            $where = array('id_siswa' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_siswa', $data, $where);
            
            $cek_ortu = $this->model_app->view_where('rb_siswa_ortu',array('id_siswa'=>$this->input->post('id')));
            if ($cek_ortu->num_rows() >=1){
                if ($this->input->post('password_ortu')!=''){
                    $data_ortu = array('id_siswa'=>$this->input->post('id'),
                            'email'=>$this->input->post('email_ortu'),
                            'password'=>md5($this->input->post('password_ortu')),
                            'tempat_lahir_ayah'=>$this->input->post('tempat_lahir_ayah'),
                            'nama_agama_ayah'=>$this->input->post('nama_agama_ayah'),
                            'alamat_ayah'=>$this->input->post('alamat_ayah'),
                            'tempat_lahir_ibu'=>$this->input->post('tempat_lahir_ibu'),
                            'nama_agama_ibu'=>$this->input->post('nama_agama_ibu'),
                            'alamat_ibu'=>$this->input->post('alamat_ibu'),
                            'anak_ke'=>$this->input->post('anak_ke'),
                            'jumlah_saudara'=>$this->input->post('jumlah_saudara'),
                            'sekolah_asal'=>$this->input->post('sekolah_asal'),
                            'terima_dikelas'=>$this->input->post('terima_dikelas'),
                            'terima_tanggal'=>$this->input->post('terima_tanggal'),
                            'status_anak'=>$this->input->post('status_anak'),
                            'alamat_wali'=>$this->input->post('alamat_wali'),
                            'no_telpon_wali'=>$this->input->post('no_telpon_wali'));
                }else{
                    $data_ortu = array('id_siswa'=>$this->input->post('id'),
                            'email'=>$this->input->post('email_ortu'),
                            'tempat_lahir_ayah'=>$this->input->post('tempat_lahir_ayah'),
                            'nama_agama_ayah'=>$this->input->post('nama_agama_ayah'),
                            'alamat_ayah'=>$this->input->post('alamat_ayah'),
                            'tempat_lahir_ibu'=>$this->input->post('tempat_lahir_ibu'),
                            'nama_agama_ibu'=>$this->input->post('nama_agama_ibu'),
                            'alamat_ibu'=>$this->input->post('alamat_ibu'),
                            'anak_ke'=>$this->input->post('anak_ke'),
                            'jumlah_saudara'=>$this->input->post('jumlah_saudara'),
                            'sekolah_asal'=>$this->input->post('sekolah_asal'),
                            'terima_dikelas'=>$this->input->post('terima_dikelas'),
                            'terima_tanggal'=>$this->input->post('terima_tanggal'),
                            'status_anak'=>$this->input->post('status_anak'),
                            'alamat_wali'=>$this->input->post('alamat_wali'),
                            'no_telpon_wali'=>$this->input->post('no_telpon_wali'));
                }
                $where_ortu = array('id_siswa' => $this->input->post('id'));
                $this->model_app->update('rb_siswa_ortu', $data_ortu, $where_ortu);
            }else{
                $data_ortu = array('id_siswa'=>$this->input->post('id'),
                            'email'=>$this->input->post('email_ortu'),
                            'password'=>md5($this->input->post('password_ortu')),
                            'tempat_lahir_ayah'=>$this->input->post('tempat_lahir_ayah'),
                            'nama_agama_ayah'=>$this->input->post('nama_agama_ayah'),
                            'alamat_ayah'=>$this->input->post('alamat_ayah'),
                            'tempat_lahir_ibu'=>$this->input->post('tempat_lahir_ibu'),
                            'nama_agama_ibu'=>$this->input->post('nama_agama_ibu'),
                            'alamat_ibu'=>$this->input->post('alamat_ibu'),
                            'anak_ke'=>$this->input->post('anak_ke'),
                            'jumlah_saudara'=>$this->input->post('jumlah_saudara'),
                            'sekolah_asal'=>$this->input->post('sekolah_asal'),
                            'terima_dikelas'=>$this->input->post('terima_dikelas'),
                            'terima_tanggal'=>$this->input->post('terima_tanggal'),
                            'status_anak'=>$this->input->post('status_anak'),
                            'alamat_wali'=>$this->input->post('alamat_wali'),
                            'no_telpon_wali'=>$this->input->post('no_telpon_wali'));
                $this->model_app->insert('rb_siswa_ortu',$data_ortu);
            }
            redirect($this->uri->segment(1).'/edit_siswa/'.$this->input->post('id'));

        }elseif (isset($_POST['update3'])){
            $config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|pdf|docx';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);

            $this->upload->do_upload('ktp_ortu');
            $hasil1 = $this->upload->data();

            $this->upload->do_upload('kartu_keluarga');
            $hasil2 = $this->upload->data();

            $this->upload->do_upload('akte_kelahiran');
            $hasil3 = $this->upload->data();

            $this->upload->do_upload('ijazah_terakhir');
            $hasil4 = $this->upload->data();

            $this->upload->do_upload('skhu');
            $hasil5 = $this->upload->data();

            $this->upload->do_upload('sertifikat_lainnya');
            $hasil6 = $this->upload->data();

            $cek = $this->model_app->view_where('rb_siswa_file',array('id_siswa'=>$this->input->post('id')))->num_rows();
            if ($cek<=0){
                $data = array('id_siswa'=>$this->input->post('id'),
                            'ktp_ortu'=>$hasil1['file_name'],
                            'kartu_keluarga'=>$hasil2['file_name'],
                            'akte_kelahiran'=>$hasil3['file_name'],
                            'ijazah_terakhir'=>$hasil4['file_name'],
                            'skhu'=>$hasil5['file_name'],
                            'sertifikat_lainnya'=>$hasil6['file_name']);
                $this->model_app->insert('rb_siswa_file',$data);
            }else{
                $row = $this->model_app->view_where('rb_siswa_file',array('id_siswa'=>$this->input->post('id')))->row_array();
                if($hasil1['file_name']==''){ $ktp_ortu = $row['ktp_ortu']; }else{ $ktp_ortu = $hasil1['file_name']; }
                if($hasil2['file_name']==''){ $kartu_keluarga = $row['kartu_keluarga']; }else{ $kartu_keluarga = $hasil2['file_name']; }
                if($hasil3['file_name']==''){ $akte_kelahiran = $row['akte_kelahiran']; }else{ $akte_kelahiran = $hasil3['file_name']; }
                if($hasil4['file_name']==''){ $ijazah_terakhir = $row['ijazah_terakhir']; }else{ $ijazah_terakhir = $hasil4['file_name']; }
                if($hasil5['file_name']==''){ $skhu = $row['skhu']; }else{ $skhu = $hasil5['file_name']; }
                if($hasil6['file_name']==''){ $sertifikat_lainnya = $row['sertifikat_lainnya']; }else{ $sertifikat_lainnya = $hasil6['file_name']; }
                $data1 = array('id_siswa'=>$this->input->post('id'),
                            'ktp_ortu'=>$ktp_ortu,
                            'kartu_keluarga'=>$kartu_keluarga,
                            'akte_kelahiran'=>$akte_kelahiran,
                            'ijazah_terakhir'=>$ijazah_terakhir,
                            'skhu'=>$skhu,
                            'sertifikat_lainnya'=>$sertifikat_lainnya);
                $where1 = array('id_siswa' => $this->input->post('id'));
                $this->model_app->update('rb_siswa_file', $data1, $where1);
            }


            redirect($this->uri->segment(1).'/edit_siswa/'.$this->input->post('id'));
        }else{
            $edit = $this->model_app->view_where('rb_siswa', array('id_siswa'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $files = $this->model_app->view_where('rb_siswa_file', array('id_siswa'=>$id))->row_array();
            $jk = $this->model_app->view('rb_jenis_kelamin');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $agama = $this->model_app->view('rb_agama');
            $data = array('s' => $edit,'jk' => $jk,'kelas' => $kelas,'jurusan' => $jurusan,'agama' => $agama,'files' => $files);
            $this->template->load('administrator/template','administrator/mod_siswa/edit',$data);
        }
    }

    function penilaian_diri_siswa(){
        cek_session_akses('penilaian_diri',$this->session->id_session);
        $siswa = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->uri->segment(3)))->row_array();
        $record = $this->model_app->view_where_ordering('rb_pertanyaan_penilaian',array('status'=>'diri','id_identitas_sekolah'=>$this->session->sekolah),'id_pertanyaan_penilaian','ASC');
        $data = array('record' => $record,'d' => $siswa);
        $this->template->load('administrator/template','administrator/mod_siswa/penilaian_diri',$data);
    }

    function penilaian_teman_siswa(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $siswa = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->uri->segment(3)))->row_array();
        $data = array('thn' => $thn,'d' => $siswa);
        $this->template->load('administrator/template','administrator/mod_siswa/penilaian_teman',$data);
    }

    function penilaian_teman_siswa_jawab(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $record = $this->model_app->view_where_ordering('rb_pertanyaan_penilaian',array('status'=>'teman','id_identitas_sekolah'=>$this->session->sekolah),'id_pertanyaan_penilaian','ASC');
        $teman = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->uri->segment(4),'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $siswa = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $data = array('record' => $record,'thn'=>$thn,'t'=>$teman,'s'=>$siswa);
        $this->template->load('administrator/template','administrator/mod_siswa/penilaian_teman_detail',$data);
    }

    function delete_siswa(){
        cek_session_akses('siswa',$this->session->id_session);
        $id = array('id_siswa' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_siswa',$id);
        redirect($this->uri->segment(1).'/siswa');
    }



    // Controller Modul Guru

    function guru(){
        cek_session_akses('guru',$this->session->id_session);
        $guru = $this->model_app->guru();
        $data = array('record' => $guru);
        $this->template->load('administrator/template','administrator/mod_guru/view',$data);
    }

    function detail_guru(){
        cek_session_akses('guru',$this->session->id_session);
        $data['s'] = $this->model_app->guru()->row_array();
        $this->template->load('administrator/template','administrator/mod_guru/detail',$data);
    }

    function tambah_guru(){
        cek_session_akses('guru',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_pegawai/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                $rt_rw = explode('/',$this->input->post('rt_rw'));
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'password'=>md5($this->input->post('password')),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>$this->input->post('tanggal_cpns'),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'));
            }else{
                $rt_rw = explode('/',$this->input->post('rt_rw'));
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'password'=>md5($this->input->post('password')),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>$this->input->post('tanggal_cpns'),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'),
                                'foto'=>$hasil['file_name']);
            }

            $this->model_app->insert('rb_guru',$data);
            redirect($this->uri->segment(1).'/guru');
        }else{
            $jk = $this->model_app->view('rb_jenis_kelamin');
            $agama = $this->model_app->view('rb_agama');
            $status_keaktifan = $this->model_app->view('rb_status_keaktifan');
            $status_pernikahan = $this->model_app->view('rb_status_pernikahan');
            $golongan = $this->model_app->view('rb_golongan');
            $ptk = $this->model_app->view('rb_jenis_ptk');
            $status_kepegawaian = $this->model_app->view('rb_status_kepegawaian');

            $data = array('jk' => $jk,'agama' => $agama,'status_keaktifan' => $status_keaktifan,'status_pernikahan' => $status_pernikahan,'golongan' => $golongan,'ptk' => $ptk,'status_kepegawaian' => $status_kepegawaian);
            $this->template->load('administrator/template','administrator/mod_guru/tambah',$data);
        }
    }

    function edit_guru(){
        cek_session_akses('guru',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['update'])){
            $config['upload_path'] = 'asset/foto_pegawai/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '2000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["foto"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                if (trim($this->input->post('password'))!=''){
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'password'=>md5($this->input->post('password')),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>$this->input->post('tanggal_cpns'),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'),
                                'guru_bk'=>$this->input->post('guru_bk'),
                                'guru_piket'=>$this->input->post('guru_piket'),
                                'guru_bkk'=>$this->input->post('guru_bkk'),
                                'guru_wali_kelas'=>$this->input->post('guru_wali_kelas'),
                                'guru_matpel'=>$this->input->post('guru_matpel'),
                                'laboratorium'=>$this->input->post('laboratorium'),
                                'ppdb'=>$this->input->post('ppdb'),
                                'pustaka'=>$this->input->post('pustaka'),
                                'koperasi'=>$this->input->post('koperasi'),
                                'asset'=>$this->input->post('asset'),
                                'finance'=>$this->input->post('finance'),
                                'sk_gtt'=>$this->input->post('sk_gtt'),
                                'tgl_gtt'=>tgl_simpan($this->input->post('tgl_gtt')),
                                'sk_gty'=>$this->input->post('sk_gty'),
                                'tgl_gty'=>tgl_simpan($this->input->post('tgl_gty'))
                            );
                }else{
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>$this->input->post('tanggal_cpns'),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'),
                                'guru_bk'=>$this->input->post('guru_bk'),
                                'guru_piket'=>$this->input->post('guru_piket'),
                                'guru_bkk'=>$this->input->post('guru_bkk'),
                                'guru_wali_kelas'=>$this->input->post('guru_wali_kelas'),
                                'guru_matpel'=>$this->input->post('guru_matpel'),
                                'laboratorium'=>$this->input->post('laboratorium'),
                                'ppdb'=>$this->input->post('ppdb'),
                                'pustaka'=>$this->input->post('pustaka'),
                                'koperasi'=>$this->input->post('koperasi'),
                                'asset'=>$this->input->post('asset'),
                                'finance'=>$this->input->post('finance'),
                                'sk_gtt'=>$this->input->post('sk_gtt'),
                                'tgl_gtt'=>tgl_simpan($this->input->post('tgl_gtt')),
                                'sk_gty'=>$this->input->post('sk_gty'),
                                'tgl_gty'=>tgl_simpan($this->input->post('tgl_gty'))
                            );
                }
            }else{
                if (trim($this->input->post('password'))!=''){
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'password'=>md5($this->input->post('password')),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>tgl_simpan($this->input->post('tanggal_cpns')),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'),
                                'foto'=>$hasil['file_name'],
                                'guru_bk'=>$this->input->post('guru_bk'),
                                'guru_piket'=>$this->input->post('guru_piket'),
                                'guru_bkk'=>$this->input->post('guru_bkk'),
                                'guru_wali_kelas'=>$this->input->post('guru_wali_kelas'),
                                'guru_matpel'=>$this->input->post('guru_matpel'),
                                'laboratorium'=>$this->input->post('laboratorium'),
                                'ppdb'=>$this->input->post('ppdb'),
                                'pustaka'=>$this->input->post('pustaka'),
                                'koperasi'=>$this->input->post('koperasi'),
                                'asset'=>$this->input->post('asset'),
                                'finance'=>$this->input->post('finance'),
                                'sk_gtt'=>$this->input->post('sk_gtt'),
                                'tgl_gtt'=>tgl_simpan($this->input->post('tgl_gtt')),
                                'sk_gty'=>$this->input->post('sk_gty'),
                                'tgl_gty'=>tgl_simpan($this->input->post('tgl_gty'))
                            );
                }else{
                    $rt_rw = explode('/',$this->input->post('rt_rw'));
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'nip'=>$this->input->post('nip'),
                                'nama_guru'=>$this->input->post('nama_guru'),
                                'id_jenis_kelamin'=>$this->input->post('id_jenis_kelamin'),
                                'tempat_lahir'=>$this->input->post('tempat_lahir'),
                                'tanggal_lahir'=>tgl_simpan($this->input->post('tanggal_lahir')),
                                'nik'=>$this->input->post('nik'),
                                'niy_nigk'=>$this->input->post('niy_nigk'),
                                'nuptk'=>$this->input->post('nuptk'),
                                'id_status_kepegawaian'=>$this->input->post('id_status_kepegawaian'),
                                'id_jenis_ptk'=>$this->input->post('id_jenis_ptk'),
                                'pengawas_bidang_studi'=>$this->input->post('pengawas_bidang_studi'),
                                'id_agama'=>$this->input->post('id_agama'),
                                'alamat_jalan'=>$this->input->post('alamat_jalan'),
                                'rt'=>$rt_rw[0],
                                'rw'=>$rt_rw[1],
                                'nama_dusun'=>$this->input->post('nama_dusun'),
                                'desa_kelurahan'=>$this->input->post('desa_kelurahan'),
                                'kecamatan'=>$this->input->post('kecamatan'),
                                'kode_pos'=>$this->input->post('kode_pos'),
                                'telepon'=>$this->input->post('telepon'),
                                'hp'=>$this->input->post('hp'),
                                'email'=>$this->input->post('email'),
                                'tugas_tambahan'=>$this->input->post('tugas_tambahan'),
                                'id_status_keaktifan'=>$this->input->post('id_status_keaktifan'),
                                'sk_cpns'=>$this->input->post('sk_cpns'),
                                'tanggal_cpns'=>$this->input->post('tanggal_cpns'),
                                'sk_pengangkatan'=>$this->input->post('sk_pengangkatan'),
                                'tmt_pengangkatan'=>tgl_simpan($this->input->post('tmt_pengangkatan')),
                                'lembaga_pengangkatan'=>$this->input->post('lembaga_pengangkatan'),
                                'id_golongan'=>$this->input->post('id_golongan'),
                                'keahlian_laboratorium'=>$this->input->post('keahlian_laboratorium'),
                                'sumber_gaji'=>$this->input->post('sumber_gaji'),
                                'nama_ibu_kandung'=>$this->input->post('nama_ibu_kandung'),
                                'id_status_pernikahan'=>$this->input->post('id_status_pernikahan'),
                                'nama_suami_istri'=>$this->input->post('nama_suami_istri'),
                                'nip_suami_istri'=>$this->input->post('nip_suami_istri'),
                                'pekerjaan_suami_istri'=>$this->input->post('pekerjaan_suami_istri'),
                                'tmt_pns'=>$this->input->post('tmt_pns'),
                                'lisensi_kepsek'=>$this->input->post('lisensi_kepsek'),
                                'jumlah_sekolah_binaan'=>$this->input->post('jumlah_sekolah_binaan'),
                                'diklat_kepengawasan'=>$this->input->post('diklat_kepengawasan'),
                                'mampu_handle_kk'=>$this->input->post('mampu_handle_kk'),
                                'keahlian_breile'=>$this->input->post('keahlian_breile'),
                                'keahlian_bahasa_isyarat'=>$this->input->post('keahlian_bahasa_isyarat'),
                                'npwp'=>$this->input->post('npwp'),
                                'kewarganegaraan'=>$this->input->post('kewarganegaraan'),
                                'foto'=>$hasil['file_name'],
                                'guru_bk'=>$this->input->post('guru_bk'),
                                'guru_piket'=>$this->input->post('guru_piket'),
                                'guru_bkk'=>$this->input->post('guru_bkk'),
                                'guru_wali_kelas'=>$this->input->post('guru_wali_kelas'),
                                'guru_matpel'=>$this->input->post('guru_matpel'),
                                'laboratorium'=>$this->input->post('laboratorium'),
                                'ppdb'=>$this->input->post('ppdb'),
                                'pustaka'=>$this->input->post('pustaka'),
                                'koperasi'=>$this->input->post('koperasi'),
                                'asset'=>$this->input->post('asset'),
                                'finance'=>$this->input->post('finance'),
                                'sk_gtt'=>$this->input->post('sk_gtt'),
                                'tgl_gtt'=>tgl_simpan($this->input->post('tgl_gtt')),
                                'sk_gty'=>$this->input->post('sk_gty'),
                                'tgl_gty'=>tgl_simpan($this->input->post('tgl_gty'))
                            ); 
                }
            }
            if ($this->session->level=='guru'){
                $where = array('id_guru' => $this->session->id_session,'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_guru', $data, $where);
                redirect($this->uri->segment(1).'/edit_guru/'.$this->session->id_session);
            }else{
                $where = array('id_guru' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_guru', $data, $where);
                redirect($this->uri->segment(1).'/guru');
            }
        }else{
            $edit = $this->model_app->view_where('rb_guru', array('id_guru'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $jk = $this->model_app->view('rb_jenis_kelamin');
            $agama = $this->model_app->view('rb_agama');
            $status_keaktifan = $this->model_app->view('rb_status_keaktifan');
            $status_pernikahan = $this->model_app->view('rb_status_pernikahan');
            $golongan = $this->model_app->view('rb_golongan');
            $ptk = $this->model_app->view('rb_jenis_ptk');
            $status_kepegawaian = $this->model_app->view('rb_status_kepegawaian');

            $data = array('s' => $edit,'jk' => $jk,'agama' => $agama,'status_keaktifan' => $status_keaktifan,'status_pernikahan' => $status_pernikahan,'golongan' => $golongan,'ptk' => $ptk,'status_kepegawaian' => $status_kepegawaian);
            $this->template->load('administrator/template','administrator/mod_guru/edit',$data);
        }
    }

    function akses_guru(){
        cek_session_akses('guru',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_guru'=>$this->uri->segment(3),
                        'id_modul'=>$this->input->post('modul'));
            $this->model_app->insert('rb_guru_akses',$data);
            redirect($this->uri->segment(1).'/akses_guru/'.$this->uri->segment(3));
        }else{
            $data['s'] = $this->model_app->view_where('rb_guru', array('id_guru'=>$this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data['akses'] = $this->model_app->view_join_where('*','rb_guru_akses','rb_modul','id_modul',array('id_guru'=>$this->uri->segment(3)),'id_guru_akses','DESC');
            $data['record'] = $this->model_app->view_where('rb_modul', array('id_identitas_sekolah'=>$this->session->sekolah));
            $this->template->load('administrator/template','administrator/mod_guru/akses',$data);
        }
    }

    function akses_hapus(){
        cek_session_akses('guru',$this->session->id_session);
        $id = array('id_guru_akses' => $this->uri->segment(3));
        $this->model_app->delete('rb_guru_akses',$id);
        redirect($this->uri->segment(1).'/akses_guru/'.$this->uri->segment(4));
    }

    function delete_guru(){
        cek_session_akses('guru',$this->session->id_session);
        $id = array('id_guru' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_guru',$id);
        redirect($this->uri->segment(1).'/guru');
    }


    function kepala_sekolah(){
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '1000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["f"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($hasil['file_name']=='' AND $this->input->post('b') ==''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')));
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') ==''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'foto'=>$hasil['file_name']);
            }elseif ($hasil['file_name']=='' AND $this->input->post('b') !=''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>md5($this->input->post('b')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')));
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') !=''){
                    $data = array('username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>md5($this->input->post('b')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'foto'=>$hasil['file_name']);
            }
            $where = array('id_user' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_users', $data, $where);
            redirect($this->uri->segment(1).'/kepala_sekolah');
        }else{
            if ($this->session->username==$this->uri->segment(3) OR $this->session->level=='admin'){
                $proses = $this->model_app->edit('rb_users', array('id_identitas_sekolah' => $this->session->sekolah,'level'=>'kepala'))->row_array();
                $data = array('rows' => $proses);
                $this->template->load('administrator/template','administrator/mod_users/view_kepsek_edit',$data);
            }else{
                redirect($this->uri->segment(1).'/kepala_sekolah');
            }
        }
    }


    // Controller Modul User

    function manajemenuser(){
        cek_session_akses('administrator',$this->session->id_session);
        $data['record'] = $this->model_app->users();
        $this->template->load('administrator/template','administrator/mod_users/view',$data);
    }


    function tambah_manajemenuser(){
        cek_session_akses('administrator',$this->session->id_session);
        $id = $this->session->username;
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '1000'; // kb

            $config['file_name'] = $_FILES["f"]['name'];
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["f"]['name'];

            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($hasil['file_name']==''){
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'level'=>$this->db->escape_str($this->input->post('g')));
            }else{
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'foto'=>$hasil['file_name'],
                                    'level'=>$this->db->escape_str($this->input->post('g')));
            }
            $this->model_app->insert('rb_users',$data);

              $mod=count($this->input->post('modul'));
              $modul=$this->input->post('modul');
              $sess = $this->db->insert_id();
              for($i=0;$i<$mod;$i++){
                $datam = array('id_user'=>$sess,
                              'id_modul'=>$modul[$i]);
                $this->model_app->insert('users_modul',$datam);
              }

            redirect($this->uri->segment(1).'/edit_manajemenuser/'.$sess);
        }else{
            $proses = $this->model_app->view_where_ordering('modul', array('publish' => 'Y','status' => 'user'), 'id_modul','DESC');
            $data = array('record' => $proses);
            $this->template->load('administrator/template','administrator/mod_users/tambah',$data);
        }
    }

    function edit_manajemenuser(){
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '1000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["f"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('f');
            $hasil=$this->upload->data();
            if ($hasil['file_name']=='' AND $this->input->post('b') ==''){
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')));
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') ==''){
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'foto'=>$hasil['file_name']);
            }elseif ($hasil['file_name']=='' AND $this->input->post('b') !=''){
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')));
            }elseif ($hasil['file_name']!='' AND $this->input->post('b') !=''){
                    $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                    'username'=>$this->db->escape_str($this->input->post('a')),
                                    'password'=>hash("sha512", md5($this->input->post('b'))),
                                    'nama_lengkap'=>$this->db->escape_str($this->input->post('c')),
                                    'email'=>$this->db->escape_str($this->input->post('d')),
                                    'no_telpon'=>$this->db->escape_str($this->input->post('e')),
                                    'foto'=>$hasil['file_name']);
            }
            $where = array('id_user' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_users', $data, $where);

              $mod=count($this->input->post('modul'));
              $modul=$this->input->post('modul');
              for($i=0;$i<$mod;$i++){
                $datam = array('id_user'=>$this->input->post('id'),
                              'id_modul'=>$modul[$i]);
                $this->model_app->insert('users_modul',$datam);
              }

            redirect($this->uri->segment(1).'/edit_manajemenuser/'.$this->input->post('id'));
        }else{
            if ($this->session->id_session==$this->uri->segment(3) OR $this->session->level=='admin'){
                $proses = $this->model_app->edit('rb_users', array('id_user' => $id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                $akses = $this->model_app->view_join_where('*','users_modul','modul','id_modul', array('id_user' => $id),'id_umod','DESC');
                $modul = $this->model_app->view_where_ordering('modul', array('publish' => 'Y','status' => 'user'), 'id_modul','DESC');
                $data = array('rows' => $proses, 'record' => $modul, 'akses' => $akses);
                $this->template->load('administrator/template','administrator/mod_users/edit',$data);
            }else{
                redirect($this->uri->segment(1).'/edit_manajemenuser/'.$this->session->username);
            }
        }
    }

    function delete_manajemenuser(){
        cek_session_akses('manajemenuser',$this->session->id_session);
        $id = array('id_user' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_users',$id);
        redirect($this->uri->segment(1).'/manajemenuser');
    }

    function delete_akses(){
        cek_session_admin();
        $id = array('id_umod' => $this->uri->segment(3));
        $this->model_app->delete('users_modul',$id);
        redirect($this->uri->segment(1).'/edit_manajemenuser/'.$this->uri->segment(4));
    }


    // Controller Modul Akses Khusus

    function akses_khusus(){
        cek_session_akses('akses_khusus',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_modul',array('id_identitas_sekolah'=>$this->session->sekolah),'id_modul','DESC');
        $this->template->load('administrator/template','administrator/mod_akses_khusus/view',$data);
    }

    function tambah_akses_khusus(){
        cek_session_akses('akses_khusus',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_modul'=>$this->input->post('a'),
                            'url'=>$this->input->post('b'),
                            'aktif'=>$this->input->post('c'));
            $this->model_app->insert('rb_modul',$data);
            redirect($this->uri->segment(1).'/akses_khusus');
        }else{
            $this->template->load('administrator/template','administrator/mod_akses_khusus/tambah');
        }
    }

    function edit_akses_khusus(){
        cek_session_akses('akses_khusus',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama_modul'=>$this->input->post('a'),
                            'url'=>$this->input->post('b'),
                            'aktif'=>$this->input->post('c'));
            $where = array('id_modul' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_modul', $data, $where);
            redirect($this->uri->segment(1).'/akses_khusus');
        }else{
            $edit = $this->model_app->view_where('rb_modul', array('id_modul'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_akses_khusus/edit',$data);
        }
    }

    function delete_akses_khusus(){
        cek_session_akses('akses_khusus',$this->session->id_session);
        $id = array('id_modul' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_modul',$id);
        redirect($this->uri->segment(1).'/akses_khusus');
    }

    

    // Controller Modul Modul

    function manajemenmodul(){
        cek_session_akses('manajemenmodul',$this->session->id_session);
        if ($this->session->level=='admin'){
            $data['record'] = $this->model_app->view_ordering('modul','id_modul','DESC');
        }else{
            $data['record'] = $this->model_app->view_where_ordering('modul',array('username'=>$this->session->username),'id_modul','DESC');
        }
        $this->template->load('administrator/template','administrator/mod_modul/view',$data);
    }

    function tambah_manajemenmodul(){
        cek_session_akses('manajemenmodul',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('nama_modul'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'link'=>$this->db->escape_str($this->input->post('b')),
                        'static_content'=>'',
                        'gambar'=>'',
                        'publish'=>$this->db->escape_str($this->input->post('c')),
                        'status'=>$this->db->escape_str($this->input->post('e')),
                        'aktif'=>$this->db->escape_str($this->input->post('d')),
                        'urutan'=>'0',
                        'link_seo'=>'');
            $this->model_app->insert('modul',$data);
            redirect($this->uri->segment(1).'/manajemenmodul');
        }else{
            $this->template->load('administrator/template','administrator/mod_modul/tambah');
        }
    }

    function edit_manajemenmodul(){
        cek_session_akses('manajemenmodul',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama_modul'=>$this->db->escape_str($this->input->post('a')),
                        'username'=>$this->session->username,
                        'link'=>$this->db->escape_str($this->input->post('b')),
                        'static_content'=>'',
                        'gambar'=>'',
                        'publish'=>$this->db->escape_str($this->input->post('c')),
                        'status'=>$this->db->escape_str($this->input->post('e')),
                        'aktif'=>$this->db->escape_str($this->input->post('d')),
                        'urutan'=>'0',
                        'link_seo'=>'');
            $where = array('id_modul' => $this->input->post('id'));
            $this->model_app->update('modul', $data, $where);
            redirect($this->uri->segment(1).'/manajemenmodul');
        }else{
            if ($this->session->level=='admin'){
                 $proses = $this->model_app->edit('modul', array('id_modul' => $id))->row_array();
            }else{
                $proses = $this->model_app->edit('modul', array('id_modul' => $id, 'username' => $this->session->username))->row_array();
            }
            $data = array('rows' => $proses);
            $this->template->load('administrator/template','administrator/mod_modul/edit',$data);
        }
    }

    function delete_manajemenmodul(){
        cek_session_akses('manajemenmodul',$this->session->id_session);
        if ($this->session->level=='admin'){
            $id = array('id_modul' => $this->uri->segment(3));
        }else{
            $id = array('id_modul' => $this->uri->segment(3), 'username'=>$this->session->username);
        }
        $this->model_app->delete('modul',$id);
        redirect($this->uri->segment(1).'/manajemenmodul');
    }


    // Controller Modul Kelompok Mapel

    function kelompok_mapel(){
        cek_session_akses('kelompok_mapel',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran','DESC');
        $this->template->load('administrator/template','administrator/mod_kelompok_mapel/view',$data);
    }

    function tambah_kelompok_mapel(){
        cek_session_akses('kelompok_mapel',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'jenis_kelompok_mata_pelajaran'=>$this->input->post('a'),
                            'nama_kelompok_mata_pelajaran'=>$this->input->post('b'));
            $this->model_app->insert('rb_kelompok_mata_pelajaran',$data);
            redirect($this->uri->segment(1).'/kelompok_mapel');
        }else{
            $this->template->load('administrator/template','administrator/mod_kelompok_mapel/tambah');
        }
    }

    function edit_kelompok_mapel(){
        cek_session_akses('kelompok_mapel',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'jenis_kelompok_mata_pelajaran'=>$this->input->post('a'),
                            'nama_kelompok_mata_pelajaran'=>$this->input->post('b'));
            $where = array('id_kelompok_mata_pelajaran' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_kelompok_mata_pelajaran', $data, $where);
            redirect($this->uri->segment(1).'/kelompok_mapel');
        }else{
            $edit = $this->model_app->view_where('rb_kelompok_mata_pelajaran', array('id_kelompok_mata_pelajaran'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_kelompok_mapel/edit',$data);
        }
    }

    function delete_kelompok_mapel(){
        cek_session_akses('kelompok_mapel',$this->session->id_session);
        $id = array('id_kelompok_mata_pelajaran' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kelompok_mata_pelajaran',$id);
        redirect($this->uri->segment(1).'/kelompok_mapel');
    }


    // Controller Modul Sub Kelompok mapel

    function kelompok_mapel_sub(){
        cek_session_akses('kelompok_mapel_sub',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_kelompok_mata_pelajaran_sub.* ,nama_kelompok_mata_pelajaran','rb_kelompok_mata_pelajaran_sub','rb_kelompok_mata_pelajaran','id_kelompok_mata_pelajaran',array('rb_kelompok_mata_pelajaran.id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran_sub','DESC');
        $this->template->load('administrator/template','administrator/mod_kelompok_mapel_sub/view',$data);
    }

    function tambah_kelompok_mapel_sub(){
        cek_session_akses('kelompok_mapel_sub',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_kelompok_mata_pelajaran'=>$this->input->post('b'),
                            'jenis_kelompok_mata_pelajaran_sub'=>$this->input->post('a'),
                            'nama_kelompok_mata_pelajaran_sub'=>$this->input->post('c'));
            $this->model_app->insert('rb_kelompok_mata_pelajaran_sub',$data);
            redirect($this->uri->segment(1).'/kelompok_mapel_sub');
        }else{
            $kelompok = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran','ASC');
            $data = array('kelompok' => $kelompok);
            $this->template->load('administrator/template','administrator/mod_kelompok_mapel_sub/tambah',$data);
        }
    }

    function edit_kelompok_mapel_sub(){
        cek_session_akses('kelompok_mapel_sub',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_kelompok_mata_pelajaran'=>$this->input->post('b'),
                            'jenis_kelompok_mata_pelajaran_sub'=>$this->input->post('a'),
                            'nama_kelompok_mata_pelajaran_sub'=>$this->input->post('c'));
            $where = array('id_kelompok_mata_pelajaran_sub' => $this->input->post('id'));
            $this->model_app->update('rb_kelompok_mata_pelajaran_sub', $data, $where);
            redirect($this->uri->segment(1).'/kelompok_mapel_sub');
        }else{
            $edit = $this->model_app->view_where('rb_kelompok_mata_pelajaran_sub', array('id_kelompok_mata_pelajaran_sub'=>$id))->row_array();
            $kelompok = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran','ASC');
            $data = array('s' => $edit,'kelompok' => $kelompok);
            $this->template->load('administrator/template','administrator/mod_kelompok_mapel_sub/edit',$data);
        }
    }

    function delete_kelompok_mapel_sub(){
        cek_session_akses('kelompok_mapel_sub',$this->session->id_session);
        $id = array('id_kelompok_mata_pelajaran_sub' => $this->uri->segment(3));
        $this->model_app->delete('rb_kelompok_mata_pelajaran_sub',$id);
        redirect($this->uri->segment(1).'/kelompok_mapel_sub');
    }


    // Controller Modul mata_pelajaran

    function mata_pelajaran(){
        cek_session_akses('mata_pelajaran',$this->session->id_session);
        $record = $this->model_app->mapel();
        $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'kode_tingkat','ASC');
        $data = array('tingkat' => $tingkat,'record' => $record);
        $this->template->load('administrator/template','administrator/mod_mata_pelajaran/view',$data);
    }

    function tambah_mata_pelajaran(){
        cek_session_akses('mata_pelajaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_pelajaran'=>$this->input->post('a'),
                            'id_kelompok_mata_pelajaran'=>$this->input->post('b'),
                            'id_kelompok_mata_pelajaran_sub'=>$this->input->post('bs'),
                            'id_jurusan'=>$this->input->post('c'),
                            'id_guru'=>$this->input->post('d'),
                            'namamatapelajaran'=>$this->input->post('f'),
                            'namamatapelajaran_en'=>$this->input->post('g'),
                            'id_tingkat'=>$this->input->post('h'),
                            'kompetensi_umum'=>$this->input->post('i'),
                            'kompetensi_khusus'=>$this->input->post('j'),
                            'jumlah_jam'=>$this->input->post('k'),
                            'sesi'=>$this->input->post('n'),
                            'urutan'=>$this->input->post('ll'),
                            'kkm'=>$this->input->post('kkm'),
                            'karakter'=>$this->input->post('karakter'),
                            'aktif'=>$this->input->post('m'));
            $this->model_app->insert('rb_mata_pelajaran',$data);
            redirect($this->uri->segment(1).'/mata_pelajaran/'.$this->input->post('h'));
        }else{
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tingkat','ASC');
            $kelompok = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran','ASC');
            $subkelmpok = $this->db->query('SELECT * FROM rb_kelompok_mata_pelajaran_sub')->result_array();
            $data = array('jurusan' => $jurusan,'guru' => $guru,'tingkat' => $tingkat,'kelompok' => $kelompok, 'subkelmpok'=>$subkelmpok);
            $this->template->load('administrator/template','administrator/mod_mata_pelajaran/tambah',$data);
        }
    }

    function edit_mata_pelajaran(){
        cek_session_akses('mata_pelajaran',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_pelajaran'=>$this->input->post('a'),
                            'id_kelompok_mata_pelajaran'=>$this->input->post('b'),
                            'id_kelompok_mata_pelajaran_sub'=>$this->input->post('bs'),
                            'id_jurusan'=>$this->input->post('c'),
                            'id_guru'=>$this->input->post('d'),
                            'namamatapelajaran'=>$this->input->post('f'),
                            'namamatapelajaran_en'=>$this->input->post('g'),
                            'id_tingkat'=>$this->input->post('h'),
                            'kompetensi_umum'=>$this->input->post('i'),
                            'kompetensi_khusus'=>$this->input->post('j'),
                            'jumlah_jam'=>$this->input->post('k'),
                            'sesi'=>$this->input->post('n'),
                            'urutan'=>$this->input->post('ll'),
                            'kkm'=>$this->input->post('kkm'),
                            'karakter'=>$this->input->post('karakter'),
                            'aktif'=>$this->input->post('m'));
            $where = array('id_mata_pelajaran' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_mata_pelajaran', $data, $where);
            redirect($this->uri->segment(1).'/mata_pelajaran/'.$this->input->post('h'));
        }else{
            $edit = $this->model_app->view_where('rb_mata_pelajaran', array('id_mata_pelajaran'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $jurusan = $this->model_app->view_where_ordering('rb_jurusan',array('id_identitas_sekolah'=>$this->session->sekolah),'id_jurusan','ASC');
            $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
            $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tingkat','ASC');
            $kelompok = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelompok_mata_pelajaran','ASC');
            $subkelompok = $this->model_app->view_where_ordering('rb_kelompok_mata_pelajaran_sub',array('id_kelompok_mata_pelajaran'=>$edit['id_kelompok_mata_pelajaran']),'id_kelompok_mata_pelajaran_sub','ASC');
            
            $data = array('s' => $edit,'jurusan' => $jurusan,'guru' => $guru,'tingkat' => $tingkat,'kelompok' => $kelompok,'subkelompok' => $subkelompok);
            $this->template->load('administrator/template','administrator/mod_mata_pelajaran/edit',$data);
        }
    }

    function delete_mata_pelajaran(){
        cek_session_akses('mata_pelajaran',$this->session->id_session);
        $id = array('id_mata_pelajaran' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_mata_pelajaran',$id);
        redirect($this->uri->segment(1).'/mata_pelajaran');
    }


    // Controller Modul jadwal_pelajaran

    function jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/view_guru',$data);
        }elseif($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/view_siswa',$data);
        }else{
            if (isset($_POST['transfer'])){
                $record = $this->db->query("SELECT * FROM rb_jadwal_pelajaran where id_kelas='$_POST[kelas]' AND id_tahun_akademik='$_POST[tahun]'");
                foreach ($record->result_array() as $r){
                    $data = array('id_tahun_akademik'=>$this->input->post('transfer_tahun'),
                            'id_kelas'=>$this->input->post('transfer_kelas'),
                            'id_mata_pelajaran'=>$r['id_mata_pelajaran'],
                            'id_ruangan'=>$r['id_ruangan'],
                            'id_guru'=>$r['id_guru'],
                            'paralel'=>$r['paralel'],
                            'jadwal_serial'=>$r['jadwal_serial'],
                            'jam_ke'=>$r['jam_ke'],
                            'jam_mulai'=>$r['jam_mulai'],
                            'jam_selesai'=>$r['jam_selesai'],
                            'hari'=>$r['hari'],
                            'jurnal_sikap'=>$r['jurnal_sikap'],
                            'remedial'=>$r['remedial'],
                            'aktif'=>$r['aktif'],
                            'penilaian'=>$r['penilaian']);
                    $this->model_app->insert('rb_jadwal_pelajaran',$data);
                }
                redirect($this->uri->segment(1).'/jadwal_pelajaran?tahun='.$this->input->post('transfer_tahun').'&kelas='.$this->input->post('transfer_kelas'));
            }else{
                $record = $this->model_app->jadwal_pelajaran_all();
                $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
                $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
                $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
                $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/view',$data);
            }
        }
    }

    function tambah_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('a'),
                            'id_kelas'=>$this->input->post('b'),
                            'id_mata_pelajaran'=>$this->input->post('c'),
                            'id_ruangan'=>$this->input->post('d'),
                            'id_guru'=>$this->input->post('e'),
                            'paralel'=>$this->input->post('f'),
                            'jadwal_serial'=>$this->input->post('g'),
                            'jam_ke'=>$this->input->post('jam'),
                            'jam_mulai'=>$this->input->post('h'),
                            'jam_selesai'=>$this->input->post('i'),
                            'hari'=>$this->input->post('j'),
                            'jurnal_sikap'=>$this->input->post('sikap'),
                            'remedial'=>$this->input->post('remedial'),
                            'aktif'=>$this->input->post('f'),
                            'penilaian'=>$this->input->post('l'));
            $this->model_app->insert('rb_jadwal_pelajaran',$data);
            redirect($this->uri->segment(1).'/jadwal_pelajaran?tahun='.$this->input->post('a').'&kelas='.$this->input->post('b'));
        }else{
            $row = $this->db->query("SELECT id_tingkat, id_jurusan FROM rb_kelas where id_kelas='$_GET[kelas]'")->row_array();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah,'id_tingkat'=>$row['id_tingkat']),'id_kelas','ASC');        
            $mapel = $this->model_app->view_where_ordering('rb_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah,'id_tingkat'=>$row['id_tingkat'],'id_jurusan'=>$row['id_jurusan']),'id_mata_pelajaran','ASC');
            $ruangan = $this->model_app->view_join_where('*','rb_ruangan','rb_gedung','id_gedung',array('rb_gedung.id_identitas_sekolah'=>$this->session->sekolah),'id_ruangan','ASC');
            $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');

            $data = array('tahun' => $tahun,'kelas' => $kelas,'mapel' => $mapel,'ruangan' => $ruangan,'guru' => $guru);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/tambah',$data);
        }
    }

    function edit_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('a'),
                            'id_kelas'=>$this->input->post('b'),
                            'id_mata_pelajaran'=>$this->input->post('c'),
                            'id_ruangan'=>$this->input->post('d'),
                            'id_guru'=>$this->input->post('e'),
                            'paralel'=>$this->input->post('f'),
                            'jadwal_serial'=>$this->input->post('g'),
                            'jam_ke'=>$this->input->post('jam'),
                            'jam_mulai'=>$this->input->post('h'),
                            'jam_selesai'=>$this->input->post('i'),
                            'hari'=>$this->input->post('j'),
                            'jurnal_sikap'=>$this->input->post('sikap'),
                            'remedial'=>$this->input->post('remedial'),
                            'aktif'=>$this->input->post('f'),
                            'penilaian'=>$this->input->post('l'));
            $where = array('kodejdwl' => $this->input->post('id'));
            $this->model_app->update('rb_jadwal_pelajaran', $data, $where);
            redirect($this->uri->segment(1).'/jadwal_pelajaran?tahun='.$this->input->post('a').'&kelas='.$this->input->post('b'));
        }else{
            $row = $this->db->query("SELECT b.id_tingkat, b.id_jurusan FROM rb_jadwal_pelajaran a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where a.kodejdwl='".$this->uri->segment(3)."'")->row_array();

            $edit = $this->model_app->view_where('rb_jadwal_pelajaran', array('kodejdwl'=>$id))->row_array();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah,'id_tingkat'=>$row['id_tingkat']),'id_kelas','ASC');
            $mapel = $this->model_app->view_where_ordering('rb_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah,'id_tingkat'=>$row['id_tingkat'],'id_jurusan'=>$row['id_jurusan']),'id_mata_pelajaran','ASC');
            $ruangan = $this->model_app->view_join_where('*','rb_ruangan','rb_gedung','id_gedung',array('rb_gedung.id_identitas_sekolah'=>$this->session->sekolah),'id_ruangan','ASC');
            $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');

            $data = array('s' => $edit,'tahun' => $tahun,'kelas' => $kelas,'mapel' => $mapel,'ruangan' => $ruangan,'guru' => $guru);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/edit',$data);
        }
    }

    function delete_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $id = array('kodejdwl' => $this->uri->segment(3));
        $this->model_app->delete('rb_jadwal_pelajaran',$id);
        redirect($this->uri->segment(1).'/jadwal_pelajaran?tahun='.$this->uri->segment(4).'&kelas='.$this->uri->segment(5));
    }


    function predikat_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $id = $this->uri->segment(3);
            $edit = $this->model_app->view_where('rb_mata_pelajaran',array('id_mata_pelajaran'=>$id))->row_array();
            $predikat = $this->model_app->view_where_ordering('rb_predikat',array('id_mata_pelajaran'=>$id),'nilai_a','ASC');
            $data = array('s' => $edit,'predikat'=>$predikat);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/predikat',$data);
    }

    function tambah_predikat_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_mata_pelajaran'=>$this->input->post('id_mata_pelajaran'),
                            'nilai_a'=>$this->input->post('a'),
                            'nilai_b'=>$this->input->post('b'),
                            'grade'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_predikat',$data);
            redirect($this->uri->segment(1).'/predikat_jadwal_pelajaran/'.$this->input->post('id_mata_pelajaran'));
        }else{
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/predikat_tambah');
        }
    }

    function edit_predikat_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_mata_pelajaran'=>$this->input->post('id_mata_pelajaran'),
                            'nilai_a'=>$this->input->post('a'),
                            'nilai_b'=>$this->input->post('b'),
                            'grade'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $where = array('id_predikat' => $this->input->post('id'),'id_mata_pelajaran'=>$this->input->post('id_mata_pelajaran'));
            $this->model_app->update('rb_predikat', $data, $where);
            redirect($this->uri->segment(1).'/predikat_jadwal_pelajaran/'.$this->input->post('id_mata_pelajaran'));
        }else{
            $edit = $this->model_app->view_where('rb_predikat', array('id_predikat'=>$id,'id_mata_pelajaran'=>$this->uri->segment(4)))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_jadwal_pelajaran/predikat_edit',$data);
        }
    }

    function default_predikat_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $data = $this->model_app->view_where('rb_predikat',array('id_mata_pelajaran'=>0));
        foreach ($data->result_array() as $row) {
            $data = array('id_mata_pelajaran'=>$this->uri->segment(3),
                            'nilai_a'=>$row['nilai_a'],
                            'nilai_b'=>$row['nilai_b'],
                            'grade'=>$row['grade'],
                            'keterangan'=>$row['keterangan']);
            $this->model_app->insert('rb_predikat',$data);
        }
        redirect($this->uri->segment(1).'/predikat_jadwal_pelajaran/'.$this->uri->segment(3));
    }

    function delete_predikat_jadwal_pelajaran(){
        cek_session_akses('jadwal_pelajaran',$this->session->id_session);
        $id = array('id_predikat' => $this->uri->segment(3),'id_mata_pelajaran'=>$this->uri->segment(4));
        $this->model_app->delete('rb_predikat',$id);
        redirect($this->uri->segment(1).'/predikat_jadwal_pelajaran/'.$this->uri->segment(4));
    }

    // Controller Modul jadwal_pelajaran

    function bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/view_guru',$data);
        }elseif($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/view_siswa',$data);
        }else{
            $record = $this->model_app->jadwal_pelajaran_all();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/view',$data);
        }
    }

    function detail_bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        if($this->session->level=='guru'){
            $bahan_tugas = $this->db->query("SELECT * FROM rb_elearning a JOIN rb_kategori_elearning b ON a.id_kategori_elearning=b.id_kategori_elearning JOIN rb_jadwal_pelajaran c ON a.kodejdwl=c.kodejdwl where a.kodejdwl='$id' AND c.id_guru='".$this->session->id_session."'")->result_array();
        }else{
            $bahan_tugas = $this->model_app->view_join_where('*','rb_elearning','rb_kategori_elearning','id_kategori_elearning',array('kodejdwl'=>$id),'id_elearning','DESC');
        }

        if($this->session->level=='siswa'){
            $data = array('s' => $edit,'bahan_tugas'=>$bahan_tugas);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas_siswa',$data);
        }else{
            $data = array('s' => $edit,'bahan_tugas'=>$bahan_tugas);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas',$data);
        }
    }

    function tambah_bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        if (isset($_POST['submit'])){
            $ex1 = explode(' ', $this->input->post('d'));
            $tanggal_tugas = tgl_simpan($ex1[0]).' '.$ex1[1];
            $ex2 = explode(' ', $this->input->post('e'));
            $tanggal_selesai = tgl_simpan($ex2[0]).' '.$ex2[1];

            $config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'pdf|docx|doc|ppt|pptx|xls|xlsx';
            $config['max_size'] = '50000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["c"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']!=''){
                $data = array('id_kategori_elearning'=>$this->input->post('a'),
                                'kodejdwl'=>$this->uri->segment(3),
                                'nama_file'=>$this->input->post('b'),
                                'file_upload'=>$hasil['file_name'],
                                'tanggal_tugas'=>$tanggal_tugas,
                                'tanggal_selesai'=>$tanggal_selesai,
                                'keterangan'=>$this->input->post('f'),
                                'waktu_kirim'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_elearning',$data);
            }
            redirect($this->uri->segment(1).'/detail_bahan_tugas/'.$this->uri->segment(3));
        }else{
            $kategori_elearning = $this->model_app->view('rb_kategori_elearning');
            $data = array('kategori_elearning' => $kategori_elearning);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas_tambah',$data);
        }
    }

    function edit_bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        if (isset($_POST['submit'])){

            $ex1 = explode(' ', $this->input->post('d'));
            $tanggal_tugas = tgl_simpan($ex1[0]).' '.$ex1[1];
            $ex2 = explode(' ', $this->input->post('e'));
            $tanggal_selesai = tgl_simpan($ex2[0]).' '.$ex2[1];

            $config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'pdf|docx|doc|ppt|pptx|xls|xlsx';
            $config['max_size'] = '50000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["c"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('c');
            $hasil=$this->upload->data();
            if ($hasil['file_name']!=''){
                $data = array('id_kategori_elearning'=>$this->input->post('a'),
                                'kodejdwl'=>$this->uri->segment(4),
                                'nama_file'=>$this->input->post('b'),
                                'file_upload'=>$hasil['file_name'],
                                'tanggal_tugas'=>$tanggal_tugas,
                                'tanggal_selesai'=>$tanggal_selesai,
                                'keterangan'=>$this->input->post('f'));
                $where = array('id_elearning' => $this->input->post('id'),'kodejdwl'=>$this->uri->segment(4));
                $this->model_app->update('rb_elearning', $data, $where);
            }else{
                $data = array('id_kategori_elearning'=>$this->input->post('a'),
                                'kodejdwl'=>$this->uri->segment(4),
                                'nama_file'=>$this->input->post('b'),
                                'tanggal_tugas'=>$tanggal_tugas,
                                'tanggal_selesai'=>$tanggal_selesai,
                                'keterangan'=>$this->input->post('f'));
                $where = array('id_elearning' => $this->input->post('id'),'kodejdwl'=>$this->uri->segment(4));
                $this->model_app->update('rb_elearning', $data, $where);   
            }
            redirect($this->uri->segment(1).'/detail_bahan_tugas/'.$this->uri->segment(4));
        }else{
            $id = $this->uri->segment(3);
            $edit = $this->model_app->view_where('rb_elearning', array('id_elearning'=>$id,'kodejdwl'=>$this->uri->segment(4)))->row_array();
            $kategori_elearning = $this->model_app->view('rb_kategori_elearning');
            $data = array('row'=>$edit,'kategori_elearning' => $kategori_elearning);
            $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas_edit',$data);
        }
    }

    function jawaban_bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = 'asset/files/';
            $config['allowed_types'] = 'pdf|docx|doc|ppt|pptx|xls|xlsx';
            $config['max_size'] = '50000'; // kb
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["a"]['name'];
            $this->load->library('upload', $config);
            $this->upload->do_upload('a');
            $hasil=$this->upload->data();
            $data = array('id_elearning'=>$this->uri->segment(3),
                            'id_siswa'=>$this->session->id_session,
                            'keterangan'=>$this->input->post('b'),
                            'file_tugas'=>$hasil['file_name'],
                            'waktu'=>date('Y-m-d H:i:s'));
            $cek = $this->model_app->view_where('rb_elearning_jawab',array('id_elearning'=>$this->uri->segment(3), 'id_siswa'=>$this->session->id_session));
            if ($cek->num_rows()>=1){
                $where = array('id_elearning' => $this->uri->segment(3),'id_siswa'=>$this->session->id_session);
                $this->model_app->update('rb_elearning_jawab', $data, $where);   
            }else{
                $this->model_app->insert('rb_elearning_jawab',$data);
            }
            redirect($this->uri->segment(1).'/detail_bahan_tugas/'.$this->uri->segment(4));
        }else{
            if ($this->session->level=='siswa'){
                $id = $this->uri->segment(3);
                $edit = $this->model_app->view_where('rb_elearning', array('id_elearning'=>$id,'kodejdwl'=>$this->uri->segment(4)))->row_array();
                $kategori_elearning = $this->model_app->view('rb_kategori_elearning');
                $data = array('row'=>$edit,'kategori_elearning' => $kategori_elearning);
                $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas_kirim',$data);
            }else{
                $data['s'] = $this->model_app->jadwal_pelajaran_detail($this->uri->segment(4))->row_array();
                $this->template->load('administrator/template','administrator/mod_bahan_tugas/bahan_tugas_jawaban',$data);
            }
        }
    }

    function delete_bahan_tugas(){
        cek_session_akses('bahan_tugas',$this->session->id_session);
        $id = array('id_elearning' => $this->uri->segment(3),'kodejdwl'=>$this->uri->segment(4));
        $this->model_app->delete('rb_elearning',$id);
        redirect($this->uri->segment(1).'/detail_bahan_tugas/'.$this->uri->segment(4));
    }

    function download(){
            $name = $this->uri->segment(4);
            $data = file_get_contents("asset/".$this->uri->segment(3)."/".$name);
            force_download($name, $data);
    }

    function detail_kompetensi_inti(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->view_join_where_single('*','rb_mata_pelajaran','rb_tingkat','id_tingkat',array('id_mata_pelajaran'=>$id),'id_mata_pelajaran','DESC')->row_array();
        $kompetensi_inti = $this->model_app->view_where('rb_kompetensi_inti',array('id_mata_pelajaran'=>$this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah));
        $data = array('s' => $edit,'kompetensi_inti'=>$kompetensi_inti);
        $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_inti',$data);
    }

    function tambah_kompetensi_inti(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        if (isset($_POST['submit'])){
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_mata_pelajaran'=>$this->uri->segment(3),
                                'kode'=>$this->input->post('a'),
                                'kompetensi'=>$this->input->post('b'));
                $this->model_app->insert('rb_kompetensi_inti',$data);
            redirect($this->uri->segment(1).'/detail_kompetensi_inti/'.$this->uri->segment(3));
        }else{
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_inti_tambah');
        }
    }

    function edit_kompetensi_inti(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('kode'=>$this->input->post('a'),
                          'kompetensi'=>$this->input->post('b'));
                $where = array('id_kompetensi_inti' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_kompetensi_inti', $data, $where);   
            redirect($this->uri->segment(1).'/detail_kompetensi_inti/'.$this->uri->segment(4));
        }else{
            $id = $this->uri->segment(3);
            $edit = $this->model_app->view_where('rb_kompetensi_inti', array('id_kompetensi_inti'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('row'=>$edit);
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_inti_edit',$data);
        }
    }

    function delete_kompetensi_inti(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        $id = array('id_kompetensi_inti' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kompetensi_inti',$id);
        redirect($this->uri->segment(1).'/detail_kompetensi_inti/'.$this->uri->segment(4));
    }
    

    function kompetensi_dasar(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/view_guru',$data);
        }else{
            $record = $this->model_app->mapel();
            $tingkat = $this->model_app->view_where_ordering('rb_tingkat',array('id_identitas_sekolah'=>$this->session->sekolah),'kode_tingkat','ASC');
            $data = array('tingkat' => $tingkat,'record' => $record);
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/view',$data);
        }
    }

    function detail_kompetensi_dasar(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->view_join_where_single('*','rb_mata_pelajaran','rb_tingkat','id_tingkat',array('id_mata_pelajaran'=>$id),'id_mata_pelajaran','DESC')->row_array();
        $kompetensi_dasar = $this->model_app->view_join_where('*','rb_kompetensi_dasar','rb_kompetensi_inti','id_kompetensi_inti',array('rb_kompetensi_dasar.id_mata_pelajaran'=>$this->uri->segment(3),'rb_kompetensi_dasar.id_identitas_sekolah'=>$this->session->sekolah),'rb_kompetensi_dasar.id_kompetensi_dasar','DESC');
        $data = array('s' => $edit,'kompetensi_dasar'=>$kompetensi_dasar);
        $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_dasar',$data);
    }

    function tambah_kompetensi_dasar(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        if (isset($_POST['submit'])){
            if (substr($this->input->post('a'), 0,1) =='1'){
                $ranah = 'spiritual';
            }elseif (substr($this->input->post('a'), 0,1) =='2'){
                $ranah = 'sosial';
            }elseif (substr($this->input->post('a'), 0,1) =='3'){
                $ranah = 'pengetahuan';
            }elseif (substr($this->input->post('a'), 0,1) =='4'){
                $ranah = 'keterampilan';
            }
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_mata_pelajaran'=>$this->uri->segment(3),
                                'kd'=>$this->input->post('a'),
                                'id_kompetensi_inti'=>$this->input->post('b'),
                                'ranah'=>$ranah,
                                'kompetensi_dasar'=>$this->input->post('d'),
                                'kkm'=>$this->input->post('e'),
                                'kkm_proses'=>$this->input->post('e1').','.$this->input->post('e2').','.$this->input->post('e3'),
                                'deskripsi'=>$this->input->post('f'),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_kompetensi_dasar',$data);

                $kkm_kd = $this->db->query("SELECT (sum(kkm)/count(*)) as nilai FROM rb_kompetensi_dasar where id_mata_pelajaran='".$this->uri->segment(3)."'")->row_array();
                $data_kkm = array('kkm'=>number_format($kkm_kd['nilai']));
                $where_kkm = array('id_mata_pelajaran' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_mata_pelajaran', $data_kkm, $where_kkm);

            redirect($this->uri->segment(1).'/detail_kompetensi_dasar/'.$this->uri->segment(3));
        }elseif (isset($_POST['kisubmit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_mata_pelajaran'=>$this->uri->segment(3),
                                'kode'=>$this->input->post('a'),
                                'kompetensi'=>$this->input->post('b'));
            $this->model_app->insert('rb_kompetensi_inti',$data);
            redirect($this->uri->segment(1).'/tambah_kompetensi_dasar/'.$this->uri->segment(3));
        }else{
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_dasar_tambah');
        }
    }

    function edit_kompetensi_dasar(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        if (isset($_POST['submit'])){
            if (substr($this->input->post('a'), 0,1) =='1'){
                $ranah = 'spiritual';
            }elseif (substr($this->input->post('a'), 0,1) =='2'){
                $ranah = 'sosial';
            }elseif (substr($this->input->post('a'), 0,1) =='3'){
                $ranah = 'pengetahuan';
            }elseif (substr($this->input->post('a'), 0,1) =='4'){
                $ranah = 'keterampilan';
            }
            $data = array('kd'=>$this->input->post('a'),
                            'id_kompetensi_inti'=>$this->input->post('b'),
                            'ranah'=>$ranah,
                            'kompetensi_dasar'=>$this->input->post('d'),
                            'kkm'=>$this->input->post('e'),
                            'kkm_proses'=>$this->input->post('e1').','.$this->input->post('e2').','.$this->input->post('e3'),
                            'deskripsi'=>$this->input->post('f'));
                $where = array('id_kompetensi_dasar' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_kompetensi_dasar', $data, $where);   

                $kkm_kd = $this->db->query("SELECT (sum(kkm)/count(*)) as nilai FROM rb_kompetensi_dasar where id_mata_pelajaran='".$this->uri->segment(4)."'")->row_array();
                $data_kkm = array('kkm'=>number_format($kkm_kd['nilai']));
                $where_kkm = array('id_mata_pelajaran' => $this->uri->segment(4),'id_identitas_sekolah'=>$this->session->sekolah);
                $this->model_app->update('rb_mata_pelajaran', $data_kkm, $where_kkm);

            redirect($this->uri->segment(1).'/detail_kompetensi_dasar/'.$this->uri->segment(4));
        }else{
            $id = $this->uri->segment(3);
            $edit = $this->model_app->view_where('rb_kompetensi_dasar', array('id_kompetensi_dasar'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('row'=>$edit);
            $this->template->load('administrator/template','administrator/mod_kompetensi_dasar/kompetensi_dasar_edit',$data);
        }
    }

    function delete_kompetensi_dasar(){
        cek_session_akses('kompetensi_dasar',$this->session->id_session);
        $id = array('id_kompetensi_dasar' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_kompetensi_dasar',$id);
        redirect($this->uri->segment(1).'/detail_kompetensi_dasar/'.$this->uri->segment(4));
    }

    // Controller Modul Penilaian Diri

    function penilaian_diri(){
        cek_session_akses('penilaian_diri',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->model_app->view_where('rb_pertanyaan_penilaian',array('status'=>'diri','id_identitas_sekolah'=>$this->session->sekolah))->num_rows();
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $id_pertanyaan  = $_POST['id_pertanyaan'.$ia];
                $cek = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->session->id_session,'id_pertanyaan_penilaian'=>$id_pertanyaan,'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),'status'=>'diri'));
                if ($cek->num_rows() >= '1'){
                    $data = array('jawaban'=>$a);
                    $where = array('id_siswa'=>$this->session->id_session,'id_pertanyaan_penilaian'=>$id_pertanyaan,'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),'status'=>'diri');
                    $this->model_app->update('rb_pertanyaan_penilaian_jawab', $data, $where);
                }else{
                  $data = array('id_pertanyaan_penilaian'=>$id_pertanyaan,
                                'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                                'id_kelas'=>$this->session->id_kelas,
                                'id_siswa'=>$this->session->id_session,
                                'id_siswa2'=>'0',
                                'jawaban'=>$a,
                                'status'=>'diri',
                                'waktu_jawab'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_pertanyaan_penilaian_jawab',$data);
                }
            }
            redirect($this->uri->segment(1).'/penilaian_diri');
        }else{
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->view_where_ordering('rb_pertanyaan_penilaian',array('status'=>'diri','id_identitas_sekolah'=>$this->session->sekolah),'id_pertanyaan_penilaian','ASC');
            $data = array('record' => $record,'thn'=>$thn);
            if ($this->session->level=='siswa'){
                $this->template->load('administrator/template','administrator/mod_penilaian_diri/view_siswa',$data);
            }else{
                $this->template->load('administrator/template','administrator/mod_penilaian_diri/view',$data);
            }
        }
    }

    function tambah_penilaian_diri(){
        cek_session_akses('penilaian_diri',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'pertanyaan'=>$this->input->post('a'),
                            'status'=>'diri',
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_pertanyaan_penilaian',$data);
            redirect($this->uri->segment(1).'/penilaian_diri');
        }else{
            $this->template->load('administrator/template','administrator/mod_penilaian_diri/tambah');
        }
    }

    function edit_penilaian_diri(){
        cek_session_akses('penilaian_diri',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('pertanyaan'=>$this->input->post('a'));
            $where = array('id_pertanyaan_penilaian' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_pertanyaan_penilaian', $data, $where);
            redirect($this->uri->segment(1).'/penilaian_diri');
        }else{
            $edit = $this->model_app->view_where('rb_pertanyaan_penilaian', array('id_pertanyaan_penilaian'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('row' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian_diri/edit',$data);
        }
    }

    function delete_penilaian_diri(){
        cek_session_akses('penilaian_diri',$this->session->id_session);
        $id = array('id_pertanyaan_penilaian' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_pertanyaan_penilaian',$id);
        redirect($this->uri->segment(1).'/penilaian_diri');
    }


    // Controller Modul Penilaian Teman

    function penilaian_teman(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        if ($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$this->session->id_kelas,'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
            $data = array('record' => $record,'thn' => $thn);
            $this->template->load('administrator/template','administrator/mod_penilaian_teman/view_siswa',$data);
        }else{
            $record = $this->model_app->view_where_ordering('rb_pertanyaan_penilaian',array('status'=>'teman','id_identitas_sekolah'=>$this->session->sekolah),'id_pertanyaan_penilaian','ASC');
            $data = array('record' => $record);
            $this->template->load('administrator/template','administrator/mod_penilaian_teman/view',$data);
        }
    }

    function penilaian_teman_jawab(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->model_app->view_where('rb_pertanyaan_penilaian',array('status'=>'teman','id_identitas_sekolah'=>$this->session->sekolah))->num_rows();
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $id_pertanyaan  = $_POST['id_pertanyaan'.$ia];
                $cek = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->session->id_session,'id_pertanyaan_penilaian'=>$id_pertanyaan,'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),'id_siswa2'=>$this->input->post('id_siswa2'),'status'=>'teman'));
                if ($cek->num_rows() >= '1'){
                    $data = array('jawaban'=>$a);
                    $where = array('id_siswa'=>$this->session->id_session,'id_siswa2'=>$this->input->post('id_siswa2'),'id_pertanyaan_penilaian'=>$id_pertanyaan,'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),'status'=>'teman');
                    $this->model_app->update('rb_pertanyaan_penilaian_jawab', $data, $where);
                }else{
                  $data = array('id_pertanyaan_penilaian'=>$id_pertanyaan,
                                'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                                'id_kelas'=>$this->session->id_kelas,
                                'id_siswa'=>$this->session->id_session,
                                'id_siswa2'=>$this->input->post('id_siswa2'),
                                'jawaban'=>$a,
                                'status'=>'teman',
                                'waktu_jawab'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_pertanyaan_penilaian_jawab',$data);
                }
            }
            redirect($this->uri->segment(1).'/penilaian_teman_jawab/'.$this->input->post('id_siswa2'));
        }else{
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->view_where_ordering('rb_pertanyaan_penilaian',array('status'=>'teman','id_identitas_sekolah'=>$this->session->sekolah),'id_pertanyaan_penilaian','ASC');
            $teman = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('record' => $record,'thn'=>$thn,'t'=>$teman);
            $this->template->load('administrator/template','administrator/mod_penilaian_teman/view_siswa_jawab',$data);
        }
    }

    function tambah_penilaian_teman(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'pertanyaan'=>$this->input->post('a'),
                            'status'=>'teman',
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_pertanyaan_penilaian',$data);
            redirect($this->uri->segment(1).'/penilaian_teman');
        }else{
            $this->template->load('administrator/template','administrator/mod_penilaian_teman/tambah');
        }
    }

    function edit_penilaian_teman(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('pertanyaan'=>$this->input->post('a'));
            $where = array('id_pertanyaan_penilaian' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_pertanyaan_penilaian', $data, $where);
            redirect($this->uri->segment(1).'/penilaian_teman');
        }else{
            $edit = $this->model_app->view_where('rb_pertanyaan_penilaian', array('id_pertanyaan_penilaian'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('row' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian_teman/edit',$data);
        }
    }

    function delete_penilaian_teman(){
        cek_session_akses('penilaian_teman',$this->session->id_session);
        $id = array('id_pertanyaan_penilaian' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_pertanyaan_penilaian',$id);
        redirect($this->uri->segment(1).'/penilaian_teman');
    }

    function jurnal_kbm(){
        cek_session_akses('jurnal_kbm',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_jurnal_kbm/view_guru',$data);
        }else{
            $record = $this->model_app->jadwal_pelajaran_all();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_jurnal_kbm/view',$data);
        }
    }

    function detail_jurnal_kbm(){
        cek_session_akses('jurnal_kbm',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        if($this->session->level=='guru'){
            $jurnal_kbm = $this->db->query("SELECT * FROM rb_journal_list a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kodejdwl='$id' AND b.id_guru='".$this->session->id_session."' ORDER BY id_journal DESC")->result_array();
        }else{
            $jurnal_kbm = $this->model_app->view_where_ordering('rb_journal_list',array('kodejdwl'=>$id),'id_journal','DESC');
        }
        $data = array('s' => $edit,'jurnal_kbm'=>$jurnal_kbm);
        $this->template->load('administrator/template','administrator/mod_jurnal_kbm/jurnal_kbm',$data);
    }

    function jurnal_kbm_rekap(){
        cek_session_akses('jurnal_kbm_rekap',$this->session->id_session);
        if($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jurnal_kbm_rekap($thn['id_tahun_akademik'],$this->session->id_kelas);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_jurnal_kbm/jurnal_rekap',$data);
        }else{
            $record = $this->model_app->jadwal_pelajaran_all();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_jurnal_kbm/view',$data);
        }
    }

    function absensi_guru(){
        cek_session_akses('absensi_guru',$this->session->id_session);
        if(isset($_POST['submit'])){
            $jml_data = count($_POST['id_guru']);
            $id_guru = $_POST['id_guru'];
            $kehadiran = $_POST['kehadiran'];

            for ($i=1; $i <= $jml_data; $i++){
              $total = $this->db->query("SELECT * FROM rb_absensi_guru where id_guru='".$id_guru[$i]."' AND tanggal='".$this->input->post('tanggal')."'");
              if ($total->num_rows() >= 1){
                $data = array('id_guru'=>$id_guru[$i],
                                'kode_kehadiran'=>$kehadiran[$i],
                                'tanggal'=>$this->input->post('tanggal'),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $where = array('id_guru' => $id_guru[$i],'tanggal'=>$this->input->post('tanggal'));
                $this->model_app->update('rb_absensi_guru', $data, $where);
              }else{
                $data = array('id_guru'=>$id_guru[$i],
                                'kode_kehadiran'=>$kehadiran[$i],
                                'tanggal'=>$this->input->post('tanggal'),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_absensi_guru',$data);
              }
            }
            redirect($this->uri->segment(1).'/absensi_guru?tanggal='.tgl_view($this->input->post('tanggal')));
        }else{
            $absensi_guru = $this->model_app->guru();
            $kehadiran = $this->model_app->view('rb_kehadiran');
            $data = array('absensi_guru' => $absensi_guru,'kehadiran'=>$kehadiran);
            $this->template->load('administrator/template','administrator/mod_absensi_guru/view',$data);
        }
    }

    function absensi_siswa(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_absensi_siswa/view_guru',$data);
        }elseif($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_absensi_siswa/view_siswa',$data);
        }else{
            $record = $this->model_app->jadwal_pelajaran_all();
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_absensi_siswa/view',$data);
        }
    }

    function detail_absensi_siswa(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $id = $this->uri->segment(3);
        if(isset($_POST['submit'])){
            $cekjurnal = $this->db->query("SELECT * FROM rb_journal_list where kodejdwl='".$this->uri->segment(3)."' AND tanggal='".tgl_simpan($this->input->post('tanggal'))."'");
            if ($cekjurnal->num_rows() >= 1){
                $row = $cekjurnal->row_array();
                $data = array('id_kompetensi_dasar'=>$this->input->post('kd'),
                                'hari'=>$this->input->post('hari'),
                                'tanggal'=>tgl_simpan($this->input->post('tanggal')),
                                'jam_ke'=>$this->input->post('pertemuan'),
                                'materi'=>$this->input->post('materi'),
                                'keterangan'=>$this->input->post('keterangan'),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $where = array('id_journal' => $row['id_journal']);
                $this->model_app->update('rb_journal_list', $data, $where);
            }else{
                $data = array('id_kompetensi_dasar'=>$this->input->post('kd'),
                                'kodejdwl'=>$this->uri->segment(3),
                                'hari'=>$this->input->post('hari'),
                                'tanggal'=>tgl_simpan($this->input->post('tanggal')),
                                'jam_ke'=>$this->input->post('pertemuan'),
                                'materi'=>$this->input->post('materi'),
                                'keterangan'=>$this->input->post('keterangan'),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_journal_list',$data);
                $ids = $this->db->insert_id();
            }

            $jml_data = count($_POST['id_siswa']);
            $id_siswa = $_POST['id_siswa'];
            $kehadiran = $_POST['kehadiran'];
            $catatan = $_POST['catatan'];

            for ($i=1; $i <= $jml_data; $i++){
              $total = $this->db->query("SELECT * FROM rb_absensi_siswa where kodejdwl='".$this->uri->segment(3)."' AND id_siswa='".$id_siswa[$i]."' AND tanggal='".tgl_simpan($this->input->post('tanggal'))."'");
              if ($total->num_rows() >= 1){
                $data = array('kodejdwl'=>$this->uri->segment(3),
                                'id_siswa'=>$id_siswa[$i],
                                'catatan'=>$catatan[$i],
                                'kode_kehadiran'=>$kehadiran[$i],
                                'tanggal'=>tgl_simpan($this->input->post('tanggal')),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $where = array('id_journal' => $row['id_journal'],'id_siswa' => $id_siswa[$i],'kodejdwl'=>$this->uri->segment(3),'tanggal'=>tgl_simpan($this->input->post('tanggal')));
                $this->model_app->update('rb_absensi_siswa', $data, $where);
              }else{
                $data = array('id_journal'=>$ids,
                                'kodejdwl'=>$this->uri->segment(3),
                                'id_siswa'=>$id_siswa[$i],
                                'catatan'=>$catatan[$i],
                                'kode_kehadiran'=>$kehadiran[$i],
                                'tanggal'=>tgl_simpan($this->input->post('tanggal')),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_absensi_siswa',$data);
              }
            }
            redirect($this->uri->segment(1).'/detail_absensi_siswa/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal'));
        }else{
            if ($this->input->get('tanggal')==''){
                $tanggal = date('Y-m-d');
            }else{
                $tanggal = tgl_simpan($this->input->get('tanggal'));
            }

            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $jurnal_kbm = $this->model_app->view_where_ordering('rb_journal_list',array('kodejdwl'=>$id),'id_journal','DESC');
            $kehadiran = $this->model_app->view('rb_kehadiran');
            $cekjurnal = $this->db->query("SELECT * FROM rb_journal_list where kodejdwl='".$this->uri->segment(3)."' AND tanggal='$tanggal'")->row_array();
            $data = array('s' => $edit,'jurnal_kbm'=>$jurnal_kbm,'kehadiran'=>$kehadiran,'row'=>$cekjurnal);
            $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa',$data);
        }
    }

    function absensi_siswa_harian(){
        cek_session_akses('absensi_siswa_harian',$this->session->id_session);
        if(isset($_POST['submit'])){
            $jml_data = count($_POST['id_siswa']);
            $id_siswa = $_POST['id_siswa'];
            $kehadiran = $_POST['kehadiran'];
            $catatan = $_POST['catatan'];

            for ($i=1; $i <= $jml_data; $i++){
              $total = $this->db->query("SELECT * FROM rb_absensi_siswa_harian where id_tahun_akademik='".$this->input->post('tahun')."' AND id_kelas='".$this->input->post('kelas')."' AND id_siswa='".$id_siswa[$i]."' AND tanggal='".tgl_simpan($this->input->post('tanggal'))."'");
              if ($total->num_rows() >= 1){
                $data = array('catatan'=>$catatan[$i],
                                'kode_kehadiran'=>$kehadiran[$i]);
                $where = array('id_siswa' => $id_siswa[$i],'tanggal'=>tgl_simpan($this->input->post('tanggal')),'id_tahun_akademik'=>$this->input->post('tahun'),'id_kelas'=>$this->input->post('kelas'));
                $this->model_app->update('rb_absensi_siswa_harian', $data, $where);
              }else{
                $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                                'id_tahun_akademik'=>$this->input->post('tahun'),
                                'id_kelas'=>$this->input->post('kelas'),
                                'id_siswa'=>$id_siswa[$i],
                                'catatan'=>$catatan[$i],
                                'kode_kehadiran'=>$kehadiran[$i],
                                'tanggal'=>tgl_simpan($this->input->post('tanggal')),
                                'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_absensi_siswa_harian',$data);
              }
            }
            redirect($this->uri->segment(1).'/absensi_siswa_harian?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas').'&tanggal='.$this->input->post('tanggal'));
        }else{
            if ($this->input->get('tanggal')==''){
                $data['tanggal'] = date('Y-m-d');
            }else{
                $data['tanggal'] = tgl_simpan($this->input->get('tanggal'));
            }
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $kehadiran = $this->model_app->view('rb_kehadiran');
            $data = array('kehadiran' => $kehadiran,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa_harian',$data);
        }
    }

    function rekap_absensi_siswa(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa_rekap',$data);
    }

    function rekap_absensi_siswa_print(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->load->view('administrator/mod_absensi_siswa/absensi_siswa_rekap_print',$data);
    }

    function rekap_absensi_kelas(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $data['kelas'] = $this->model_app->view_where("rb_kelas",array('id_kelas'=>$this->input->get('kelas')))->row_array();
        $data['tahun'] = $this->model_app->view_where("rb_tahun_akademik",array('id_tahun_akademik'=>$this->input->get('tahun')))->row_array();
        $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa_rekap_kelas',$data);
    }

    function rekap_absensi_kelas_harian(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $data['kelas'] = $this->model_app->view_where("rb_kelas",array('id_kelas'=>$this->input->get('kelas')))->row_array();
        $data['tahun'] = $this->model_app->view_where("rb_tahun_akademik",array('id_tahun_akademik'=>$this->input->get('tahun')))->row_array();
        $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa_rekap_kelas_harian',$data);
    }

    function detail_absensi_siswa_jurnal(){
        cek_session_akses('absensi_siswa',$this->session->id_session);
        $tanggal = tgl_simpan($this->input->get('tanggal'));
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $jurnal_kbm = $this->model_app->view_where_ordering('rb_journal_list',array('kodejdwl'=>$id),'id_journal','DESC');
        $kehadiran = $this->model_app->view('rb_kehadiran');
        $cekjurnal = $this->db->query("SELECT * FROM rb_journal_list where kodejdwl='".$this->uri->segment(3)."' AND tanggal='$tanggal'")->row_array();
        $data = array('s' => $edit,'jurnal_kbm'=>$jurnal_kbm,'kehadiran'=>$kehadiran,'row'=>$cekjurnal);
        $this->template->load('administrator/template','administrator/mod_absensi_siswa/absensi_siswa_jurnal',$data);

    }

    // function forum(){
    //     cek_session_akses('forum',$this->session->id_session);
    //     $record = $this->model_app->jadwal_pelajaran_all();
    //     $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
    //     $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
    //     $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
    //     $this->template->load('administrator/template','administrator/mod_forum/view',$data);
    // }

    function detail_forum(){
        cek_session_akses('forum',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $forum = $this->model_app->view_where_ordering('rb_forum_topic',array('kodejdwl'=>$id),'id_forum_topic','DESC');
        $data = array('s' => $edit,'forum'=>$forum);
        $this->template->load('administrator/template','administrator/mod_forum/forum',$data);
    }

    function tambah_forum(){
        cek_session_akses('forum',$this->session->id_session);
        if (isset($_POST['submit'])){
                $data = array('kodejdwl'=>$this->uri->segment(3),
                                'judul_topic'=>$this->input->post('a'),
                                'isi_topic'=>$this->input->post('b'),
                                'waktu'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_forum_topic',$data);
            redirect($this->uri->segment(1).'/detail_forum/'.$this->uri->segment(3));
        }else{
            $this->template->load('administrator/template','administrator/mod_forum/tambah');
        }
    }

    function detail_topic_forum(){
        cek_session_akses('forum',$this->session->id_session);
        if (isset($_POST['submit'])){
                $data = array('id_forum_topic'=>$this->input->get('id_topic'),
                                'nisn_nip'=>$this->input->post('users'),
                                'isi_komentar'=>$this->input->post('a'),
                                'waktu_komentar'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_forum_komentar',$data);
            redirect($this->uri->segment(1).'/detail_topic_forum?kodejdwl='.$this->input->get('kodejdwl').'&id_topic='.$this->input->get('id_topic'));
        }else{
            $topic_detail = $this->model_app->detail_topic_forum()->row_array();
            $data = array('topic' => $topic_detail);
            $this->template->load('administrator/template','administrator/mod_forum/detail',$data);
        }
    }

    function delete_topic_forum(){
        cek_session_akses('forum',$this->session->id_session);
        $id = array('id_forum_topic' => $this->input->get('id_topic'),'kodejdwl'=>$this->input->get('kodejdwl'));
        $this->model_app->delete('rb_forum_topic',$id);
        redirect($this->uri->segment(1).'/detail_forum/'.$this->input->get('kodejdwl'));
    }

    function delete_komentar_forum(){
        cek_session_akses('forum',$this->session->id_session);
        $id = array('id_forum_komentar' => $this->input->get('komentar'),'id_forum_topic'=>$this->input->get('id_topic'));
        $this->model_app->delete('rb_forum_komentar',$id);
        redirect($this->uri->segment(1).'/detail_topic_forum?kodejdwl='.$this->input->get('kodejdwl').'&id_topic='.$this->input->get('id_topic'));
    }

    function nilai_uts(){
        cek_session_akses('nilai_uts',$this->session->id_session);
        $record = $this->model_app->mata_pelajaran_semester(1); // angka 1 artinya Kurikulum 2013
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');

        $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
        $this->template->load('administrator/template','administrator/mod_penilaian/nilai_uts',$data);
    }

    function detail_nilai_uts(){
        cek_session_akses('nilai_uts',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
              if ($id_siswa!=''){
                    $cek = $this->model_app->view_where('rb_nilai_uts',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa));
                    if ($cek->num_rows() >= '1'){
                        $data = array('angka_pengetahuan'=>$a,
                                'angka_keterampilan'=>$b);
                        $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa);
                        $this->model_app->update('rb_nilai_uts', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'angka_pengetahuan'=>$a,
                                    'deskripsi_pengetahuan'=>'-',
                                    'angka_keterampilan'=>$b,
                                    'deskripsi_keterampilan'=>'-',
                                    'waktu_input_uts'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_uts',$data);
                    }
                }
            }
            redirect($this->uri->segment(1).'/detail_nilai_uts/'.$this->uri->segment(3));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_uts_detail',$data);
        }
    }

    function nilai_ekstrakurikuler(){
        cek_session_akses('nilai_ekstrakurikuler',$this->session->id_session);
        if (isset($_POST['simpan'])){
            if ($_POST['status']=='Update'){
              $data = array('kegiatan'=>$this->input->post('jenis').''.$this->input->post('a'),
                    'nilai'=>$this->input->post('b'),
                    'deskripsi'=>$this->input->post('c'));
                $where = array('id_nilai_extrakulikuler' => $this->input->post('id'));
                $this->model_app->update('rb_nilai_extrakulikuler', $data, $where);
            }else{
              $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                        'id_siswa'=>$this->input->post('id_siswa'),
                        'id_kelas'=>$this->input->get('kelas'),
                        'kegiatan'=>$this->input->post('jenis').''.$this->input->post('a'),
                        'nilai'=>$this->input->post('b'),
                        'deskripsi'=>$this->input->post('c'),
                        'user_akses'=>$this->session->id_session,
                        'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_nilai_extrakulikuler',$data);
            }
            redirect($this->uri->segment(1).'/nilai_ekstrakurikuler?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/nilai_ekstrakurikuler',$data);
        }
    }

    function delete_nilai_ekstrakurikuler(){
        cek_session_akses('nilai_ekstrakurikuler',$this->session->id_session);
        $id = array('id_nilai_extrakulikuler' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_extrakulikuler',$id);
        redirect($this->uri->segment(1).'/nilai_ekstrakurikuler?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
    }
    
    function nilai_pkl(){
        cek_session_akses('nilai_pkl',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $a = $this->input->post('a').";".$this->input->post('b');
            $b = $this->input->post('c').";".$this->input->post('d');
            if ($_POST['status']=='Update'){
              $data = array('jenis_kegiatan'=>$a,
                    'keterangan'=>$b);
                $where = array('id_nilai_pkl' => $this->input->post('id'));
                $this->model_app->update('rb_nilai_pkl', $data, $where);
            }else{
              $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                        'id_siswa'=>$this->input->post('id_siswa'),
                        'id_kelas'=>$this->input->get('kelas'),
                        'jenis_kegiatan'=>$a,
                        'keterangan'=>$b,
                        'user_akses'=>$this->session->id_session,
                        'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_nilai_pkl',$data);
            }
            redirect($this->uri->segment(1).'/nilai_pkl?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/nilai_pkl',$data);
        }
    }

    function delete_nilai_pkl(){
        cek_session_akses('nilai_pkl',$this->session->id_session);
        $id = array('id_nilai_pkl' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_pkl',$id);
        redirect($this->uri->segment(1).'/nilai_pkl?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
    }
    

    function nilai_prestasi(){
        cek_session_akses('nilai_prestasi',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $a = $this->input->post('a');
            $b = $this->input->post('b');
            if ($_POST['status']=='Update'){
              $data = array('jenis_kegiatan'=>$a,
                    'keterangan'=>$b);
                $where = array('id_nilai_prestasi' => $this->input->post('id'));
                $this->model_app->update('rb_nilai_prestasi', $data, $where);
            }else{
              $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                        'id_siswa'=>$this->input->post('id_siswa'),
                        'id_kelas'=>$this->input->get('kelas'),
                        'jenis_kegiatan'=>$a,
                        'keterangan'=>$b,
                        'user_akses'=>$this->session->id_session,
                        'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_nilai_prestasi',$data);
            }
            redirect($this->uri->segment(1).'/nilai_prestasi?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/nilai_prestasi',$data);
        }
    }
    
    function delete_nilai_prestasi(){
        cek_session_akses('nilai_prestasi',$this->session->id_session);
        $id = array('id_nilai_prestasi' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_prestasi',$id);
        redirect($this->uri->segment(1).'/nilai_prestasi?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
    }
    
    function karakter(){
        cek_session_akses('karakter',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $a = $this->input->post('a');
            $b = $this->input->post('b');
            if ($_POST['status']=='Update'){
              $data = array('jenis_kegiatan'=>$a,
                    'keterangan'=>$b);
                $where = array('id_nilai_karakter' => $this->input->post('id'));
                $this->model_app->update('rb_nilai_karakter', $data, $where);
            }else{
              $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                        'id_siswa'=>$this->input->post('id_siswa'),
                        'id_kelas'=>$this->input->get('kelas'),
                        'jenis_kegiatan'=>$a,
                        'keterangan'=>$b,
                        'user_akses'=>$this->session->id_session,
                        'waktu_input'=>date('Y-m-d H:i:s'));
                $this->model_app->insert('rb_nilai_karakter',$data);
            }
            redirect($this->uri->segment(1).'/karakter?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/nilai_karakter',$data);
        }
    }

    function karakter_transfer(){
        cek_session_akses('karakter',$this->session->id_session);
        $nilai = $this->db->query("SELECT a.nilai_pengetahuan, a.nilai_keterampilan, a.id_siswa FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl 
                                        JOIN rb_siswa c ON a.id_siswa=c.id_siswa JOIN rb_mata_pelajaran d ON b.id_mata_pelajaran=d.id_mata_pelajaran
                                    where b.id_tahun_akademik='".$this->input->post('tahun')."' AND c.id_kelas='".$this->input->post('kelas')."' AND d.karakter='".$this->input->post('karakter')."'");
        foreach ($nilai->result_array() as $row) {
            $ket = $this->db->query("SELECT keterangan FROM `rb_predikat_karakter` where nilaia<='".number_format($row['nilai_pengetahuan'])."' AND nilaib>='".number_format($row['nilai_pengetahuan'])."' AND penilaian='".$this->input->post('karakter')."'")->row_array();
                $data = array('id_tahun_akademik'=>$this->input->post('tahun'),
                        'id_siswa'=>$row['id_siswa'],
                        'id_kelas'=>$this->input->post('kelas'),
                        'jenis_kegiatan'=>$this->input->post('karakter'),
                        'keterangan'=>$ket['keterangan'],
                        'user_akses'=>$this->session->id_session,
                        'waktu_input'=>date('Y-m-d H:i:s'));
                $cek = $this->db->query("SELECT * FROM rb_nilai_karakter where id_siswa='$row[id_siswa]' AND id_tahun_akademik='".$this->input->post('tahun')."' AND jenis_kegiatan='".$this->input->post('karakter')."'");
                if ($row['nilai_pengetahuan']!='' AND $row['nilai_pengetahuan']!='0'){
                    if ($cek->num_rows()>=1){
                        $where = array('id_tahun_akademik' => $this->input->post('tahun'), 'id_siswa'=>$row['id_siswa'], 'jenis_kegiatan'=>$this->input->post('karakter'));
                        $this->model_app->update('rb_nilai_karakter', $data, $where);
                    }else{
                        $this->model_app->insert('rb_nilai_karakter',$data);
                    }
                }
        }
        redirect($this->uri->segment(1).'/karakter?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas'));
    }

    function delete_karakter(){
        cek_session_akses('karakter',$this->session->id_session);
        $id = array('id_nilai_karakter' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_karakter',$id);
        redirect($this->uri->segment(1).'/karakter?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
    }

    function catatan_wakel(){
        cek_session_akses('catatan_wakel',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
            $id_siswa  = $_POST['id_siswa'.$ia];
            $catatan  = $_POST['catatan'.$ia];
            $cek = $this->db->query("SELECT * FROM rb_nilai_catatan_wakel a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_siswa='$id_siswa' AND b.id_kelas='".$this->input->post('kelas')."' AND a.id_tahun_akademik='".$this->input->post('tahun')."'");
                if ($cek->num_rows() >= '1'){
                    $data = array('deskripsi'=>$catatan);
                    $where = array('id_tahun_akademik' => $this->input->post('tahun'),'id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->post('tahun'));
                    $this->model_app->update('rb_nilai_catatan_wakel', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->post('tahun'),
                                'id_siswa'=>$id_siswa,
                                'deskripsi'=>$catatan,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_catatan_wakel',$data);
                }
            }
            redirect($this->uri->segment(1).'/catatan_wakel?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/catatan_wali_kelas',$data);
        }
    }
    
    function catatan_akademik(){
        cek_session_akses('catatan_akademik',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
            $id_siswa  = $_POST['id_siswa'.$ia];
            $catatan  = $_POST['catatan'.$ia];
            $cek = $this->db->query("SELECT * FROM rb_nilai_catatan_akademik a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_siswa='$id_siswa' AND b.id_kelas='".$this->input->post('kelas')."' AND a.id_tahun_akademik='".$this->input->post('tahun')."'");
                if ($cek->num_rows() >= '1'){
                    $data = array('deskripsi'=>$catatan);
                    $where = array('id_tahun_akademik' => $this->input->post('tahun'),'id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->post('tahun'));
                    $this->model_app->update('rb_nilai_catatan_akademik', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->post('tahun'),
                                'id_siswa'=>$id_siswa,
                                'deskripsi'=>$catatan,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_catatan_akademik',$data);
                }
            }
            redirect($this->uri->segment(1).'/catatan_akademik?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/mod_penilaian/catatan_akademik',$data);
        }
    }

    function nilai_sikap(){
        cek_session_akses('nilai_sikap',$this->session->id_session);
        if (isset($_POST['simpan'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
                $cek = $this->model_app->view_where('rb_nilai_sikap',array('id_tahun_akademik'=>$this->input->get('tahun'),'id_siswa'=>$id_siswa,'status'=>$this->input->post('status')));
                if ($cek->num_rows() >= '1'){
                    $data = array('kode_indikator'=>$a,
                            'deskripsi'=>$b);
                    $where = array('id_tahun_akademik' => $this->input->get('tahun'),'id_siswa'=>$id_siswa,'status'=>$this->input->post('status'));
                    $this->model_app->update('rb_nilai_sikap', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->get('tahun'),
                                'id_siswa'=>$id_siswa,
                                'kode_indikator'=>$a,
                                'deskripsi'=>$b,
                                'status'=>$this->input->post('status'),
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_sikap',$data);
                }
            }
            redirect($this->uri->segment(1).'/nilai_sikap?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }else{
            $siswa = $this->model_app->siswa('',$this->input->get('kelas'));
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_sikap',$data);
        }
    }

    function sikap_penilaian_diri(){
        cek_session_akses('nilai_sikap',$this->session->id_session);
        $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
        $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
        $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
        $this->template->load('administrator/template','administrator/mod_penilaian/sikap_penilaian_diri',$data);
    }

    function sikap_penilaian_teman(){
        cek_session_akses('nilai_sikap',$this->session->id_session);
        $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
        $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
        $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
        $this->template->load('administrator/template','administrator/mod_penilaian/sikap_penilaian_teman',$data);
    }

    function delete_nilai_sikap(){
        cek_session_akses('nilai_sikap',$this->session->id_session);
        $id = array('id_nilai_sikap' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_sikap',$id);
        redirect($this->uri->segment(1).'/nilai_sikap?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
    }

    function spiritual_dan_sosial(){
        cek_session_akses('spiritual_dan_sosial',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
                $cek = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_aspek'=>$this->input->post('aspek')));
                if ($cek->num_rows() >= '1'){
                    $data = array('nilai1'=>$a,
                                  'nilai2'=>$b,
                                  'nilai3'=>$c,
                                  'nilai4'=>$d);
                    $where = array('kodejdwl'=>$this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_aspek'=>$this->input->post('aspek'));
                    $this->model_app->update('rb_nilai_sikap_spiritual_sosial', $data, $where);
                }else{
                  $data = array('kodejdwl'=>$this->input->post('kodejdwl'),
                                'id_siswa'=>$id_siswa,
                                'id_aspek'=>$this->input->post('aspek'),
                                'nilai1'=>$a,
                                'nilai2'=>$b,
                                'nilai3'=>$c,
                                'nilai4'=>$d,
                                'penilaian'=>$this->input->post('penilaian'),
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_sikap_spiritual_sosial',$data);
                }
            }
            redirect($this->uri->segment(1).'/spiritual_dan_sosial?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas').'&sikap='.$this->input->post('penilaian').'&aspek='.$this->input->post('aspek'));
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            
            $edit = $this->model_app->jadwal_pelajaran_sikap($this->input->get('sikap'),$this->input->get('kelas'),$this->input->get('tahun'))->row_array();
            $data = array('s' => $edit,'record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
            if ($this->session->level=='guru'){
                if ($_GET['kelas']!='' AND $_GET['tahun']!=''){
                    $this->template->load('administrator/template','administrator/mod_penilaian/sikap/spiritual_dan_sosial_guru_detail',$data);
                }else{
                    $this->template->load('administrator/template','administrator/mod_penilaian/sikap/spiritual_dan_sosial_guru_k13',$data);
                }
            }else{
                $this->template->load('administrator/template','administrator/mod_penilaian/sikap/spiritual_dan_sosial',$data);
            }
        }
    }

    function pengolahan_spiritual_dan_sosial(){
        cek_session_akses('spiritual_dan_sosial',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $deskripsi  = $_POST['deskripsi'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
                $cek = $this->model_app->view_where('rb_nilai_sikap',array('kodejdwl'=>$this->input->post('kodejdwl'),'id_siswa'=>$id_siswa));
                if ($cek->num_rows() >= '1'){
                    $data = array('id_nilai_sikap_deskripsi'=>$deskripsi);
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa);
                    $this->model_app->update('rb_nilai_sikap', $data, $where);
                }else{
                  $data = array('kodejdwl'=>$this->input->post('kodejdwl'),
                                'id_siswa'=>$id_siswa,
                                'id_nilai_sikap_deskripsi'=>$deskripsi,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_sikap',$data);
                }
            }
            redirect($this->uri->segment(1).'/pengolahan_spiritual_dan_sosial?tahun='.$this->input->post('tahun').'&kelas='.$this->input->post('kelas').'&sikap='.$this->input->post('penilaian'));
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            
            $edit = $this->model_app->jadwal_pelajaran_sikap($this->input->get('sikap'),$this->input->get('kelas'),$this->input->get('tahun'))->row_array();
            $data = array('s' => $edit,'record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/mod_penilaian/sikap/spiritual_dan_sosial_pengolahan',$data);
        }
    }

    function nilai_lisan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_lisan_guru',$data);
        }else{
          $record = $this->model_app->mata_pelajaran_semester(1);
          $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
          $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
          $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
          $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_lisan',$data);
        }
    }

    function detail_nilai_lisan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_lisan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($id_siswa!=''){
                  if ($this->input->post('kategori_nilai')=='3'){
                    $cek = $this->db->query("SELECT * FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.kodejdwl='".$this->uri->segment(3)."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                  }else{
                    $cek = $this->model_app->view_where('rb_nilai_pengetahuan',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai')));
                  }
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai'=>$a);
                        if ($this->input->post('kategori_nilai')=='3'){
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }else{
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }
                        $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai'=>$a,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);
                    }
                   }
                }
                redirect($this->uri->segment(1).'/detail_nilai_lisan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_lisan_detail',$data);
        }
    }

    function nilai_tertulis(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_tertulis_guru',$data);
        }else{
          $record = $this->model_app->mata_pelajaran_semester(1);
          $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
          $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
          $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
          $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_tertulis',$data);
        }
    }

    function detail_nilai_tertulis(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_tertulis/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($id_siswa!=''){
                  if ($this->input->post('kategori_nilai')=='3'){
                    $cek = $this->db->query("SELECT * FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.kodejdwl='".$this->uri->segment(3)."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                  }else{
                    $cek = $this->model_app->view_where('rb_nilai_pengetahuan',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai')));
                  }
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai'=>$a);
                        if ($this->input->post('kategori_nilai')=='3'){
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }else{
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }
                        $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai'=>$a,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);
                    }
                }  
                }
                redirect($this->uri->segment(1).'/detail_nilai_tertulis/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_tertulis_detail',$data);
        }
    }

    function nilai_penugasan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_penugasan_guru',$data);
        }else{
          $record = $this->model_app->mata_pelajaran_semester(1);
          $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
          $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
          $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
          $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_penugasan',$data);
        }
    }

    function detail_nilai_penugasan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_penugasan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($id_siswa!=''){
                  if ($this->input->post('kategori_nilai')=='3'){
                    $cek = $this->db->query("SELECT * FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.kodejdwl='".$this->uri->segment(3)."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                  }else{
                    $cek = $this->model_app->view_where('rb_nilai_pengetahuan',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai')));
                  }
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai'=>$a);
                        if ($this->input->post('kategori_nilai')=='3'){
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }else{
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }
                        $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai'=>$a,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);
                    }
                  }
                }
                redirect($this->uri->segment(1).'/detail_nilai_penugasan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_penugasan_detail',$data);
        }
    }

    function nilai_uts_kd(){
        cek_session_akses('nilai_uts_kd',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_uts_guru',$data);
        }else{
          $record = $this->model_app->mata_pelajaran_semester(1);
          $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
          $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
          $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
          $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_uts',$data);
        }
    }

    function detail_nilai_uts_kd(){
        cek_session_akses('nilai_uts_kd',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_uts_kd/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($this->input->post('kategori_nilai')=='3'){
                    $cek = $this->db->query("SELECT * FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.kodejdwl='".$this->uri->segment(3)."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                  }else{
                    $cek = $this->model_app->view_where('rb_nilai_pengetahuan',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai')));
                  }
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai'=>$a);
                        if ($this->input->post('kategori_nilai')=='3'){
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }else{
                            $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }
                        $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai'=>$a,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);
                    }
                }
                redirect($this->uri->segment(1).'/detail_nilai_uts_kd/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_uts_detail',$data);
        }
    }


    function nilai_pengetahuan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_pengetahuan_guru',$data);
        }elseif($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->mata_pelajaran_semester_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'thn'=>$thn);

            $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='".$this->session->id_kelas."'")->row_array();
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_pengetahuan_siswa',$data);

        }else{
            $record = $this->model_app->mata_pelajaran_semester(1);
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_pengetahuan',$data);
        }
    }

    function detail_nilai_pengetahuan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('kodejdwl' => $this->input->post('kodejdwl'),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_pengetahuan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($id_siswa!=''){
                  if ($this->input->post('kategori_nilai')=='3'){
                    $cek = $this->db->query("SELECT * FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.kodejdwl='".$this->uri->segment(3)."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."' AND a.id_kompetensi_dasar='".$this->input->post('kd')."'");
                  }else{
                    $cek = $this->model_app->view_where('rb_nilai_pengetahuan',array('kodejdwl'=>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai')));
                  }
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai'=>$a);
                        if ($this->input->post('kategori_nilai')=='3'){
                            $where = array('kodejdwl' =>$this->uri->segment(3),'id_siswa'=>$id_siswa,'kategori_nilai'=>$this->input->post('kategori_nilai'),'id_kompetensi_dasar'=>$this->input->post('kd'));
                        }else{
                            $where = array('kodejdwl' =>$this->uri->segment(3),'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        }
                        $this->model_app->update('rb_nilai_pengetahuan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai'=>$a,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>tgl_simpan($this->input->post('tanggal')),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_pengetahuan',$data);
                    }
                  }
                }
                redirect($this->uri->segment(1).'/detail_nilai_pengetahuan/'.$this->uri->segment(3).'?tanggal='.$this->input->post('tanggal').'&kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_pengetahuan_detail',$data);
        }
    }

    function pengolahan_nilai_pengetahuan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->template->load('administrator/template','administrator/mod_penilaian/pengetahuan/nilai_pengetahuan_pengolahan',$data);
    }
    
    function pengolahan_nilai_pengetahuan_hapus(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        //$id = array('id_kompetensi_dasar' => $this->input->get('kd'),'kodejdwl'=>$this->input->get('kodejdwl'));
        //$this->model_app->delete('rb_nilai_pengetahuan',$id);
        $this->db->query("DELETE rb_nilai_pengetahuan FROM rb_nilai_pengetahuan INNER JOIN rb_jadwal_pelajaran ON rb_jadwal_pelajaran.kodejdwl=rb_nilai_pengetahuan.kodejdwl WHERE rb_jadwal_pelajaran.id_mata_pelajaran='$_GET[mapel]' AND rb_jadwal_pelajaran.id_tahun_akademik='$_GET[tahun]' AND rb_jadwal_pelajaran.id_kelas='$_GET[kelas]' AND rb_nilai_pengetahuan.id_kompetensi_dasar='$_GET[kd]'");
        redirect($this->uri->segment(1)."/pengolahan_nilai_pengetahuan/".$this->input->get('kodejdwl'));
    }

    function pengolahan_nilai_pengetahuan_cetak(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->load->view('administrator/mod_penilaian/pengetahuan/nilai_pengetahuan_pengolahan_cetak',$data);
    }

    function remedial_pengetahuan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = $this->input->get('kodejdwl');
        if(isset($_POST['simpan'])){
            $data = array('kodejdwl'=>$this->input->get('kodejdwl'),
                        'id_siswa'=>$this->input->get('siswa'),
                        'id_kompetensi_dasar'=>$this->input->get('kd'),
                        'nilai_remedial'=>$this->input->post('nilai'),
                        'waktu'=>$this->input->post('waktu'));
            $this->model_app->insert('rb_nilai_remedial_pengetahuan',$data);
            redirect($this->uri->segment(1)."/remedial_pengetahuan?kodejdwl=".$this->input->get('kodejdwl')."&kd=".$this->input->get('kd')."&siswa=".$this->input->get('siswa'));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->load->view('administrator/mod_penilaian/remedial_pengetahuan',$data);
        }
    }

    function delete_remedial_pengetahuan(){
        cek_session_akses('nilai_pengetahuan',$this->session->id_session);
        $id = array('id_nilai_remedial_pengetahuan' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_remedial_pengetahuan',$id);
        redirect($this->uri->segment(1)."/remedial_pengetahuan?kodejdwl=".$this->input->get('kodejdwl')."&kd=".$this->input->get('kd')."&siswa=".$this->input->get('siswa'));
    }

    function nilai_keterampilan(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_keterampilan_guru',$data);
        }elseif($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->mata_pelajaran_semester_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'thn'=>$thn);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_keterampilan_siswa',$data);
        }else{
            $record = $this->model_app->mata_pelajaran_semester(1);
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_keterampilan',$data);
        }
    }

    function detail_nilai_keterampilan(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            if ($this->input->post('kd_pindah')!=''){
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $id_nilai_keterampilan = $_POST['id_nilai_keterampilan'.$ia];
                    $data = array('id_kompetensi_dasar'=>$this->input->post('kd_pindah'));
                    $where = array('id_nilai_keterampilan' => $id_nilai_keterampilan,'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                    $this->model_app->update('rb_nilai_keterampilan', $data, $where);
                }
                redirect($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3).'?kd='.$this->input->post('kd'));
            }else{
                $jumls = $this->input->post('jumlah');
                for ($ia=1; $ia<=$jumls; $ia++){
                  $a  = $_POST['a'.$ia];
                  $b  = $_POST['b'.$ia];
                  $c  = $_POST['c'.$ia];
                  $d  = $_POST['d'.$ia];
                  $id_siswa = $_POST['id_siswa'.$ia];
                  if ($id_siswa!=''){
                  $id_nilai_keterampilan = $_POST['id_nilai_keterampilan'.$ia];
                    $cek = $this->db->query("SELECT * FROM rb_nilai_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND a.id_kompetensi_dasar='".$this->input->post('kd')."' AND b.id_mata_pelajaran='".$this->input->post('id_mata_pelajaran')."' AND a.kategori_nilai='".$this->input->post('kategori_nilai')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                    if ($cek->num_rows() >= '1'){
                        $data = array('nilai1'=>$a,
                                      'nilai2'=>$b,
                                      'nilai3'=>$c,
                                      'nilai4'=>$d);
                        $where = array('id_nilai_keterampilan' => $id_nilai_keterampilan,'id_siswa'=>$id_siswa,'id_kompetensi_dasar'=>$this->input->post('kd'),'kategori_nilai'=>$this->input->post('kategori_nilai'));
                        $this->model_app->update('rb_nilai_keterampilan', $data, $where);
                    }else{
                      $data = array('kodejdwl'=>$this->uri->segment(3),
                                    'id_siswa'=>$id_siswa,
                                    'id_kompetensi_dasar'=>$this->input->post('kd'),
                                    'nilai1'=>$a,
                                    'nilai2'=>$b,
                                    'nilai3'=>$c,
                                    'nilai4'=>$d,
                                    'kategori_nilai'=>$this->input->post('kategori_nilai'),
                                    'tanggal_penilaian'=>date('Y-m-d'),
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_nilai_keterampilan',$data);
                    }
                   }
                }
            redirect($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3).'?kd='.$this->input->post('kd'));
            }
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_keterampilan_detail',$data);
        }
    }

    function pengolahan_nilai_keterampilan(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->template->load('administrator/template','administrator/mod_penilaian/nilai_keterampilan_pengolahan',$data);
    }
    
    function pengolahan_nilai_keterampilan_hapus(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        //$id = array('id_kompetensi_dasar' => $this->input->get('kd'),'kodejdwl'=>$this->input->get('kodejdwl'));
        //$this->model_app->delete('rb_nilai_keterampilan',$id);
        $this->db->query("DELETE rb_nilai_keterampilan FROM rb_nilai_keterampilan INNER JOIN rb_jadwal_pelajaran ON rb_jadwal_pelajaran.kodejdwl=rb_nilai_keterampilan.kodejdwl WHERE rb_jadwal_pelajaran.id_mata_pelajaran='$_GET[mapel]' AND rb_jadwal_pelajaran.id_tahun_akademik='$_GET[tahun]' AND rb_jadwal_pelajaran.id_kelas='$_GET[kelas]' AND rb_nilai_keterampilan.id_kompetensi_dasar='$_GET[kd]'");
        redirect($this->uri->segment(1)."/pengolahan_nilai_keterampilan/".$this->input->get('kodejdwl'));
    }

    function pengolahan_nilai_keterampilan_cetak(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
        $data = array('s' => $edit);
        $this->load->view('administrator/mod_penilaian/nilai_keterampilan_pengolahan_cetak',$data);
    }

    function remedial_keterampilan(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        $id = $this->input->get('kodejdwl');
        if(isset($_POST['simpan'])){
            $data = array('kodejdwl'=>$this->input->get('kodejdwl'),
                        'id_siswa'=>$this->input->get('siswa'),
                        'id_kompetensi_dasar'=>$this->input->get('kd'),
                        'nilai_remedial'=>$this->input->post('nilai'),
                        'waktu'=>$this->input->post('waktu'));
            $this->model_app->insert('rb_nilai_remedial_keterampilan',$data);
            redirect($this->uri->segment(1)."/remedial_keterampilan?kodejdwl=".$this->input->get('kodejdwl')."&kd=".$this->input->get('kd')."&siswa=".$this->input->get('siswa'));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->load->view('administrator/mod_penilaian/remedial_keterampilan',$data);
        }
    }

    function delete_remedial_keterampilan(){
        cek_session_akses('nilai_keterampilan',$this->session->id_session);
        $id = array('id_nilai_remedial_keterampilan' => $this->input->get('id'));
        $this->model_app->delete('rb_nilai_remedial_keterampilan',$id);
        redirect($this->uri->segment(1)."/remedial_keterampilan?kodejdwl=".$this->input->get('kodejdwl')."&kd=".$this->input->get('kd')."&siswa=".$this->input->get('siswa'));
    }

    function nilai_borongan(){
        cek_session_akses('nilai_borongan',$this->session->id_session);
        $record = $this->model_app->mata_pelajaran_semester(1);
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
        $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
        $this->template->load('administrator/template','administrator/mod_penilaian/nilai_borongan',$data);
    }

    function detail_nilai_borongan(){
        cek_session_akses('nilai_borongan',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
              $cek = $this->db->query("SELECT * FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND b.id_mata_pelajaran='".$this->input->post('id_mata_pelajaran')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
              if ($id_siswa!=''){
                if ($cek->num_rows() >= '1'){
                    $data = array('nilai_pengetahuan'=>$a,
                                  'deskripsi_pengetahuan'=>$b,
                                  'nilai_keterampilan'=>$c,
                                  'deskripsi_keterampilan'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'kodejdwl'=>$this->input->post('kodejdwl'));
                    $this->model_app->update('rb_nilai_borongan', $data, $where);
                }else{
                  $data = array('kodejdwl'=>$this->uri->segment(3),
                                'id_siswa'=>$id_siswa,
                                'nilai_pengetahuan'=>$a,
                                'deskripsi_pengetahuan'=>$b,
                                'nilai_keterampilan'=>$c,
                                'deskripsi_keterampilan'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_borongan',$data);
                }
              }
            }
            redirect($this->uri->segment(1).'/detail_nilai_borongan/'.$this->uri->segment(3));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail_borongan($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_borongan_detail',$data);
        }
    }

    function export_nilai_borongan(){
        cek_session_akses('nilai_borongan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail_borongan($id)->row_array();
        $data = array('s' => $edit);
        $this->load->view('administrator/mod_penilaian/export_nilai_borongan',$data);
    }


    function nilai_borongan_uts(){
        cek_session_akses('nilai_borongan_uts',$this->session->id_session);
        $record = $this->model_app->mata_pelajaran_semester(1);
        $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
        $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
        $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
        $this->template->load('administrator/template','administrator/mod_penilaian/nilai_borongan_uts',$data);
    }

    function detail_nilai_borongan_uts(){
        cek_session_akses('nilai_borongan_uts',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
              $cek = $this->db->query("SELECT * FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$id_siswa' AND b.id_mata_pelajaran='".$this->input->post('id_mata_pelajaran')."' AND b.id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
              if ($id_siswa!=''){
                if ($cek->num_rows() >= '1'){
                    $data = array('nilai_pengetahuan'=>$a,
                                  'deskripsi_pengetahuan'=>$b,
                                  'nilai_keterampilan'=>$c,
                                  'deskripsi_keterampilan'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'kodejdwl'=>$this->input->post('kodejdwl'));
                    $this->model_app->update('rb_nilai_borongan_uts', $data, $where);
                }else{
                  $data = array('kodejdwl'=>$this->uri->segment(3),
                                'id_siswa'=>$id_siswa,
                                'nilai_pengetahuan'=>$a,
                                'deskripsi_pengetahuan'=>$b,
                                'nilai_keterampilan'=>$c,
                                'deskripsi_keterampilan'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_borongan_uts',$data);
                }
              }
            }
            redirect($this->uri->segment(1).'/detail_nilai_borongan_uts/'.$this->uri->segment(3));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail_borongan($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_borongan_uts_detail',$data);
        }
    }

    function export_nilai_borongan_uts(){
        cek_session_akses('nilai_borongan_uts',$this->session->id_session);
        $id = $this->uri->segment(3);
        $edit = $this->model_app->jadwal_pelajaran_detail_borongan($id)->row_array();
        $data = array('s' => $edit);
        $this->load->view('administrator/mod_penilaian/export_nilai_borongan_uts',$data);
    }


    function nilai_borongan_sikap(){
        cek_session_akses('nilai_borongan_sikap',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
              $cek = $this->db->query("SELECT * FROM rb_nilai_borongan_sikap where id_siswa='$id_siswa' AND id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
              if ($id_siswa!=''){
                if ($cek->num_rows() >= '1'){
                    $data = array('nilai_spiritual'=>$a,
                                  'deskripsi_spiritual'=>$b,
                                  'nilai_sosial'=>$c,
                                  'deskripsi_sosial'=>$d);
                    $where = array('id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'));
                    $this->model_app->update('rb_nilai_borongan_sikap', $data, $where);
                }else{
                  $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                                'id_siswa'=>$id_siswa,
                                'nilai_spiritual'=>$a,
                                'deskripsi_spiritual'=>$b,
                                'nilai_sosial'=>$c,
                                'deskripsi_sosial'=>$d,
                                'user_akses'=>$this->session->id_session,
                                'waktu'=>date('Y-m-d H:i:s'));
                    $this->model_app->insert('rb_nilai_borongan_sikap',$data);
                }
              }
            }
            redirect($this->uri->segment(1).'/nilai_borongan_sikap?tahun='.$this->input->post('id_tahun_akademik').'&kelas='.$this->input->post('id_kelas'));
        }else{
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/unit_smk/mod_penilaian/nilai_borongan_sikap',$data);
        }
    }

    function export_nilai_borongan_sikap(){
        cek_session_akses('nilai_borongan_sikap',$this->session->id_session);
        $id = $this->uri->segment(3);
        $this->load->view('administrator/mod_penilaian/export_nilai_borongan_sikap',$data);
    }
    
    function absensi_borongan(){
        cek_session_akses('absensi_borongan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $jumls = $this->input->post('jumlah');
            for ($ia=1; $ia<=$jumls; $ia++){
              $a  = $_POST['a'.$ia];
              $b  = $_POST['b'.$ia];
              $c  = $_POST['c'.$ia];
              $d  = $_POST['d'.$ia];
              $id_siswa = $_POST['id_siswa'.$ia];
                $cek = $this->db->query("SELECT * FROM rb_absensi_borongan where id_siswa='$id_siswa' AND id_tahun_akademik='".$this->input->post('id_tahun_akademik')."'");
                if ($id_siswa!=''){
                    if ($cek->num_rows() >= '1'){
                        $data = array('sakit'=>$a,
                                      'izin'=>$b,
                                      'alpa'=>$c,
                                      'hadir'=>$d);
                        $where = array('id_siswa'=>$id_siswa,'id_tahun_akademik'=>$this->input->post('id_tahun_akademik'));
                        $this->model_app->update('rb_absensi_borongan', $data, $where);
                    }else{
                      $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                                    'id_siswa'=>$id_siswa,
                                    'sakit'=>$a,
                                    'izin'=>$b,
                                    'alpa'=>$c,
                                    'hadir'=>$d,
                                    'user_akses'=>$this->session->id_session,
                                    'waktu'=>date('Y-m-d H:i:s'));
                        $this->model_app->insert('rb_absensi_borongan',$data);
                    }
                }
            }
            redirect($this->uri->segment(1).'/absensi_borongan?tahun='.$this->input->post('id_tahun_akademik').'&kelas='.$this->input->post('id_kelas'));
        }else{
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_penilaian/absensi_borongan',$data);
        }
    }

    function export_absensi_borongan(){
        cek_session_akses('absensi_borongan',$this->session->id_session);
        $id = $this->uri->segment(3);
        $this->load->view('administrator/mod_penilaian/export_absensi_borongan',$data);
    }

    function nilai_observasi(){
        cek_session_akses('nilai_observasi',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->jadwal_pelajaran_guru_kurikulum($thn['id_tahun_akademik'],1);
            $data = array('record' => $record, 'nama_tahun'=>$thn['nama_tahun']);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_guru',$data);
        }else{
            $record = $this->model_app->jadwal_pelajaran(1); // Angka 1 adalah Kurikulum 2013
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $kelas = $this->model_app->view_join_where('rb_kelas.*','rb_kelas','rb_tingkat','id_tingkat',array('rb_kelas.id_identitas_sekolah'=>$this->session->sekolah,'rb_tingkat.kode_kurikulum'=>1),'id_kelas','ASC');
            $data = array('record' => $record,'tahun' => $tahun,'kelas' => $kelas);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi',$data);
        }
    }

    function detail_nilai_observasi(){
        cek_session_akses('nilai_observasi',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kodejdwl'=>$this->uri->segment(3),
                            'id_siswa'=>$this->input->post('b'),
                            'status_sikap'=>$this->input->post('status'),
                            'waktu_terjadi'=>tgl_simpan($this->input->post('a')),
                            'kejadian_perilaku'=>$this->input->post('c'),
                            'id_butir_sikap'=>$this->input->post('d'),
                            'positif_negatif'=>$this->input->post('e'),
                            'tindak_lanjut'=>$this->input->post('f'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_nilai_sikap_butir',$data);
            redirect($this->uri->segment(1).'/detail_nilai_observasi/'.$this->uri->segment(3));
        }else{
            $edit = $this->model_app->jadwal_pelajaran_detail($id)->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_detail',$data);
        }
    }

    function delete_nilai_observasi(){
        cek_session_akses('nilai_observasi',$this->session->id_session);
        $id = array('id_nilai_sikap_butir' => $this->uri->segment(3));
        $this->model_app->delete('rb_nilai_sikap_butir',$id);
        redirect($this->uri->segment(1).'/detail_nilai_observasi/'.$this->uri->segment(4));
    }

    function nilai_observasi_wakel(){
        cek_session_akses('nilai_observasi_wakel',$this->session->id_session);
        if($this->session->level=='guru'){
          $data['record'] = $this->db->query("SELECT a.id_kelas, a.kode_kelas, a.nama_kelas, a.aktif, a.nilai, b.nama_guru, c.nama_jurusan, d.nama_ruangan, e.nama_gedung, f.kode_tingkat 
                                                FROM `rb_kelas` a JOIN rb_guru b ON a.id_guru=b.id_guru 
                                                    LEFT JOIN rb_jurusan c ON a.id_jurusan=c.id_jurusan
                                                        LEFT JOIN rb_ruangan d ON a.id_ruangan=d.id_ruangan
                                                            LEFT JOIN rb_gedung e ON d.id_gedung=e.id_gedung
                                                                LEFT JOIN rb_tingkat f ON a.id_tingkat=f.id_tingkat
                                                                    where a.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_guru='".$this->session->id_session."' AND f.kode_kurikulum='1'");
        }else{
          $data['record'] = $this->db->query("SELECT a.id_kelas, a.kode_kelas, a.nama_kelas, a.aktif, a.nilai, b.nama_guru, c.nama_jurusan, d.nama_ruangan, e.nama_gedung, f.kode_tingkat 
                                                FROM `rb_kelas` a JOIN rb_guru b ON a.id_guru=b.id_guru 
                                                    LEFT JOIN rb_jurusan c ON a.id_jurusan=c.id_jurusan
                                                        LEFT JOIN rb_ruangan d ON a.id_ruangan=d.id_ruangan
                                                            LEFT JOIN rb_gedung e ON d.id_gedung=e.id_gedung
                                                                LEFT JOIN rb_tingkat f ON a.id_tingkat=f.id_tingkat
                                                                    where a.id_identitas_sekolah='".$this->session->sekolah."' AND f.kode_kurikulum='1'");
      }
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_wakel',$data);
    }

    function detail_nilai_observasi_wakel(){
        cek_session_akses('nilai_observasi_wakel',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                            'id_siswa'=>$this->input->post('b'),
                            'status_sikap'=>$this->input->post('status'),
                            'waktu_terjadi'=>tgl_simpan($this->input->post('a')),
                            'kejadian_perilaku'=>$this->input->post('c'),
                            'id_butir_sikap'=>$this->input->post('d'),
                            'positif_negatif'=>$this->input->post('e'),
                            'tindak_lanjut'=>$this->input->post('f'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_nilai_sikap_butir_walikelas',$data);
            redirect($this->uri->segment(1).'/detail_nilai_observasi_wakel/'.$this->uri->segment(3));
        }else{
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $edit = $this->model_app->wali_kelas($id)->row_array();
            $data = array('s' => $edit, 'thn'=>$thn);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_detail_wakel',$data);
        }
    }

    function delete_nilai_observasi_wakel(){
        cek_session_akses('nilai_observasi_wakel',$this->session->id_session);
        $id = array('id_nilai_sikap_butir' => $this->uri->segment(3));
        $this->model_app->delete('rb_nilai_sikap_butir_walikelas',$id);
        redirect($this->uri->segment(1).'/detail_nilai_observasi_wakel/'.$this->uri->segment(4));
    }

    function nilai_observasi_bk(){
        cek_session_akses('nilai_observasi_bk',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT a.id_kelas, a.kode_kelas, a.nama_kelas, a.aktif, a.nilai, b.nama_guru, c.nama_jurusan, d.nama_ruangan, e.nama_gedung, f.kode_tingkat 
                                                FROM `rb_kelas` a JOIN rb_guru b ON a.id_guru=b.id_guru 
                                                    LEFT JOIN rb_jurusan c ON a.id_jurusan=c.id_jurusan
                                                        LEFT JOIN rb_ruangan d ON a.id_ruangan=d.id_ruangan
                                                            LEFT JOIN rb_gedung e ON d.id_gedung=e.id_gedung
                                                                LEFT JOIN rb_tingkat f ON a.id_tingkat=f.id_tingkat
                                                                    where a.id_identitas_sekolah='".$this->session->sekolah."' AND f.kode_kurikulum='1'");
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_bk',$data);
    }

    function detail_nilai_observasi_bk(){
        cek_session_akses('nilai_observasi_bk',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                            'id_siswa'=>$this->input->post('b'),
                            'status_sikap'=>$this->input->post('status'),
                            'waktu_terjadi'=>tgl_simpan($this->input->post('a')),
                            'kejadian_perilaku'=>$this->input->post('c'),
                            'id_butir_sikap'=>$this->input->post('d'),
                            'positif_negatif'=>$this->input->post('e'),
                            'tindak_lanjut'=>$this->input->post('f'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_nilai_sikap_butir_bk',$data);
            redirect($this->uri->segment(1).'/detail_nilai_observasi_bk/'.$this->uri->segment(3));
        }else{
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $edit = $this->model_app->wali_kelas($id)->row_array();
            $data = array('s' => $edit, 'thn'=>$thn);
            $this->template->load('administrator/template','administrator/mod_penilaian/nilai_observasi_detail_bk',$data);
        }
    }

    function delete_nilai_observasi_bk(){
        cek_session_akses('nilai_observasi_bk',$this->session->id_session);
        $id = array('id_nilai_sikap_butir' => $this->uri->segment(3));
        $this->model_app->delete('rb_nilai_sikap_butir_bk',$id);
        redirect($this->uri->segment(1).'/detail_nilai_observasi_bk/'.$this->uri->segment(4));
    }

    function cetak_uts(){
        cek_session_akses('cetak_uts',$this->session->id_session);
        if ($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->mata_pelajaran_semester_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'thn'=>$thn);
            $this->template->load('administrator/template','administrator/mod_raport/uts_siswa',$data);
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
            $this->template->load('administrator/template','administrator/mod_raport/uts',$data);
        }
    }

    function cetak_uts_raport(){
        cek_session_akses('cetak_uts',$this->session->id_session);
        $edit = $this->db->query("SELECT a.*, b.nama_kelas, b.kode_kelas, c.nama_guru as wali_kelas, c.nip FROM rb_siswa a JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                    JOIN rb_guru c ON b.id_guru=c.id_guru where a.id_siswa='$_GET[siswa]'")->row_array();
        $identitas = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $kepsek = $this->model_app->view_where('rb_users',array('id_identitas_sekolah'=>$this->session->sekolah,'level'=>'kepala'))->row_array();
        $kelompok = $this->model_app->view_where('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah));
        $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        $data = array('s' => $edit,'iden' => $identitas,'kepsek' => $kepsek,'t' => $thn,'kelompok' => $kelompok);
        if ($_GET['page']=='1'){
            $this->load->view('administrator/mod_raport/uts_print1',$data);
        }elseif ($_GET['page']=='2'){
            $this->load->view('administrator/mod_raport/uts_print2',$data);
        }
    }

    function cetak_semester(){
        cek_session_akses('cetak_semester',$this->session->id_session);
        if ($this->session->level=='siswa'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $record = $this->model_app->mata_pelajaran_semester_siswa($thn['id_tahun_akademik']);
            $data = array('record' => $record, 'thn'=>$thn);
            $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='".$this->session->id_kelas."'")->row_array();
            $this->template->load('administrator/template','administrator/mod_raport/'.$kel['directory'].'/semester_siswa',$data);
        }else{
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun);
            $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
            if (isset($_GET['kelas'])){
                $this->template->load('administrator/template','administrator/mod_raport/'.$kel['directory'].'/semester',$data);
            }else{
                $this->template->load('administrator/template','administrator/mod_raport/semester',$data);
            }
        }
    }
    
    function cetak_semester_rank(){
        cek_session_akses('cetak_semester',$this->session->id_session);
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $identitas = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang where a.id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun,'iden' => $identitas);
            $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_rank',$data);
    }
    
    function leger(){
        cek_session_akses('cetak_semester',$this->session->id_session);
            $siswa = $this->model_app->siswa($this->input->get('angkatan'),$this->input->get('kelas'));
            $angkatan = $this->db->query("SELECT angkatan FROM rb_siswa where id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC");
            $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
            $tahun = $this->model_app->view_where_ordering('rb_tahun_akademik',array('id_identitas_sekolah'=>$this->session->sekolah),'id_tahun_akademik','ASC');
            $identitas = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang where a.id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            $data = array('record' => $siswa,'angkatan' => $angkatan,'kelas' => $kelas,'tahun' => $tahun,'iden' => $identitas);
            $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_leger',$data);
    }

    function cetak_semester_raport(){
        cek_session_akses('cetak_semester',$this->session->id_session);
        $edit = $this->db->query("SELECT a.*, b.nama_kelas, b.kode_kelas, c.nama_guru as wali_kelas, c.nip, d.jenis_kelamin, e.nama_agama, f.tempat_lahir_ayah, f.nama_agama_ayah, f.alamat_ayah, f.tempat_lahir_ibu, f.nama_agama_ibu, f.alamat_ibu, f.anak_ke, f.jumlah_saudara, f.sekolah_asal, f.terima_dikelas, f.terima_tanggal, f.status_anak, f.no_telpon_wali, f.alamat_wali
                                FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                    LEFT JOIN rb_guru c ON b.id_guru=c.id_guru
                                        LEFT JOIN rb_jenis_kelamin d ON a.id_jenis_kelamin=d.id_jenis_kelamin
                                            LEFT JOIN rb_agama e ON a.id_agama=e.id_agama 
                                                LEFT JOIN rb_siswa_ortu f ON a.id_siswa=f.id_siswa 
                                                where a.id_siswa='$_GET[siswa]'")->row_array();
        $identitas = $this->db->query("SELECT * FROM rb_identitas_sekolah a JOIN rb_jenjang b ON a.id_jenjang=b.id_jenjang where a.id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
        $kepsek = $this->db->query("SELECT * FROM rb_users a JOIN rb_guru b ON a.username=b.nip where a.id_identitas_sekolah='".$this->session->sekolah."' AND a.level='kepala'")->row_array();
        $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
        
        $skp = $this->db->query("SELECT a.*, c.deskripsi_sikap as deskripsi FROM rb_nilai_sikap a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_nilai_sikap_deskripsi c ON a.id_nilai_sikap_deskripsi=c.id_nilai_sikap_deskripsi where b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_siswa='".$this->input->get('siswa')."' AND b.penilaian='spiritual'")->row_array();
        $skp1 = $this->db->query("SELECT a.*, c.deskripsi_sikap as deskripsi FROM rb_nilai_sikap a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_nilai_sikap_deskripsi c ON a.id_nilai_sikap_deskripsi=c.id_nilai_sikap_deskripsi where b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_siswa='".$this->input->get('siswa')."' AND b.penilaian='sosial'")->row_array();
          

          // Untuk Mendapatkan Grade Spiritual
          $s = $this->model_app->jadwal_pelajaran_sikap('spiritual',$this->input->get('kelas'),$this->input->get('tahun'))->row_array();
          $rataasum = 0;
          $penilaian = $this->model_app->view_where_ordering('rb_aspek',array('penilaian'=>'spiritual'),'id_aspek','ASC');
          foreach ($penilaian as $k) {
            $a = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$s['kodejdwl'],'id_siswa'=>$this->input->get('siswa'),'id_aspek'=>$k['id_aspek']))->row_array();
            $rataasum = $rataasum + (($a['nilai1']+$a['nilai2']+$a['nilai3']+$a['nilai4'])/4);
          }
          $penilaian_jml = $this->model_app->view_where('rb_aspek',array('penilaian'=>'spiritual'));
          $nilai_raport = number_format($rataasum/$penilaian_jml->num_rows());
          $grade = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($nilai_raport)." >=nilaia) AND (".number_format($nilai_raport)." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='spiritual'")->row_array();
          $sikap = $this->db->query("SELECT a.* FROM rb_nilai_sikap a JOIN rb_nilai_sikap_deskripsi b ON a.id_nilai_sikap_deskripsi=b.id_nilai_sikap_deskripsi where a.kodejdwl='$s[kodejdwl]' AND a.id_siswa='".$this->input->get('siswa')."' AND b.penilaian='spiritual'")->row_array();


          // Untuk Mendapatkan Grade Sosial
          $sos = $this->model_app->jadwal_pelajaran_sikap('sosial',$this->input->get('kelas'),$this->input->get('tahun'))->row_array();
          $rataasum_sos = 0;
          $penilaian_sos = $this->model_app->view_where_ordering('rb_aspek',array('penilaian'=>'spiritual'),'id_aspek','ASC');
          foreach ($penilaian_sos as $k) {
            $a_sos = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$sos['kodejdwl'],'id_siswa'=>$this->input->get('siswa'),'id_aspek'=>$k['id_aspek']))->row_array();
            $rataasum_sos = $rataasum_sos + (($a_sos['nilai1']+$a_sos['nilai2']+$a_sos['nilai3']+$a_sos['nilai4'])/4);
          }
          $penilaian_jml_sos = $this->model_app->view_where('rb_aspek',array('penilaian'=>'sosial'));
          $nilai_raport_sos = number_format($rataasum/$penilaian_jml->num_rows());
          $grade_sos = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($nilai_raport_sos)." >=nilaia) AND (".number_format($nilai_raport_sos)." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='sosial'")->row_array();
          $sikap_sos = $this->db->query("SELECT a.* FROM rb_nilai_sikap a JOIN rb_nilai_sikap_deskripsi b ON a.id_nilai_sikap_deskripsi=b.id_nilai_sikap_deskripsi where a.kodejdwl='$sos[kodejdwl]' AND a.id_siswa='".$this->input->get('siswa')."' AND b.penilaian='sosial'")->row_array();
        
        $kelompok = $this->model_app->view_where('rb_kelompok_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah));
        $kel = $this->db->query("SELECT b.kode_kurikulum, b.kode_tingkat, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
        $data = array('kel'=>$kel, 'skp'=>$skp, 'skp1'=>$skp1, 's'=>$edit, 'iden'=>$identitas, 'kepsek'=>$kepsek, 't'=>$thn, 'kelompok'=>$kelompok, 'grade_spiritual'=>$grade['predikat_sikap'], 'grade_sosial'=>$grade_sos['predikat_sikap']);
        
        
        if ($this->input->get('page')=='1'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print1',$data);
        }elseif ($this->input->get('page')=='2'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print2',$data);
        }elseif ($this->input->get('page')=='3'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print3',$data);
        }elseif ($this->input->get('page')=='4'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print4',$data);
        }elseif ($this->input->get('page')=='5'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print5',$data);
        }elseif ($this->input->get('page')=='6'){
            $this->load->view('administrator/mod_raport/'.$kel['directory'].'/semester_print6',$data);
        }
    }

    public function import_excel_borongan(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_borongan($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/detail_nilai_borongan/'.$this->uri->segment(4));
        }
    }

    public function import_excel_borongan_uts(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_borongan($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/detail_nilai_borongan_uts/'.$this->uri->segment(4));
        }
    }

    public function import_excel_borongan_sikap(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_borongan_sikap($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/nilai_borongan_sikap?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }
    }
    
    public function import_excel_borongan_absensi(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_borongan_absensi($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/absensi_borongan?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'));
        }
    }

    public function import_excel_siswa(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_siswa($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/siswa?sukses');
        }
    }

    public function import_excel_guru(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_guru($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/guru?sukses');
        }
    }

    public function import_excel_mapel(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_mapel($this->uri->segment(3),$filename,$this->uri->segment(4));
            redirect($this->uri->segment(1).'/mata_pelajaran/'.$this->uri->segment(4).'?sukses');
        }
    }

    public function import_excel_jadwal(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_jadwal($this->uri->segment(3),$filename,$this->uri->segment(4));
            redirect($this->uri->segment(1).'/jadwal_pelajaran/'.$this->uri->segment(4).'?sukses');
        }
    }

    public function import_excel_kd(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_kd($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/detail_kompetensi_dasar/'.$this->uri->segment(4).'?sukses');
        }
    }

    public function import_excel_uas(){
        $config['upload_path'] = 'asset/'.$this->uri->segment(3);
        $config['allowed_types'] = 'xlsx|xls';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('fileexcel')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
            $filename = $upload_data['file_name'];//Nama File
            $this->model_app->import_excel_uas($this->uri->segment(3),$filename);
            redirect($this->uri->segment(1).'/detail_nilai_pengetahuan/'.$this->uri->segment(4).'?sukses');
        }
    }

    // Controller Modul Labor Kasus

    function labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_labor_kasus.*, rb_siswa.nama','rb_labor_kasus','rb_siswa','id_siswa',array('rb_siswa.id_identitas_sekolah'=>$this->session->sekolah),'rb_labor_kasus.id_labor_kasus','ASC');
        $this->template->load('administrator/template','administrator/mod_labor_kasus/view',$data);
    }

    function status_labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        if ($this->uri->segment(4)=='1'){ $status = 'Lunas'; }else{ $status = 'Belum Lunas'; }
            $data = array('status'=>$status);
            $where = array('id_labor_kasus' => $this->uri->segment(3));
            $this->model_app->update('rb_labor_kasus', $data, $where);
            redirect($this->uri->segment(1).'/labor_kasus');
    }

    function tambah_labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_siswa'=>$this->input->post('a'),
                            'nama_pratikum'=>$this->input->post('b'),
                            'judul_pratikum'=>$this->input->post('c'),
                            'tempat_praktek'=>$this->input->post('d'),
                            'waktu_praktek'=>$this->input->post('e'),
                            'kelompok'=>$this->input->post('f'),
                            'anggota_kelompok'=>$this->input->post('g'),
                            'id_user'=>$this->session->id_session,
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_labor_kasus',$data);
            $id = $this->db->insert_id();
            redirect($this->uri->segment(1).'/edit_labor_kasus/'.$id);
        }else{
            $this->template->load('administrator/template','administrator/mod_labor_kasus/tambah');
        }
    }

    function edit_labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_siswa'=>$this->input->post('a'),
                            'nama_pratikum'=>$this->input->post('b'),
                            'judul_pratikum'=>$this->input->post('c'),
                            'tempat_praktek'=>$this->input->post('d'),
                            'waktu_praktek'=>$this->input->post('e'),
                            'kelompok'=>$this->input->post('f'),
                            'anggota_kelompok'=>$this->input->post('g'));
            $where = array('id_labor_kasus' => $this->input->post('id'));
            $this->model_app->update('rb_labor_kasus', $data, $where);
            redirect($this->uri->segment(1).'/labor_kasus');
        }else{
            $edit = $this->model_app->view_where('rb_labor_kasus', array('id_labor_kasus'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_labor_kasus/edit',$data);
        }
    }

    function delete_labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        $id = array('id_labor_kasus' => $this->uri->segment(3));
        $this->model_app->delete('rb_labor_kasus',$id);
        redirect($this->uri->segment(1).'/labor_kasus');
    }

    function tambah_labor_detail(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_labor_kasus'=>$this->input->post('id'),
                            'nama_alat'=>$this->input->post('a'),
                            'kapasitas'=>$this->input->post('b'),
                            'jumlah'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_labor_kasus_detail',$data);
            redirect($this->uri->segment(1).'/edit_labor_kasus/'.$this->input->post('id').'#tab2');
        }else{
            $this->load->view('administrator/mod_labor_kasus/tambah_detail');
        }
    }

    function edit_labor_detail(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_labor_kasus'=>$this->input->post('id'),
                            'nama_alat'=>$this->input->post('a'),
                            'kapasitas'=>$this->input->post('b'),
                            'jumlah'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $where = array('id_labor_kasus_detail' => $this->input->post('idd'));
            $this->model_app->update('rb_labor_kasus_detail', $data, $where);
            redirect($this->uri->segment(1).'/edit_labor_kasus/'.$this->input->post('id').'#tab2');
        }else{
            $data['rows'] = $this->db->query("SELECT * FROM rb_labor_kasus_detail where id_labor_kasus_detail='".$this->input->post(id)."'")->row_array();
            $this->load->view('administrator/mod_labor_kasus/edit_detail',$data);
        }
    }

    function delete_labor_kasus_detail(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        $id = array('id_labor_kasus_detail' => $this->uri->segment(3));
        $this->model_app->delete('rb_labor_kasus_detail',$id);
        redirect($this->uri->segment(1).'/edit_labor_kasus/'.$this->uri->segment(4).'#tab2');
    }

    function laporan_laboratorium(){
        cek_session_akses('laporan_laboratorium',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_labor_kasus.*, rb_siswa.nama, rb_siswa.id_kelas','rb_labor_kasus','rb_siswa','id_siswa',array('rb_siswa.id_identitas_sekolah'=>$this->session->sekolah),'rb_labor_kasus.id_labor_kasus','ASC');
        $this->template->load('administrator/template','administrator/mod_labor_kasus/view_report',$data);
    }

    function print_laporan_laboratorium(){
        cek_session_akses('laporan_laboratorium',$this->session->id_session);
        $data['record'] = $this->model_app->view_join_where('rb_labor_kasus.*, rb_siswa.nama, rb_siswa.id_kelas','rb_labor_kasus','rb_siswa','id_siswa',array('rb_siswa.id_identitas_sekolah'=>$this->session->sekolah,'rb_labor_kasus.status'=>'Belum Lunas'),'rb_labor_kasus.id_labor_kasus','ASC');
        $this->load->view('administrator/mod_labor_kasus/view_report_print',$data);
    }

    function print_labor_kasus(){
        cek_session_akses('labor_kasus',$this->session->id_session);
        $data['s'] = $this->db->query("SELECT a.*, b.nama FROM rb_labor_kasus a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_labor_kasus='".$this->uri->segment(3)."'")->row_array();
        $this->load->view('administrator/mod_labor_kasus/print',$data);
    }


    // Controller Modul Jenis

    function jenis_pelanggaran(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('judul'=>$this->input->post('a'));
            $this->model_app->insert('rb_bk_jenis',$data);
            redirect($this->uri->segment(1).'/jenis_pelanggaran');
        }elseif (isset($_POST['update'])){
            $data = array('judul'=>$this->input->post('a'));
            $where = array('id_jenis' => $this->input->post('id'));
            $this->model_app->update('rb_bk_jenis', $data, $where);
            redirect($this->uri->segment(1).'/jenis_pelanggaran');
        }else{
            $data['record'] = $this->model_app->view('rb_bk_jenis');
            $this->template->load('administrator/template','administrator/mod_bk/view',$data);
        }
    }

    function jenis_pelanggaran_detail(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        $data['row'] = $this->model_app->view_where('rb_bk_jenis',array('id_jenis'=>$_GET['id']))->row_array();
        $data['record'] = $this->model_app->view_where('rb_bk_jenis_detail',array('id_jenis'=>$_GET['id']));
        $this->template->load('administrator/template','administrator/mod_bk/view_detail',$data);
    }

    function tambah_jenis_pelanggaran(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_jenis'=>$this->input->post('a'),
                          'pelanggaran'=>$this->input->post('b'),
                          'bobot'=>$this->input->post('c'),
                          'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_bk_jenis_detail',$data);
            redirect($this->uri->segment(1).'/jenis_pelanggaran_detail?id='.$this->input->post('a'));
        }else{
            $this->template->load('administrator/template','administrator/mod_bk/tambah');
        }
    }

    function edit_jenis_pelanggaran(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        $id = $this->input->get('jenis');
        if (isset($_POST['submit'])){
            $data = array('pelanggaran'=>$this->input->post('b'),
                          'bobot'=>$this->input->post('c'),
                          'keterangan'=>$this->input->post('d'));
            $where = array('id_jenis_detail' => $this->input->post('id'));
            $this->model_app->update('rb_bk_jenis_detail', $data, $where);
            redirect($this->uri->segment(1).'/jenis_pelanggaran_detail?id='.$this->input->post('a'));
        }else{
            $edit = $this->model_app->view_where('rb_bk_jenis_detail', array('id_jenis_detail'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_bk/edit',$data);
        }
    }

    function delete_jenis_pelanggaran(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        $id = array('id_jenis' => $this->uri->segment(3));
        $this->model_app->delete('rb_bk_jenis',$id);
        redirect($this->uri->segment(1).'/jenis_pelanggaran');
    }

    function delete_jenis_pelanggaran_detail(){
        cek_session_akses('jenis_pelanggaran',$this->session->id_session);
        $id = array('id_jenis_detail' => $this->uri->segment(3));
        print_r($this->uri->segment(4)); exit();
        
        $this->model_app->delete('rb_bk_jenis_detail',$id);
        redirect($this->uri->segment(1).'/jenis_pelanggaran_detail?id='.$this->uri->segment(4));
    }

    function sanksi_pelanggaran(){
        cek_session_akses('sanksi_pelanggaran',$this->session->id_session);
        $data['record'] = $this->model_app->view('rb_bk_sanksi_pelanggar');
        $this->template->load('administrator/template','administrator/mod_bk/view_sanksi',$data);
    }

    function tambah_sanksi_pelanggaran(){
        cek_session_akses('sanksi_pelanggaran',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('jenis_sanksi'=>$this->input->post('a'),
                          'bobot_dari'=>$this->input->post('b'),
                          'bobot_sampai'=>$this->input->post('c'),
                          'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_bk_sanksi_pelanggar',$data);
            redirect($this->uri->segment(1).'/sanksi_pelanggaran');
        }else{
            $this->template->load('administrator/template','administrator/mod_bk/tambah_sanksi');
        }
    }

    function edit_sanksi_pelanggaran(){
        cek_session_akses('sanksi_pelanggaran',$this->session->id_session);
        $id = $this->input->get('jenis');
        if (isset($_POST['submit'])){
            $data = array('pelanggaran'=>$this->input->post('b'),
                          'bobot'=>$this->input->post('c'),
                          'keterangan'=>$this->input->post('d'));
            $where = array('id_sanksi_pelanggar' => $this->input->post('id'));
            $this->model_app->update('rb_bk_sanksi_pelanggar', $data, $where);
            redirect($this->uri->segment(1).'/sanksi_pelanggaran');
        }else{
            $edit = $this->model_app->view_where('rb_bk_sanksi_pelanggar', array('id_sanksi_pelanggar'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_bk/edit_sanksi',$data);
        }
    }

    function delete_sanksi_pelanggaran(){
        cek_session_akses('sanksi_pelanggaran',$this->session->id_session);
        $id = array('id_sanksi_pelanggar' => $this->uri->segment(3));
        $this->model_app->delete('rb_bk_sanksi_pelanggar',$id);
        redirect($this->uri->segment(1).'/sanksi_pelanggaran');
    }

    function rekam_kasus(){
        cek_session_akses('rekam_kasus',$this->session->id_session);
        if ($_GET['tahun']!=''){
            $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                    JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                        JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                            JOIN rb_guru e ON a.id_guru=e.id_guru where a.id_tahun_akademik='$_GET[tahun]'");
        }else{
            $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                    JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                        JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                            JOIN rb_guru e ON a.id_guru=e.id_guru");
        }
        // return print_r($data['record']->result_array());
        $this->template->load('administrator/template','administrator/mod_bk/view_rekam',$data);
    }

    function tambah_rekam_kasus(){
        cek_session_akses('rekam_kasus',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                          'id_siswa'=>$this->input->post('a'),
                          'id_jenis_detail'=>$this->input->post('b'),
                          'id_guru'=>$this->input->post('c'),
                          'ket_pelanggaran'=>$this->input->post('d'),
                          'tindakan'=>$this->input->post('f'),
                          'pihak_terkait'=>$this->input->post('g'),
                          'ditindak_lanjuti_oleh'=>$this->input->post('h'),
                          'id_user'=>$this->session->id_session,
                          'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_bk_rekam',$data);
            redirect($this->uri->segment(1).'/rekam_kasus');
        }else{
            $this->template->load('administrator/template','administrator/mod_bk/tambah_rekam');
        }
    }

    function edit_rekam_kasus(){
        cek_session_akses('rekam_kasus',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_tahun_akademik'=>$this->input->post('id_tahun_akademik'),
                          'id_siswa'=>$this->input->post('a'),
                          'id_jenis_detail'=>$this->input->post('b'),
                          'id_guru'=>$this->input->post('c'),
                          'ket_pelanggaran'=>$this->input->post('d'),
                          'tindakan'=>$this->input->post('f'),
                          'pihak_terkait'=>$this->input->post('g'),
                          'ditindak_lanjuti_oleh'=>$this->input->post('h'));
            $where = array('id_rekam' => $this->input->post('id'));
            $this->model_app->update('rb_bk_rekam', $data, $where);
            redirect($this->uri->segment(1).'/rekam_kasus');
        }else{
            $edit = $this->model_app->view_where('rb_bk_rekam', array('id_rekam'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_bk/edit_rekam',$data);
        }
    }

    function rekap_kasus(){
        cek_session_akses('rekap_kasus',$this->session->id_session);
        if ($_GET['tahun']!=''){
            $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                    JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                        JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                            JOIN rb_guru e ON a.id_guru=e.id_guru where a.id_tahun_akademik='$_GET[tahun]' GROUP BY a.id_siswa");
        }else{
            $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                    JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                        JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                            JOIN rb_guru e ON a.id_guru=e.id_guru GROUP BY a.id_siswa");
        }
        $this->template->load('administrator/template','administrator/mod_bk/view_rekap_kasus',$data);
    }

    function detail_rekap_kasus(){
        cek_session_akses('rekap_kasus',$this->session->id_session);
        $data['row'] = $this->db->query("SELECT c.*, d.nama_kelas FROM rb_siswa c JOIN rb_kelas d ON c.id_kelas=d.id_kelas 
                                                where c.id_siswa='".$this->uri->segment(3)."'")->row_array();

        $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                    JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                        JOIN rb_guru e ON a.id_guru=e.id_guru where a.id_siswa='".$this->uri->segment(3)."' AND a.id_tahun_akademik='".$this->uri->segment(4)."'");
        $this->template->load('administrator/template','administrator/mod_bk/view_rekap_kasus_detail',$data);
    }

    function print_rekap_kasus(){
        cek_session_akses('rekap_kasus',$this->session->id_session);
        $data['row'] = $this->db->query("SELECT c.*, d.nama_kelas FROM rb_siswa c JOIN rb_kelas d ON c.id_kelas=d.id_kelas 
                                                where c.id_siswa='".$this->uri->segment(3)."'")->row_array();

        $data['record'] = $this->db->query("SELECT a.*, b.nama, b.nipd, c.pelanggaran, c.bobot, d.judul, e.nama_guru FROM rb_bk_rekam a JOIN rb_siswa b On a.id_siswa=b.id_siswa
                                                JOIN rb_bk_jenis_detail c ON a.id_jenis_detail=c.id_jenis_detail
                                                    JOIN rb_bk_jenis d ON c.id_jenis=d.id_jenis
                                                        JOIN rb_guru e ON a.id_guru=e.id_guru where a.id_siswa='".$this->uri->segment(3)."' AND a.id_tahun_akademik='".$this->uri->segment(4)."'");
        $this->load->view('administrator/mod_bk/view_rekap_kasus_detail_print',$data);
    }

      // controller agenda
    
            // Controller Modul BKK

    function alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $data['record']     = $this->model_app->view_ordering('rb_lk_bkk','id_bkk','ASC');
        $this->template->load('administrator/template','administrator/mod_lk_bkk/view',$data);
    }

    function detail_alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id_bkk' => $id);
        $data['datarecord']     = $this->model_app->view_where('rb_lk_bkk', $where)->row_array();
        $data['datas']     = $this->model_app->view_where_ordering('rb_lk_daftar_bkk', $where, 'id_daftar_bkk','ASC' );
        $this->template->load('administrator/template','administrator/mod_lk_bkk/detail',$data);
    }

    function tambah_alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_bkk'=>$this->input->post(id),
                            'kode_bkk'=>$this->input->post('a'),
                            'nama_instansi'=>$this->input->post('b'),
                            'pimpinan_instansi'=>$this->input->post('c'),
                            'no_telp'=>$this->input->post('d'),
                            'alamat_instansi'=>$this->input->post('e'),
                            'email'=>$this->input->post('f'),
                            'status'=>$this->input->post('g'),
                            'keterangan'=>$this->input->post('h'),
                            'limit_daftar'=>$this->input->post('i'),
                            'penanggung_jawab'=>$this->input->post('j'),
                            'pembimbing'=>$this->input->post('k'),
                            'berangkat'=>$this->input->post('l'),
                            'kembali'=>$this->input->post('m'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_lk_bkk',$data);
            redirect($this->uri->segment(1).'/alumni_bkk');
        } else {
            $this->template->load('administrator/template','administrator/mod_lk_bkk/tambah');
        }
    }

    function edit_alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kode_bkk'=>$this->input->post('a'),
                            'nama_instansi'=>$this->input->post('b'),
                            'pimpinan_instansi'=>$this->input->post('c'),
                            'no_telp'=>$this->input->post('d'),
                            'alamat_instansi'=>$this->input->post('e'),
                            'email'=>$this->input->post('f'),
                            'status'=>$this->input->post('g'),
                            'keterangan'=>$this->input->post('h'));
            $where = array('id_bkk' => $this->input->post('id'));
            $this->model_app->update('rb_lk_bkk', $data, $where);
            redirect($this->uri->segment(1).'/alumni_bkk');
        } else {
            $edit = $this->model_app->view('rb_lk_bkk')->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_bkk/edit',$data);
        }
    }

    function delete_alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = array('id_bkk' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_bkk',$id);
        redirect($this->uri->segment(1).'/alumni_bkk');
    }

    function daftar_alumni_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $bkk = $this->uri->segment(3);
        $data['id'] = $bkk;
        if (isset($_POST['submit'])){
            $data = array('id_daftar_bkk'=>$this->input->post(id),
                            'nama'=>$this->input->post('a'),
                            'nisn'=>$this->input->post('b'),
                            'tempat_lahir'=>$this->input->post('c'),
                            'tanggal_lahir'=>$this->input->post('d'),
                            'email'=>$this->input->post('e'),
                            'no_telp'=>$this->input->post('f'),
                            'alamat'=>$this->input->post('g'),
                            'tahun_masuk'=>$this->input->post('h'),
                            'tahun_lulus'=>$this->input->post('i'),
                            'no_ijazah'=>$this->input->post('j'),
                            'nilai_ujian'=>$this->input->post('k'),
                            'status'=>$this->input->post('l'),
                            'keterangan'=>$this->input->post('m'),
                            'id_bkk'=>$this->uri->segment(3),
                            'tanggal_daftar'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_lk_daftar_bkk',$data);
            redirect($this->uri->segment(1).'/detail_alumni_bkk/'.$this->uri->segment(3));
        } else {
            $this->template->load('administrator/template','administrator/mod_lk_bkk/daftar',$data);
        }
    }

    function delete_daftar_bkk(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = array('id_daftar_bkk' => $this->uri->segment(4));
        $this->model_app->delete('rb_lk_daftar_bkk',$id);
        redirect($this->uri->segment(1).'/detail_daftar_bkk/'.$this->uri->segment(3));
    }

    function magang(){
        cek_session_akses('magang',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_humas_traceralumni','id_traceralumni','ASC');
        $this->template->load('administrator/template','administrator/mod_humas_dudi/view',$data);
    }

    function detail_magang(){
        cek_session_akses('magang',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id_traceralumni' => $id);
        $data['datarecord']     = $this->model_app->view_where('rb_humas_traceralumni', $where)->row_array();
        $data['datas']     = $this->model_app->view_where_ordering('rb_lk_riwayat_tracer', $where, 'id_riwayat','ASC' );
        $data['recs']     = $this->model_app->view_where_ordering('rb_lk_riwayat_tracer', $where, 'id_riwayat','ASC' );
        // return print_r($data['recs']);
        $this->template->load('administrator/template','administrator/mod_humas_dudi/detail',$data);
    }

    function tambah_magang(){
        cek_session_akses('magang',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama'=>$this->input->post('a'),
                            'tahun_lulus'=>$this->input->post('b'),
                            'tahun_masuk'=>$this->input->post('c'),
                            'tempat_bekerja'=>$this->input->post('d'),
                            'alamat'=>$this->input->post('e'),
                            'alamat_kantor'=>$this->input->post('j'),
                            'email'=>$this->input->post('f'),
                            'no_hp'=>$this->input->post('g'),
                            'jabatan_pekerjaan'=>$this->input->post('h'),
                            'keterangan'=>$this->input->post('i'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_humas_traceralumni',$data);
            redirect($this->uri->segment(1).'/magang');
        }else{
            $this->template->load('administrator/template','administrator/mod_humas_dudi/tambah');
        }
    }

    function edit_magang(){
        cek_session_akses('magang',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama'=>$this->input->post('a'),
                            'tahun_lulus'=>$this->input->post('b'),
                            'tahun_masuk'=>$this->input->post('c'),
                            'tempat_bekerja'=>$this->input->post('d'),
                            'alamat'=>$this->input->post('e'),
                            'alamat_kantor'=>$this->input->post('j'),
                            'email'=>$this->input->post('f'),
                            'no_hp'=>$this->input->post('g'),
                            'jabatan_pekerjaan'=>$this->input->post('h'),
                            'keterangan'=>$this->input->post('i'));
            $where = array('id_traceralumni' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_humas_traceralumni', $data, $where);
            redirect($this->uri->segment(1).'/magang');
        }else{
            $edit = $this->model_app->view_where('rb_humas_traceralumni', array('id_traceralumni'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_humas_dudi/edit',$data);
        }
    }

    function delete_magang(){
        cek_session_akses('magang',$this->session->id_session);
        $id = array('id_traceralumni' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_humas_traceralumni',$id);
        redirect($this->uri->segment(1).'/magang');
    }

    function riwayat_magang(){
        cek_session_akses('magang',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('nama'=>$this->input->post('a'),
                            'pimpinan'=>$this->input->post('b'),
                            'alamat'=>$this->input->post('c'),
                            'jabatan'=>$this->input->post('d'),
                            'tahun_masuk'=>$this->input->post('e'),
                            'tahun_keluar'=>$this->input->post('f'),
                            'gaji'=>$this->input->post('g'),
                            'status'=>$this->input->post('h'),
                            'keterangan'=>$this->input->post('i'),
                            'id_traceralumni'=>$this->uri->segment(3));
            $this->model_app->insert('rb_lk_riwayat_tracer',$data);
            redirect($this->uri->segment(1).'/magang/'.$this->uri->segment(3));
        }else{
            $this->template->load('administrator/template','administrator/mod_humas_dudi/riwayat');
        }
    }

    
    

            // Controller Modul Predikat Sikap
    
    function predikat_karakter(){
        cek_session_akses('predikat_karakter',$this->session->id_session);
        $data['record'] = $this->model_app->view_where_ordering('rb_predikat_karakter',array('id_identitas_sekolah'=>$this->session->sekolah),'id_predikat_karakter','ASC');
        $this->template->load('administrator/template','administrator/mod_predikat_karakter/view',$data);
    }


    function tambah_predikat_karakter(){
        cek_session_akses('predikat_karakter',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_karakter'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_predikat_karakter',$data);
            redirect($this->uri->segment(1).'/predikat_karakter');
        }else{
            $this->template->load('administrator/template','administrator/mod_predikat_karakter/tambah');
        }
    }

    function edit_predikat_karakter(){
        cek_session_akses('predikat_karakter',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nilaia'=>$this->input->post('a'),
                            'nilaib'=>$this->input->post('b'),
                            'predikat_karakter'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $where = array('id_predikat_karakter' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_predikat_karakter', $data, $where);
            redirect($this->uri->segment(1).'/predikat_karakter');
        }else{
            $edit = $this->model_app->view_where('rb_predikat_karakter', array('id_predikat_karakter'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_predikat_karakter/edit',$data);
        }
    }

    function delete_predikat_karakter(){
        cek_session_akses('predikat_karakter',$this->session->id_session);
        $id = array('id_predikat_karakter' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_predikat_karakter',$id);
        redirect($this->uri->segment(1).'/predikat_karakter');
    }
    
    function backup_restore(){
        cek_session_akses('backup_restore',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('backup_restore','id_backup_restore','DESC');
        $this->template->load('administrator/template','administrator/mod_identitas/backup_restore.php',$data);
    }

    function tambah_backup_restore(){
      cek_session_akses('backup_restore',$this->session->id_session);
      $this->load->dbutil();
        $prefs = array(     
            'format'      => 'zip',             
            'filename'    => 'simasta_backup.sql');
        $backup =& $this->dbutil->backup($prefs); 
        $db_name = 'backup-simasta-'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'asset/backup_restore/'.$db_name;
        $this->load->helper('file');
        write_file($save, $backup); 

        $data = array('nama_file'=>$db_name,
                    'waktu_backup'=>date('Y-m-d H:i:s'));
        $this->model_app->insert('backup_restore',$data);
        redirect($this->uri->segment(1).'/backup_restore');
    }

    function delete_backup_restore(){
        cek_session_akses('backup_restore',$this->session->id_session);
        $id = array('id_backup_restore' => $this->uri->segment(3));
        $this->model_app->delete('backup_restore',$id);
        redirect($this->uri->segment(1).'/backup_restore');
    }

    function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
    
    // Controller Notulensi

    function notulensi_rapat(){
        cek_session_akses('notulensi_rapat',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_lk_notulensi_rapat','id_rapat','ASC');
        $this->template->load('administrator/template','administrator/mod_notulensi_rapat/view',$data);
    }

    function tambah_notulensi_rapat(){
        cek_session_akses('notulensi_rapat',$this->session->id_session);
        if (isset($_POST['submit'])){

            $data = array(  'tgl_rapat'=>tgl_simpan($this->input->post('tanggal')),
                            'topik_rapat'=>$this->input->post('topik_rapat'),
                            'agenda_rapat'=>$this->input->post('agenda_rapat'),
                            'ruang_rapat'=>$this->input->post('ruang_rapat'),
                            'pembahasan'=>$this->input->post('pembahasan'),
                            'tindak_lanjut'=>$this->input->post('tindak_lanjut'),
                            'peserta_rapat'=>$this->input->post('peserta_rapat'));                          
                            
            $this->model_app->insert('rb_lk_notulensi_rapat',$data);
            redirect($this->uri->segment(1).'/notulensi_rapat');
        }else{
            $this->template->load('administrator/template','administrator/mod_notulensi_rapat/tambah');
        }
    }

    function edit_notulensi_rapat(){
        cek_session_akses('notulensi_rapat',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array(  'tgl_rapat'=>tgl_simpan($this->input->post('tanggal')),
                            'topik_rapat'=>$this->input->post('topik_rapat'),
                            'agenda_rapat'=>$this->input->post('agenda_rapat'),
                            'ruang_rapat'=>$this->input->post('ruang_rapat'),
                            'pembahasan'=>$this->input->post('pembahasan'),
                            'tindak_lanjut'=>$this->input->post('tindak_lanjut'),
                            'peserta_rapat'=>$this->input->post('peserta_rapat'));
                            
            $where = array('id_rapat' => $this->input->post('id'));
            $this->model_app->update('rb_lk_notulensi_rapat', $data, $where);
            redirect($this->uri->segment(1).'/notulensi_rapat');
        }else{
            $edit = $this->model_app->view_where('rb_lk_notulensi_rapat', array('id_rapat'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_notulensi_rapat/edit',$data);
        }
    }

    function delete_notulensi_rapat(){
        cek_session_akses('notulensi_rapat',$this->session->id_session);
        $id = array('id_rapat' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_notulensi_rapat',$id);
        redirect($this->uri->segment(1).'/notulensi_rapat');
    }
    
}