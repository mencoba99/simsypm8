<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pojok extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function pojok_literasi(){
        cek_session_akses('pojok_literasi',$this->session->id_session);
        if($this->session->level=='guru'){
            $data['record'] = $this->model_app->view_ordering('rb_lk_pojok_literasi','id_pojok_literasi','ASC');        
            $this->template->load('administrator/template','administrator/mod_lk_pojok_literasi/view',$data);
        }elseif($this->session->level=='siswa'){
            $data['record'] = $this->model_app->view_ordering('rb_lk_pojok_literasi','id_pojok_literasi','ASC');        
            $this->template->load('administrator/template','administrator/mod_lk_pojok_literasi/view_siswa',$data);
        }
    }
    
    function unduh_pojok_literasi(){
      $this->load->helper('download');
      $aa = $this->db->query("SELECT * FROM rb_lk_pojok_literasi WHERE id_pojok_literasi=".$this->uri->segment(3)." ")->result_array()[0];
   
      force_download("asset/dokumen_pojok_literasi/".$aa['dokumen']."",NULL);
      redirect($this->uri->segment(1).'/pojok_literasi');
    }

    function tambah_pojok_literasi(){
        cek_session_akses('pojok_literasi', $this->session->id_session);
        if (isset($_POST['submit'])){
            $config['upload_path'] = realpath('asset/dokumen_pojok_literasi/');
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = '100000';
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["dokumen"]['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('dokumen');
            $hasil=$this->upload->data();
            if($hasil['file_name']==''){
                $data = array(  'id_identitas_sekolah'=>$this->session->sekolah,
                                'judul'=>$this->input->post('a'),
                                'deskripsi'=>$this->input->post('b'),
                             );
            }else{
                $data = array(  'id_identitas_sekolah'=>$this->session->sekolah,
                                'judul'=>$this->input->post('a'),
                                'deskripsi'=>$this->input->post('b'),
                                'dokumen'=>$hasil['file_name']
                            );
            }
            $this->model_app->insert('rb_lk_pojok_literasi',$data);

            redirect($this->uri->segment(1).'/pojok_literasi');
        }else{
            // print_r($data); exit();
            $this->template->load('administrator/template','administrator/mod_lk_pojok_literasi/tambah',$data);
        }
    }

    function edit_pojok_literasi(){
        cek_session_akses('pojok_literasi',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $config['upload_path'] = realpath('asset/dokumen_pojok_literasi/');
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = '100000';
            $config['file_name'] = $this->uri->segment(1).'_'.$_FILES["dokumen"]['name']; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('dokumen');
            $hasil=$this->upload->data();
            if ($_FILES["dokumen"]['name']=='') {                
                $data = array(  'id_identitas_sekolah'=>$this->session->sekolah,
                                'judul'=>$this->input->post('a'),
                                'deskripsi'=>$this->input->post('b'),
                            );
            }else{
                $data = array(  'id_identitas_sekolah'=>$this->session->sekolah,
                                'judul'=>$this->input->post('a'),
                                'deskripsi'=>$this->input->post('b'),
                                'dokumen'=>$hasil['file_name']
                            );
            }
            $where = array('id_pojok_literasi' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_lk_pojok_literasi', $data, $where);
            redirect($this->uri->segment(1).'/pojok_literasi');
        }else{
            $edit = $this->model_app->view_where('rb_lk_pojok_literasi', array('id_pojok_literasi'=>$id,'id_identitas_sekolah'=>$this->session->sekolah))->row_array();
            $data = array('edit' => $edit);
            $this->template->load('administrator/template','administrator/mod_lk_pojok_literasi/edit',$data);
        }
    }

    function delete_pojok_literasi(){
        cek_session_akses('pojok_literasi',$this->session->id_session);
        $id = array('id_pojok_literasi' => $this->uri->segment(3),'id_identitas_sekolah'=>$this->session->sekolah);
        $this->model_app->delete('rb_lk_pojok_literasi',$id);
        redirect($this->uri->segment(1).'/pojok_literasi');
    }
}