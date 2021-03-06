<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once(APPPATH.'core/BM_Controller.php');

class Welcome extends BM_Controler {

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

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Welcome')]);
        if ($hook === 'lista') {
            
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona') {
            
        } elseif ($hook === 'novo') {
            
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            unset($data['submit']);
        }
        return parent::get_data($hook, $data);
    }

//    public function show_list(array $data) {
//        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'welcome/main']);
//        var_dump($this->view_sequece);
//                die;
//        parent::show_list($data);
//    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/nav_bar', $this->view_sequece) => 'welcome/nav_bar']);
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'welcome/main']);
        parent::show_list($data);
    }

}
