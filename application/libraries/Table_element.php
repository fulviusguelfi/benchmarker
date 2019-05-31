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
        $base_uri = $uri;
        foreach ($collection as &$line) {
            $uri = $base_uri;
            if (is_array($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line[$id_column] : $uri;
                $line[$column] = ($append && isset($line[$column])) ? $line[$column] . anchor($uri, ($title ?? $line[$column]), $attributes) : anchor($uri, ($title ?? $line[$column]), $attributes);
            } elseif (is_object($line)) {
                $uri = ($id_column !== null) ? $uri . '/' . $line->{$id_column} : $uri;
                $line->{$column} = ($append && isset($line->{$column})) ? $line->{$column} . anchor($uri, ($title ?? $line->{$column}), $attributes) : anchor($uri, ($title ?? $line->{$column}), $attributes);
            }
        }
    }

    public function order_cols(&$array, $cols) {
        foreach ($array as &$arr) {
            $arr = array_merge(array_fill_keys($cols, null), $arr);
        }
    }

    public function delete_cols(&$array, $col) {
        if (is_array($col)) {
            foreach ($col as $c) {
                if (!$this->delete_cols($array, $c)) {
                    return false;
                }
            }
        } else {
            return array_walk($array, function (&$v, $k, $key) {
                unset($v[$key]);
            }, $col);
        }
    }

//    public function add_element_anchor_popup(array &$collection, string $column, bool $append = false, string $uri, $title = null, $attributes = false, $id_column = null) {
//        foreach ($collection as &$line) {
//            $title = ($title ?? $line[$column]);
//            if (is_array($line)) {
//                $uri = ($id_column !== null) ? $uri . '/' . $line[$id_column] : $uri;
//                $line[$column] = ($append && isset($line[$column])) ? $line[$column] . anchor_popup($uri, $title, $attributes) : anchor_popup($uri, $title, $attributes);
//            } elseif (is_object($line)) {
//                $uri = ($id_column !== null) ? $uri . '/' . $line->{$id_column} : $uri;
//                $line->{$column} = ($append && isset($line->{$column})) ? $line->{$column} . anchor_popup($uri, $title, $attributes) : anchor_popup($uri, $title, $attributes);
//            }
//        }
//    }
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
