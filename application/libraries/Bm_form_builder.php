<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'formBuilder.php';

/**
 * Description of BM_form_builder
 *
 * @author fulvi
 */
class Bm_form_builder extends formBuilder {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url', 'form');
    }

    public function set_options_for($input_name, $options, bool $multiselect = false, string $value_col = 'value', string $label_col = 'label') {
        if (!is_array($input_name)) {
            $index = $this->search_structure_key('id', $input_name);
            $temp_item = $this->form_structure[$index];
            $temp_value = $this->form_values[$index];
            unset($this->form_structure[$index]);
            unset($this->form_values[$index]);
            foreach (array_column($options, $label_col, $value_col) as $value => $label) {
                $temp_item['options'][$value] = $label;
            }
            $temp_item['type'] = ($multiselect) ? 'multiselect' : 'select';
            $this->form_structure[($multiselect) ? $input_name . '[]' : $input_name] = $temp_item;
            $this->form_values[($multiselect) ? $input_name . '[]' : $input_name] = $temp_value;
        } elseif (count($input_name) === 1) {
            $index_arr = $this->search_structure_key('id', $input_name);
            foreach ($index_arr as $k => $v) {
                $temp_item = $this->form_structure[$k][$v];
                $temp_value = $this->form_values[$k][$v];
                unset($this->form_structure[$k][$v]);
                unset($this->form_values[$k][$v]);
                foreach (array_column($options, $label_col, $value_col) as $value => $label) {
                    $temp_item['options'][$value] = $label;
                }
                $temp_item['type'] = ($multiselect) ? 'multiselect' : 'select';
                $this->form_structure[$k][($multiselect) ? $v . '[]' : $input_name[$k]] = $temp_item;
                $this->form_values[$k][($multiselect) ? $v . '[]' : $input_name[$k]] = $temp_value;
            }
        }
    }

    public function set_extra_for($input_name, $extra) {
        if (!is_array($input_name)) {
            if (isset($this->form_structure[$input_name])) {
                $this->form_structure[$input_name]['extra'] = $extra;
            } else {
                //show error
                echo 'extra_form_values array item not found in form_structure';
            }
        } elseif (count($input_name) === 1) {
            foreach ($input_name as $key => $value) {
                if (isset($this->form_structure[$key][$value])) {
                    $this->form_structure[$key][$value]['extra'] = $extra;
                } else {
                    //show error
                    echo 'extra_form_values array item not found in form_structure';
                }
            }
        }
    }

    public function hide_form_values(array $hidden_values) {
        foreach ($hidden_values as $value) {
            if (!is_array($value)) {
                if (isset($this->form_structure[$value])) {
                    $this->form_structure[$value]['type'] = "hidden";
                } else {
                    //show error
                    echo 'hide_form_values array item not found in form_structure';
                }
            } elseif (count($value) === 1) {
                foreach ($value as $k => $v) {
                    if (isset($this->form_structure[$k][$v])) {
                        $this->form_structure[$k][$v]['type'] = "hidden";
                    } else {
                        //show error
                        echo 'exclude_form_values array item not found in form_structure';
                    }
                }
            }
        }
    }

    public function exclude_form_values(array $excluded_values) {
        foreach ($excluded_values as $value) {
            if (!is_array($value)) {
                if (isset($this->form_structure[$value])) {
                    unset($this->form_structure[$value]);
                } else {
                    //show error
                    echo 'exclude_form_values array item not found in form_structure';
                }
            } elseif (count($value) === 1) {
                foreach ($value as $k => $v) {
                    if (isset($this->form_structure[$k][$v])) {
                        unset($this->form_structure[$k][$v]);
                    } else {
                        //show error
                        echo 'exclude_form_values array item not found in form_structure';
                    }
                }
            }
        }
    }

    public function build_input_select($input_name, array $input_data) {
        extract($input_data);

        if (!isset($options)) {
            $options = [];
        }

        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }

        $selected = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, ''));
        $this->CI->load->helper('form');
        return form_dropdown($input_name, $options, $selected, $extra_data);
    }

    public function build_input_multiselect($input_name, array $input_data) {
        extract($input_data);

        if (!isset($options)) {
            $options = [];
        }

        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }
        $selected = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, []));
        $this->CI->load->helper('form');
        return form_multiselect($input_name, $options, $selected, $extra_data);
    }

    public function build_input_textarea($input_name, array $input_data) {

        extract($input_data);
        $extra_data = [
            'id' => $id,
            'name' => $input_name,
            'type' => ($type ?? 'text'),
            'placeholder' => $placeholder,
            'maxlength' => ($size),
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }
        $value = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, ''));
        $this->CI->load->helper('form');
        return form_textarea($input_name, $value, $extra_data);
    }

    public function build_input($input_name, array $input_data) {
        extract($input_data);

        $extra_data = [
            'id' => $id,
            'name' => $input_name,
            'type' => ($type ?? 'text'),
            'placeholder' => $placeholder,
            'maxlength' => $size,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }

        return form_input($input_name, (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, '')), $extra_data);
    }

    public function search_structure_key($column_key, $value) {
        if (!is_array($value)) {
            foreach ($this->form_structure as $key => $val) {
                if ($val[$column_key] === $value) {
                    return $key;
                }
            }
        } elseif (count($value) == 1) {
            foreach ($value as $k => $v) {
                foreach ($this->form_structure[$k] as $key => $val) {
                    if ($val[$column_key] === $v) {
                        return [$k => $key];
                    }
                }
            }
        }
        return null;
    }

}
