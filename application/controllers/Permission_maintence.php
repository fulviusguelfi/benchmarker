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
class Permission_maintence extends BM_Controler {

    public function __construct() {
        parent::__construct();
        $this->load->model('role');
        $this->load->model('permission');
//        $this->load->model('permission_role');
    }

    protected function form_common() {
        $form_structure = $this->bm_form_builder->get_form_structure('permission') + $this->bm_form_builder->get_form_structure('permission_role');
        $form_values = $this->bm_form_builder->get_form_values('permission', $this->uri->segment(3, null));

        $permission_roles = $this->permission_role->search(['permission.id' => $form_values['permission.id']]);
        $form_values['permission_role.id_role'] = array_column($permission_roles, 'permission_role.id_role', 'permission_role.id');
        var_dump($form_values);
        die;


        $this->bm_form_builder->assign_vars($form_structure, $form_values);
        $this->bm_form_builder->exclude_form_values(['id_permission']);
        $this->bm_form_builder->set_extra_for('slug', ['placeholder' => '', 'class' => 'form-control']);
        $this->bm_form_builder->set_extra_for('id_role', ['class' => 'form-control']);
        $this->bm_form_builder->set_options_for('id_role', $this->role->domain_list(['id', 'name']), true, 'id', 'name');
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('permission', 'index');
        $this->db->cache_delete('permission', 'modify');
    }

    protected function get_data($hook, $data): array {
        if ($hook === 'lista') {
            $this->set_model('permission_role');
            $data = array_merge($data, ['list_title' => $this->lang->line('System Permissons & Roles')]);
        } elseif ($hook === 'seleciona') {
            $this->bm_form_builder->hide_form_values(['permission.id', 'permission_role.id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Edit Permission'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'novo') {
            $this->bm_form_builder->exclude_form_values(['permission.id', 'permission_role.id']);
            $data = array_merge($data, [
                'form_title' => $this->lang->line('New PermissionS'),
                'form_attributes' => ['class' => 'form-inline'],
            ]);
        } elseif ($hook === 'altera' || $hook === 'cria' || $hook === 'remove') {
            $this->set_model('permission');
            unset($data['submit']);
        }
        return parent::get_data($hook, $data);
    }

    public function show_list(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/main', $this->view_sequece) => 'permission_maintence/main',
            array_search('default/javascript', $this->view_sequece) => 'permission_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        parent::show_list($data);
    }

    public function show_form(array $data) {
        $this->view_sequece = array_replace($this->view_sequece, [
            array_search('default/head', $this->view_sequece) => 'permission_maintence/form/head',
            array_search('default/main', $this->view_sequece) => 'permission_maintence/form',
            array_search('default/javascript', $this->view_sequece) => 'permission_maintence/javascript',
        ]);
        $data = array_merge($data, ['page_title' => $this->lang->line('System Roles')]);
        parent::show_form($data);
    }

}
