<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of table_element
 *
 * @author fulvi
 */
class Table_element {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url', 'form');
    }

    public function add_element_anchor(array &$collection, string $column, bool $append = false, string $uri, $title = null, $attributes, $id_column = null) {
        foreach ($collection as &$line) {
            $title = ($title ?? $line[$column]);
            if (is_array($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line[$id_column] : $uri;
                $line[$column] = ($append && isset($line[$column])) ? $line[$column] . anchor($uri, $title, $attributes) : anchor($uri, $title, $attributes);
            } elseif (is_object($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line->{$id_column} : $uri;
                $line->{$column} = ($append && isset($line->{$column})) ? $line->{$column} . anchor($uri, $title, $attributes) : anchor($uri, $title, $attributes);
            }
        }
    }

    public function add_element_anchor_popup(array &$collection, string $column, bool $append = false, string $uri, $title = null, $attributes = false, $id_column = null) {
        foreach ($collection as &$line) {
            $title = ($title ?? $line[$column]);
            if (is_array($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line[$id_column] : $uri;
                $line[$column] = ($append && isset($line[$column])) ? $line[$column] . anchor_popup($uri, $title, $attributes) : anchor_popup($uri, $title, $attributes);
            } elseif (is_object($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line->{$id_column} : $uri;
                $line->{$column} = ($append && isset($line->{$column})) ? $line->{$column} . anchor_popup($uri, $title, $attributes) : anchor_popup($uri, $title, $attributes);
            }
        }
    }

//    public function add_element_form_button(array &$collection, string $column, bool $append = false, string $data, $content = null, $extra) {
//        foreach ($collection as &$line) {
//            $content = ($content ?? $line[$column]);
//            if (is_array($line)) {
//                $line[$column] = ($append && isset($line[$column])) ? $line[$column] . form_button($data, $content, $extra) : form_button($data, $content, $extra);
//            } elseif (is_object($line)) {
//                $line->{$column} = ($append && isset($line->{$column})) ? $line->{$column} . form_button($data, $content, $extra) : form_button($data, $content, $extra);
//            }
//        }
//    }

}
