<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once(APPPATH.'core/BM_Controller.php');

class Logout extends BM_Controler {

    protected $redirect_uri = '';

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
        return false;
    }

//    protected function cache_delete_db() {
//        $this->db->cache_delete('logout', 'index');
//        $this->db->cache_delete('logout', 'modify');
//    }

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Login')]);
        if ($hook === 'lista') {
            
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona') {
            
        } elseif ($hook === 'novo' || $hook === 'erro_novo') {
            $this->session->sess_destroy();
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            
        }
        return parent::get_data($hook, $data);
    }

    public function show_form(array $data) {
        redirect($this->redirect_uri);
    }

//    public function show_list(array $data) {
//        if (array_key_exists('is_valid_user', $data) && $data['is_valid_user']) {
//            redirect($this->redirect_uri);
//        } else {
//            redirect('login');
//        }
//    }
}
