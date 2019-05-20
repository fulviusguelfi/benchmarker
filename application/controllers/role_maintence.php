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

    public function __construct() {
        parent::__construct();
    }

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        if ($hook === 'lista') {
            $this->set_model('role');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Roles')]);
        } elseif ($hook === 'busca') {
            $this->set_model('role');
        } elseif ($hook === 'seleciona') {
            $this->bm_form_builder->assign_vars('role', $this->uri->segment(3, null));
//            $this->bm_form_builder->set_options_for('name', [-1=>'teste'], true);
            $this->bm_form_builder->set_extra_for('name', ['class' => 'form-control']);
            $this->bm_form_builder->hide_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Edit Role'),
                'form_action' => $this->uri->uri_string(),
                'form_attributes' => ['class'=>'form-inline'],
                'page_title' => $this->lang->line('Edit System Role')]);
            $data = array_merge($data, $this->bm_form_builder->build_form());
        } elseif ($hook === 'altera') {
            
        } elseif ($hook === 'cria') {
            
        } elseif ($hook === 'remove') {
            var_dump($data);
            die;
        }
        return $data;
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/main', $this->view_sequece) => 'role_maintence/main',
            array_search('default/javascript', $this->view_sequece) => 'role_maintence/javascript',
        ]);
        parent::show_list($data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/head', $this->view_sequece) => 'role_maintence/form/head',
            array_search('default/main', $this->view_sequece) => 'role_maintence/form',
            array_search('default/javascript', $this->view_sequece) => 'role_maintence/javascript',
        ]);
        parent::show_form($data);
    }

}
