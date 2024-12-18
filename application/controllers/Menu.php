<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index(){

        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if($this->form_validation->run() == false){

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->insert('user_menu',['menu' => $this->input->post('menu')]);
            $menu_id = $this->db->insert_id(); // Mendapatkan ID menu baru
            $this->db->insert('user_access_menu', ['role_id' => 1, 'menu_id' => $menu_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-succes">Menu Added</div>');
            redirect('menu'); 
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get_where('user_menu', ['id' => $id])->row_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/edit', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->update('user_menu', ['menu' => $this->input->post('menu')], ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Menu Updated</div>');
            redirect('menu');
        }
    }

    // Fungsi untuk Hapus Menu
    public function delete($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Menu Deleted</div>');
        redirect('menu');
    }

    public function submenu(){

        $data['title'] = 'Sub Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();


        $this->form_validation->set_rules('title','Title', 'required');
        $this->form_validation->set_rules('menu_id','Menu', 'required');
        $this->form_validation->set_rules('url','Url', 'required');
        $this->form_validation->set_rules('icon','icon', 'required');


        if($this->form_validation->run() == false){
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('template/footer');
    } else {
        $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
        ];

        $this->db->insert('user_sub_menu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success">New Sub Menu added</div>');
        redirect('menu/submenu');
    }

}
    // Fungsi untuk mengedit submenu
    public function edit_submenu($id)
    {
        $data['title'] = 'Edit Sub Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['submenu'] = $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // Validasi form
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/edit_submenu', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];

            $this->db->update('user_sub_menu', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Sub Menu Updated</div>');
            redirect('menu/submenu');
        }
    }
    public function delete_submenu($id)
    {
        // Menghapus submenu berdasarkan ID yang diberikan
        $this->db->delete('user_sub_menu', ['id' => $id]);

        // Set flash message untuk konfirmasi
        $this->session->set_flashdata('message', '<div class="alert alert-success">Sub Menu Deleted</div>');

        // Redirect kembali ke halaman submenu
        redirect('menu/submenu');
    }

    
    
}