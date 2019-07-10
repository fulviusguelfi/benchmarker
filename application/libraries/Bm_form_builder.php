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
    protected $special_labels = [];

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url', 'form');
    }

    public function build_form() {

        //instantiate return values
        $return_values = array();

        //loop through form structure and output values
        foreach ($this->form_structure as $key => $value) {
            //Set build function to call
            $build_type = $this->determine_build($value['type']);

            if ($value['type'] == 'hidden') {
                $return_values["form_hidden_values"][$value['id']] = (isset($this->form_values[$value['id']]) ? $this->form_values[$value['id']] : '');
            } else {
                switch ($build_type) {
                    case 'build_input_boolean':
                        $return_values["display_values"][$this->$build_type($key, $value)] = form_label($this->pretty_label($key), $key, ['class' => 'choice']);
                        break;

                    default:
                        $return_values["display_values"][form_label($this->pretty_label($key), $key, ['class' => 'col-form-label'])] = $this->$build_type($key, $value);
                        break;
                }
            }
        }
        return $return_values;
    }

    public function set_value($input_name, $value) {
        $this->form_values[$input_name] = $value;
    }

    public function set_password_type($input_name, $length = null) {
        if (is_array($input_name)) {
            foreach ($input_name as $value) {
                $this->set_password_type($value);
            }
        } else {
            $index = $this->search_structure_key('id', $input_name);
            $this->form_structure[$index]['type'] = 'password';
            if($length !== null) {
                $this->form_structure[$index]['size'] = $length;
            }
        }
    }

    public function set_options_for($input_name, $options, bool $multiselect = false, string $value_col = 'value', string $label_col = 'label') {
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
    }

    public function set_extra_for($input_name, $extra) {
        if (isset($this->form_structure[$input_name])) {
            $this->form_structure[$input_name]['extra'] = $extra;
        } else {
            //show error
            echo 'extra_form_values array item not found in form_structure';
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
        return form_dropdown($input_name, $options, $selected, $extra_data) . form_error($input_name);
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
        return form_multiselect($input_name, $options, $selected, $extra_data) . form_error($input_name);
    }

    public function build_input_boolean($input_name, array $input_data) {
        extract($input_data);
        $extra_data = [
            'id' => $id,
            'name' => $input_name,
        ];

        if (isset($extra)) {
            $extra_data = array_merge($extra_data, $extra);
        }

        $checked = (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, false));
        return form_checkbox($input_name, TRUE, $checked, $extra_data) . form_error($input_name);
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
        return form_textarea($input_name, $value, $extra_data) . form_error($input_name);
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

        return form_input($input_name, (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, '')), $extra_data) . form_error($input_name);
    }

    public function build_input_password($input_name, array $input_data) {
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

        return form_password($input_name, (isset($this->form_values[$input_name]) ? $this->form_values[$input_name] : set_value($input_name, '')), $extra_data) . form_error($input_name);
    }

    public function search_structure_key($column_key, $value) {
        foreach ($this->form_structure as $key => $val) {
            if ($val[$column_key] === $value) {
                return $key;
            }
        }
        return null;
    }

    public function add_form_values(string $name, $structure = false, $value = null) {
        $default_structure = [
            'type' => 'text',
            'size' => '255',
            'placeholder' => '',
            'primary_key' => 0,
        ];
        if ($structure !== false && is_array($structure)) {
            $default_structure = array_merge($default_structure, $structure);
        }
        //set all properties
        $this->form_structure += [$name => ['id' => $name] + $default_structure];

        if ($value !== null && !empty($this->form_values)) {
            $this->form_values += [$name => $value];
        }
    }

    public function add_special_label($name, $label) {
        $this->special_labels[$name] = $label;
    }

    public function remove_special_label($name = null) {
        if ($name === null) {
            $this->special_labels = [];
        } else {
            unset($this->special_labels[$name]);
        }
    }

    protected function pretty_label($value) {
        if (array_key_exists($value, $this->special_labels)) {
            $exit = $this->special_labels[$value];
        } else {
            $CI = & get_instance();
            $value = str_replace("_", " ", $value);
            $value = str_replace("[]", "", $value);
            $exit = '';
            foreach (str_word_count($value, 2) as $key => $str_part) {
                if ($key === 0 && $CI->db->table_exists($str_part)) {
                    continue;
                }
                $exit .= ucfirst($str_part) . ' ';
            }
        }
        return $exit;
    }

}
