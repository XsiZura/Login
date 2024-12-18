<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends CI_Controller
{

    public function index(){
        $data['title'] = 'List User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->select('id, name, email, role_id, date_created');
        $this->db->from('user');
        $users = $this->db->get()->result_array();
        $data['roles'] = $this->db->get('user_role')->result_array();

        // Ubah role_id menjadi "Admin" atau "Member"
        foreach ($users as &$user) {
        $user['role'] = ($user['role_id'] == 1) ? 'Admin' : 'Member'; // Sesuaikan role_id 1 untuk Admin, lainnya Member
    }
        $data['users'] = $users;

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('table/index', $data);
            $this->load->view('template/footer');
        } else {
            $name = htmlspecialchars($this->input->post('name', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $role_id = $this->input->post('role_id');
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT); // Hashing password
            $is_active = $this->input->post('is_active') ? 1 : 0;

        $data = [
            'name' => $name,
            'email' => $email,
            'image' => 'default.jpg',
            'role_id' => $role_id,
            'password' => $password,
            'is_active' => $is_active,
            'date_created' => time()
        ];

        // Insert data ke tabel user
        $this->db->insert('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success">New user has been added!</div>');
        redirect('table/index');
        }
    }

        public function edit_user($id){

            $data['title'] = 'Edit User';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $data['user'] = $this->db->get_where('user', ['id' => $id])->row_array();
            $data['roles'] = $this->db->get('user_role')->result_array();

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('role_id', 'Role', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('table/edit_user', $data);
            $this->load->view('template/footer' );
        } else {
            $updateData = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'role_id' => $this->input->post('role_id'),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
        ];
        // Jika Passowrd diubah
        if(!empty($this->input->post('password'))){
            $updateData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

            $this->db->where('id', $id);
            $this->db->update('user', $updateData);

            $this->session->set_flashdata('message', '<div class="alert alert-succes">User has been updated!</div>');
            redirect('table/index');
        }
    }

    public function delete_user($id) {

        $this->db->where('id', $id);
        $this->db->delete('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success">User has been deleted!</div>');
        redirect('table/index');
    }
}
