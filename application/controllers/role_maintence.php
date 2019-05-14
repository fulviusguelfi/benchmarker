<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role
 *
 * @author fulvi
 */
class role_maintence extends BM_Controler {

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        if ($hook === 'lista') {
            $this->set_model('role');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Roles')]);
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona') {
            
        } elseif ($hook === 'altera') {
            
        } elseif ($hook === 'cria') {
            
        }
        return $data;
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'role_maintence/main']);
        parent::show_list($data);
    }

}
