<?php

class Migrate extends BM_Controler {

    public function index() {
        $this->lang->load('migration/migration', $this->config->item('language'));
        $this->load->library('migration');

        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo '<h1>Migration: ' . $this->migration->current() . '</h1>';
        }
    }

}
