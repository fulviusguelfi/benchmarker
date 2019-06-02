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
class Element_maintence extends BM_Controler {

    public function __construct() {
        parent::__construct();
        $this->load->model('permission');
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('element', $this->uri->segment(3, null));
        $this->bm_form_builder->set_options_for('id_permission', $this->permission->domain_list(['id','slug']), false, 'id', 'slug');
        $this->bm_form_builder->set_extra_for('id_permission', ['class' => 'form-control']);
        $this->bm_form_builder->set_extra_for('description', ['placeholder' => '', 'class' => 'form-control']);
    }
    
    protected function cache_delete_db() {
        $this->db->cache_delete('element', 'index');
        $this->db->cache_delete('element', 'modify');
    }

    protected function get_data($hook, $data): array {
        if ($hook === 'lista') {
            $this->set_model('element');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Elements')]);
        } elseif ($hook === 'seleciona') {
            $this->bm_form_builder->hide_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Edit Element'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'novo') {
            $this->bm_form_builder->exclude_form_values(['id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('New Element'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            $this->set_model('element');
            unset($data['submit']);
        }
        return parent::get_data($hook, $data);
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/main', $this->view_sequece) => 'element_maintence/main',
            array_search('default/javascript', $this->view_sequece) => 'element_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Elements')]);
        parent::show_list($data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/head', $this->view_sequece) => 'element_maintence/form/head',
            array_search('default/main', $this->view_sequece) => 'element_maintence/form',
            array_search('default/javascript', $this->view_sequece) => 'element_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Elements')]);
        parent::show_form($data);
    }

}
