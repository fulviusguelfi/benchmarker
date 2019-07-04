<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once(APPPATH.'core/BM_Controller.php');

class Login extends BM_Controler {

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
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('user', null);
        $this->bm_form_builder->exclude_form_values(['first_name', 'last_name', 'id_role', 'id']);
        $this->bm_form_builder->set_extra_for('email', ['placeholder' => $this->lang->line('Email'), 'class' => 'form-control login username-field']);
        $this->bm_form_builder->set_extra_for('passwd', ['placeholder' => $this->lang->line('Password'), 'class' => 'form-control login password-field']);
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('login', 'index');
        $this->db->cache_delete('login', 'modify');
    }

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Login')]);
        if ($hook === 'lista') {
            
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona') {
            
        } elseif ($hook === 'novo') {
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Member Login'),
                'form_description' => $this->lang->line('Please provide your details'),
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            unset($data['submit']);
            var_dump($data);
            die;
        }
        return parent::get_data($hook, $data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/head', $this->view_sequece) => 'login/head']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/javascript', $this->view_sequece) => 'login/javascript']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/nav_bar', $this->view_sequece) => 'login/nav_bar']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'login/form']);
        parent::show_form($data);
    }

}
