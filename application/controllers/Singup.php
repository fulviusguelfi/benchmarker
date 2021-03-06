<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once(APPPATH.'core/BM_Controller.php');

class Singup extends BM_Controler {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('encryption');
        $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                )
        );
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('user', null);
        $this->bm_form_builder->exclude_form_values(['id']);
        $this->bm_form_builder->hide_form_values(['id_role']);
        $this->load->model('role');
        $this->bm_form_builder->set_value('id_role', $this->role->get_default_role_id());
        $this->bm_form_builder->set_extra_for('first_name', ['placeholder' => $this->lang->line('First Name'), 'class' => 'form-control login']);
        $this->bm_form_builder->set_extra_for('last_name', ['placeholder' => $this->lang->line('Last Name'), 'class' => 'form-control login']);
        $this->bm_form_builder->set_extra_for('email', ['placeholder' => $this->lang->line('Email'), 'class' => 'form-control login']);
        $this->bm_form_builder->set_extra_for('passwd', ['placeholder' => $this->lang->line('Password'), 'class' => 'form-control login']);
        $this->bm_form_builder->set_password_type('passwd');
        $this->bm_form_builder->set_extra_for('agree_terms', ['class' => "field login-checkbox", 'tabindex' => "4"]);
        $this->bm_form_builder->add_special_label('agree_terms', $this->lang->line('Agree with the Terms & Conditions.'));
        $this->bm_form_builder->add_form_values('confirm_passwd');
        $this->bm_form_builder->set_password_type('confirm_passwd');
        $this->bm_form_builder->set_extra_for('confirm_passwd', ['placeholder' => $this->lang->line('Confirm Password'), 'class' => 'form-control']);
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('singup', 'index');
        $this->db->cache_delete('singup', 'modify');
    }

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Singup')]);
        if ($hook === 'lista') {
            
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona' || $hook === 'erro_seleciona') {
            
        } elseif ($hook === 'novo' || $hook === 'erro_novo') {
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Signup for Free Account'),
                'form_description' => $this->lang->line('Create your free account:'),
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            unset($data['submit']);
            unset($data['page_title']);
            unset($data['confirm_passwd']);
            $data['passwd'] = $this->encryption->encrypt($data['passwd']);
            $this->set_model('user');
        }
        return parent::get_data($hook, $data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/head', $this->view_sequece) => 'login/head']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/javascript', $this->view_sequece) => 'singup/javascript']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/nav_bar', $this->view_sequece) => 'singup/nav_bar']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'singup/form']);
        parent::show_form($data);
    }

    public function show_list(array $data) {
        if (array_key_exists('cria', $data)) {
            redirect('login');
        }
    }

}
