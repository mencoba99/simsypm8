<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alumni extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    // Controller Tracer Study

    function tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        if($this->session->level=='guru'){
            $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data['record'] = $this->model_app->view_ordering('rb_humas_traceralumni','id_traceralumni','ASC');            
            $this->template->load('administrator/template','administrator/mod_humas_dudi/view_guru',$data);
        }else{
            $data['record'] = $this->model_app->view_ordering('rb_humas_traceralumni','id_traceralumni','ASC');
            $this->template->load('administrator/template','administrator/mod_humas_dudi/view',$data);
        }
    }

    function excel_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_humas_traceralumni','id_traceralumni','ASC');
        $this->load->view('administrator/mod_humas_dudi/print',$data);
    }

    function detail_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id_traceralumni' => $id);
        $data['datarecord'] = $this->model_app->view_where('rb_humas_traceralumni', $where)->row_array();
        $data['datas']      = $this->model_app->view_where_ordering('rb_lk_riwayat_tracer', $where, 'tahun_masuk','ASC' );
        $data['recs']       = $this->model_app->view_where_ordering('rb_lk_riwayat_tracer', $where, 'tahun_keluar','ASC' );
        // return print_r($data['recs']);
        $this->template->load('administrator/template','administrator/mod_humas_dudi/detail',$data);
    }

    function tambah_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'nama'=>$this->input->post('a'),
                            'tahun_lulus'=>$this->input->post('b'),
                            'nisn'=>$this->input->post('c'),
                            'alamat'=>$this->input->post('e'),
                            'email'=>$this->input->post('f'),
                            'no_hp'=>$this->input->post('g'),
                            'keterangan'=>$this->input->post('i'),
                            'waktu_input'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_humas_traceralumni',$data);
            redirect($this->uri->segment(1).'/tracer_alumni');
        }else{
            $this->template->load('administrator/template','administrator/mod_humas_dudi/tambah');
        }
    }

    function edit_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('nama'=>$this->input->post('a'),
                            'tahun_lulus'=>$this->input->post('b'),
                            'nisn'=>$this->input->post('c'),
                            'alamat'=>$this->input->post('e'),
                            'email'=>$this->input->post('f'),
                            'no_hp'=>$this->input->post('g'),
                            'keterangan'=>$this->input->post('i'));
            $where = array('id_traceralumni' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_humas_traceralumni', $data, $where);
            redirect($this->uri->segment(1).'/tracer_alumni');
        }else{
            $edit = $this->model_app->view_where('rb_humas_traceralumni', array('id_traceralumni'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_humas_dudi/edit',$data);
        }
    }

    function delete_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $id = array('id_traceralumni' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_humas_traceralumni',$id);
        redirect($this->uri->segment(1).'/tracer_alumni');
    }

    function delete_riwayat_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $id = array('id_riwayat' => $this->uri->segment(3));
        $ta = array('id_traceralumni' => $this->uri->segment(4));
        // return print_r($id);
        $this->model_app->delete('rb_lk_riwayat_tracer',$id);
        redirect($this->uri->segment(1).'/detail_tracer_alumni/'.$this->uri->segment(4));
    }

    function riwayat_tracer_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
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
            redirect($this->uri->segment(1).'/detail_tracer_alumni/'.$this->uri->segment(3));
        }else{
            $this->template->load('administrator/template','administrator/mod_humas_dudi/riwayat');
        }
    }

    function ubah_riwayat_alumni(){
        cek_session_akses('tracer_alumni',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('tahun_masuk'=>$this->input->post('a'),
                            'tahun_keluar'=>$this->input->post('b'),
                            'gaji'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $where = array('id_riwayat' => $this->input->post('id'));
            $this->model_app->update('rb_lk_riwayat_tracer', $data, $where);
            redirect($this->uri->segment(1).'/detail_tracer_alumni/'.$this->input->post(head));
        }else{
            $edit = $this->model_app->view_where('rb_lk_riwayat_tracer', array('id_riwayat'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_humas_dudi/ubah',$data);
        }
    }

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
            redirect($this->uri->segment(1).'/magang/'.$this->uri->segment(3));
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
                        'keterangan'=>$this->input->post('h'),
                        'limit_daftar'=>$this->input->post('i'),
                        'penanggung_jawab'=>$this->input->post('j'),
                        'pembimbing'=>$this->input->post('k'),
                        'berangkat'=>$this->input->post('l'),
                        'kembali'=>$this->input->post('m'));
            $where = array('id_bkk' => $this->input->post('id'));
            $this->model_app->update('rb_lk_bkk', $data, $where);
            redirect($this->uri->segment(1).'/detail_alumni_bkk/'.$this->input->post('id'));
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

    function magang(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = $this->uri->segment(3);

        $data['angkatan'] = $this->db->query("SELECT angkatan FROM rb_siswa WHERE id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC")->result_array();
        $data['jurusan'] = $this->model_app->view('rb_jurusan')->result_array();
        $data['tingkat'] = $this->model_app->view('rb_tingkat')->result_array();
        $data['record'] = $this->model_app->magang_selected();
        $this->template->load('administrator/template','administrator/mod_lk_bkk/siswa',$data);
    }

    function tambah_magang(){
        cek_session_akses('alumni_bkk',$this->session->id_session);
        $id = $this->uri->segment(3);
        
        if (isset($_POST['submit'])) {
            $jums = $this->input->post('jumblah');
            $where = array('id_bkk', $id);
            $ceklimit = $this->model_app->view_where('rb_lk_bkk', $where)->row_array();
            $jumlahmagang = $this->model_app->view_where('rb_lk_daftar_bkk', $where)->num_rows();
            
            $jumlahlimit = $ceklimit['limit_daftar'];
            $limit = 0;
            
            for($sa=1;$sa<=$jums;$sa++) {
                if ($_POST['daftar'.$sa] == 'Daftar') {
                    $limit++;
                }
            }

            $validasilimit = $jumlahmagang + $limit;
            $sisa = $jumlahlimit - $jumlahmagang;

            if ($validasilimit > $jumlahlimit) {
                $this->session->set_flashdata('error', 'Limit Pendaftar Magang adalah '.$jumlahlimit.' orang. Anda hanya dapat mendaftarkan '.$sisa.' orang.');
                redirect($this->uri->segment(1).'/magang/'.$this->uri->segment(3));
            } else {
                for($ia=1;$ia<=$jums;$ia++) {
                    $id_siswa = $_POST['id_siswa'.$ia];
                    $cek = $this->model_app->magang_all($id_siswa)->row_array();
                    // return print_r($id);
                    if ($_POST['daftar'.$ia] == 'Daftar') {
                        $data = array(
                            'id_siswa' => $cek['id_siswa'],
                            'nama_siswa' => $cek['nama'],
                            'nipd' => $cek['nipd'],
                            'angkatan' => $cek['angkatan'],
                            'jurusan' => $cek['nama_jurusan'],
                            'kelas' => $cek['nama_kelas'],
                            'id_bkk' => $this->uri->segment(3),
                            'waktu_daftar' => date('Y-m-d H:i:s')
                        );
    
                        $this->model_app->insert('rb_lk_daftar_bkk', $data);
                        
                        $siswa = array(
                            'id_bkk' => $this->uri->segment(3)
                        );
                        $where = array('id_siswa' => $cek['id_siswa']);
                        $this->model_app->update('rb_siswa', $siswa, $where);
                    }
                }
                redirect($this->uri->segment(1).'/detail_alumni_bkk/'.$this->uri->segment(3));
            }
        } else {
            $data['angkatan'] = $this->db->query("SELECT angkatan FROM rb_siswa WHERE id_identitas_sekolah='".$this->session->sekolah."' GROUP BY angkatan ORDER BY angkatan ASC")->result_array();
            $data['jurusan'] = $this->model_app->view('rb_jurusan')->result_array();
            $data['tingkat'] = $this->model_app->view('rb_tingkat')->result_array();
            $data['record'] = $this->model_app->magang_selected();
            $this->template->load('administrator/template','administrator/mod_lk_bkk/siswa',$data);
        }
    }

    function delete_magang(){
        cek_session_akses('magang',$this->session->id_session);
        $id = array('id_daftar_bkk' => $this->uri->segment(4));
        $this->model_app->delete('rb_lk_daftar_bkk',$id);
        
        $id1 = array('id_siswa' => $this->uri->segment(5));
        $siswa = array(
            'id_bkk' => NULL
        );
        $where = $id1;
        $this->model_app->update('rb_siswa', $siswa, $where);
        
        redirect($this->uri->segment(1).'/detail_alumni_bkk/'.$this->uri->segment(3));
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

    // Controller Pengumuman

    function pengumuman(){
        cek_session_akses('pengumuman',$this->session->id_session);
        $data['record']     = $this->model_app->view_ordering('rb_lk_pengumuman','id','ASC');
        $this->template->load('administrator/template','administrator/mod_lk_pengumuman/view',$data);
    }

    function tambah_pengumuman(){
        cek_session_akses('pengumuman',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('judul'=>$this->input->post('a'),
                            'deskripsi'=>$this->input->post('b'),
                            'status'=>$this->input->post('c'),
                            'penulis'=>$this->session->userdata('username'),
                            'waktu_post'=>date('Y-m-d H:i:s'));
            $this->model_app->insert('rb_lk_pengumuman',$data);
            redirect($this->uri->segment(1).'/pengumuman');
        }else{
            $this->template->load('administrator/template','administrator/mod_lk_pengumuman/tambah');
        }
    }

    function detail_pengumuman(){
        cek_session_akses('pengumuman',$this->session->id_session);
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
        $data['datarecord'] = $this->model_app->view_where('rb_lk_pengumuman', $where)->row_array();
        $this->template->load('administrator/template','administrator/mod_lk_pengumuman/detail',$data);
    }
    
    function delete_pengumuman(){
        cek_session_akses('pengumuman',$this->session->id_session);
        $id = array('id' => $this->uri->segment(3));
        $this->model_app->delete('rb_lk_pengumuman', $id);
        redirect($this->uri->segment(1).'/pengumuman');
    }

    function edit_pengumuman(){
        cek_session_akses('pengumuman',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('judul'=>$this->input->post('a'),
                            'deskripsi'=>$this->input->post('b'),
                            'status'=>$this->input->post('c'),
                            'penulis'=>$this->session->userdata('username'));
            $where = array('id' => $this->input->post('id'));
            $this->model_app->update('rb_lk_pengumuman', $data, $where);
            redirect($this->uri->segment(1).'/pengumuman');
        }else{
            $edit = $this->model_app->view_where('rb_lk_pengumuman', array('id'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_pengumuman/edit', $data);
        }
    }
}