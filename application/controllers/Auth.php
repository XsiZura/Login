<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $data['title'] = 'Login Form';
        $this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password','Password', 'trim|required');

        if($this->form_validation->run() == false){
        $this->load->view('template/auth_header');
        $this->load->view('auth/login');
        $this->load->view('template/auth_footer');
    } else {
        $this->_login();
    }
}


    private function _login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
    
        if($user) {
            if($user['is_active'] == 1){
                if(password_verify($password, $user['password'])){
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if($user['role_id'] == 1){
                        redirect('admin');
                    }else{
                        redirect('user');
                    }
                }else{
                    $this->session->set_flashdata('message', '<div class="aler alert-danger" role="alert">Wrong Password</div>');
                    redirect('auth');
                }
            } else{
                $this->session->set_flashdata('message', '<div class="aler alert-danger" role="alert">This Email Has not Activated</div>');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="aler alert-danger" role="alert">Email is not registered</div>');
            redirect('auth');
        }
    }
    
    public function registration()
    {

        if ($this->session->userdata('email')) {
            redirect('user');
        }
        
        $data['title'] = 'Regist Form';
        $this->form_validation-> set_rules('name', 'Name', 'required|trim');
        $this->form_validation-> set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]',
                                        ['is_unique' => 'This email has already registered']);
        $this->form_validation-> set_rules('password1', 'Password','required|trim|min_length[4]|matches[password2]', 
                                            ['matches' => 'Password dont match!', 
                                            'min_lenght' => 'Password too short!']);
        $this->form_validation-> set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if( $this->form_validation->run() == false){

        $data['title'] = 'User Registration'; 
        $this->load->view('template/auth_header', $data);
        $this->load->view('auth/registration');
        $this->load->view('template/auth_footer');
        
        } else {
            $data = [
                     'name' => htmlspecialchars($this->input->post('name', true)), 
                     'email' => htmlspecialchars($this->input->post('email', true)), 
                     'image' => 'default.jpg', 
                     'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                     'role_id' => 2,
                     'is_active' => 1,
                     'date_created' => time()
            ];

            $this->session->set_flashdata('message', '<div class="aler alert-success" role="alert">Congrats! your account has been created. Please Login</div>');
            log_message('debug', 'Data to be inserted: ' . print_r($data, true));

            // Cek jika query insert gagal
            if ($this->db->insert('user', $data)) {
                redirect('auth');
            } else {
                // Log error jika insert gagal
                log_message('error', 'Failed to insert data: ' . $this->db->last_query());
            }
        }
    }
    public function logout() {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="aler alert-success" role="alert">You have been Log-out</div>');
        redirect('auth');
    }

    public function blocked(){
        $this->load->view('auth/blocked');
    }
}