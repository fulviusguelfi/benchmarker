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
class user_maintence extends BM_Controler {

    public function __construct() {
        parent::__construct();
        $this->load->model('role');
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('user', $this->uri->segment(3, null));
        $this->bm_form_builder->exclude_form_values(['passwd']);
        $this->bm_form_builder->set_extra_for('first_name', ['placeholder' => '', 'class' => 'form-control ']);
        $this->bm_form_builder->set_extra_for('last_name', ['placeholder' => '', 'class' => 'form-control']);
        $this->bm_form_builder->set_extra_for('email', ['placeholder' => '', 'class' => 'form-control']);
        $this->bm_form_builder->set_extra_for('id_role', ['class' => 'form-control']);
        $this->bm_form_builder->set_options_for('id_role', $this->role->domain_list(['id', 'name']), false, 'id', 'name');
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('user', 'index');
        $this->db->cache_delete('user', 'modify');
    }

    protected function get_data($hook, $data): array {
        if ($hook === 'lista') {
            $this->set_model('user');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Users')]);
        } elseif ($hook === 'seleciona') {
            $this->bm_form_builder->hide_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Edit User'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'novo') {
            $this->bm_form_builder->exclude_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('New User'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            $this->set_model('user');
            unset($data['submit']);
        }
        return parent::get_data($hook, $data);
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/main', $this->view_sequece) => 'user_maintence/main',
            array_search('default/javascript', $this->view_sequece) => 'user_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Users')]);
        parent::show_list($data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/head', $this->view_sequece) => 'user_maintence/form/head',
            array_search('default/main', $this->view_sequece) => 'user_maintence/form',
            array_search('default/javascript', $this->view_sequece) => 'user_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Users')]);
        parent::show_form($data);
    }

}
