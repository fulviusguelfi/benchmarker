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
class Role_maintence extends BM_Controler {

    public function __construct() {
        parent::__construct();
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('role', $this->uri->segment(3, null));
        $this->bm_form_builder->set_extra_for('name', ['placeholder' => '', 'class' => 'form-control']);
    }

    protected function get_data($hook, $data): array {
        if ($hook === 'lista') {
            $this->set_model('role');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Roles')]);
        } elseif ($hook === 'seleciona') {
            $this->bm_form_builder->hide_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Edit Role'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'novo') {
            $this->bm_form_builder->exclude_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('New Role'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            $this->set_model('role');
            unset($data['submit']);
        }
        return parent::get_data($hook, $data);
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/main', $this->view_sequece) => 'role_maintence/main',
            array_search('default/javascript', $this->view_sequece) => 'role_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        parent::show_list($data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/head', $this->view_sequece) => 'role_maintence/form/head',
            array_search('default/main', $this->view_sequece) => 'role_maintence/form',
            array_search('default/javascript', $this->view_sequece) => 'role_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        parent::show_form($data);
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('role', 'index');
        $this->db->cache_delete('role', 'modify');
    }

}
