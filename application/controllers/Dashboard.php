<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BM_Controler {

    public function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Dashboard')]);
        if ($hook === 'lista') {
            $this->load->model('role');
            $data = array_merge($data, [
                'roles' => $this->role->list($this->role->count_all, 0),
                'roles_caption' => '',
                'roles_title' => '',
            ]);
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona') {
            
        } elseif ($hook === 'altera') {
            
        } elseif ($hook === 'cria') {
            
        }
        return $data;
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'dashboard/main']);
        parent::show_list($data);
    }

}
