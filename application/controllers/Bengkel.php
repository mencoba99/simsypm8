<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bengkel extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }  
  // bengkel Controller
    function bengkel(){
        cek_session_akses('bengkel',$this->session->id_session);
        $data['record'] = $this->model_app->bengkel('rb_bengkel',array('id_identitas_sekolah'=>$this->session->sekolah),'id_bengkel','ASC');
        $this->template->load('administrator/template','administrator/mod_bengkel/view',$data);
    }

    function tambah_bengkel(){
        cek_session_akses('bengkel', $this->session->id_session);
        $guru = $this->model_app->view_where_ordering('rb_guru',array('id_identitas_sekolah'=>$this->session->sekolah),'id_guru','ASC');
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_bengkel'=>$this->input->post('a'),
                            'pengelola'=>$this->input->post('b'),
                            'nama_bengkel'=>$this->input->post('c'),
                            'asset'=>$this->input->post('d'),
                         );
            $guru = $this->db->query("SELECT * FROM rb_guru where id_guru =".$data['pengelola']." ")->result_array()[0];
            $data['pengelola'] = $guru['nama_guru'];
            $this->model_app->insert('rb_bengkel',$data);
            redirect($this->uri->segment(1).'/bengkel');
        }else{
            $this->db->select_max('kode_bengkel');
            $bengkel = $this->db->get('rb_bengkel')->result_array()[0]['kode_bengkel'];            
            $data = array('bengkel' => $bengkel, 'guru'=>$guru);
            $this->template->load('administrator/template','administrator/mod_bengkel/tambah',$data);
        }
    }

    function edit_bengkel(){
        cek_session_akses('bengkel',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_bengkel'=>$this->input->post('a'),
                            'pengelola'=>$this->input->post('b'),
                            'nama_bengkel'=>$this->input->post('c'),
                            'asset'=>$this->input->post('d'),
                          );         
            $where = array('id_bengkel' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_bengkel', $data, $where);
            redirect($this->uri->segment(1).'/bengkel');
        }else{
            $edit = $this->model_app->view_where('rb_bengkel', array('id_bengkel'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('edit' => $edit);
            $this->template->load('administrator/template','administrator/mod_bengkel/edit',$data);
        }
    }

    function delete_bengkel(){
        cek_session_akses('bengkel',$this->session->id_session);
        $id = array('id_bengkel' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_bengkel',$id);
        redirect($this->uri->segment(1).'/bengkel');
    }

    function bengkel_asset(){
        cek_session_akses('bengkel',$this->session->id_session);
        $data['row'] = $this->model_app->view_where('rb_bengkel',array('id_bengkel'=>$_GET['id']))->row_array();
        $data['record'] = $this->model_app->view_where('rb_bengkel_asset',array('id_bengkel'=>$_GET['id']));
        $this->template->load('administrator/template','administrator/mod_bengkel/asset_bengkel/view',$data);
    }

    function tambah_bengkel_asset(){
        cek_session_akses('bengkel', $this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_bengkel'=>$this->input->post('a'),
                            'pengelola'=>$this->input->post('b'),
                            'nama_bengkel'=>$this->input->post('c'),
                            'asset'=>$this->input->post('d'),
                         );
            $guru = $this->db->query("SELECT * FROM rb_guru where id_guru =".$data['pengelola']." ")->result_array()[0];
            $data['pengelola'] = $guru['nama_guru'];
            $this->model_app->insert('rb_bengkel',$data);
            redirect($this->uri->segment(1).'/bengkel');
        }else{
            $this->db->select_max('kode_bengkel');
            $bengkel = $this->db->get('rb_bengkel')->result_array()[0]['kode_bengkel'];            
            $data = array('bengkel' => $bengkel, 'guru'=>$guru);
            $this->template->load('administrator/template','administrator/mod_bengkel/asset_bengkel/tambah',$data);
        }
    }

    function edit_bengkel_asset(){
        cek_session_akses('bengkel',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('id_identitas_sekolah'=>$this->session->sekolah,
                            'kode_bengkel'=>$this->input->post('a'),
                            'pengelola'=>$this->input->post('b'),
                            'nama_bengkel'=>$this->input->post('c'),
                            'asset'=>$this->input->post('d'),
                          );         
            $where = array('id_bengkel' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_bengkel', $data, $where);
            redirect($this->uri->segment(1).'/bengkel');
        }else{
            $edit = $this->model_app->view_where('rb_bengkel', array('id_bengkel'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('edit' => $edit);
            $this->template->load('administrator/template','administrator/mod_bengkel/edit',$data);
        }
    }

    function delete_bengkel_asset(){
        cek_session_akses('bengkel',$this->session->id_session);
        $id = array('id_bengkel' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_bengkel',$id);
        redirect($this->uri->segment(1).'/bengkel');
    }

} -->