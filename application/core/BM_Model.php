<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of base
 *
 * @author fulvi
 */
class BM_Model extends CI_Model {

    public const DEFAULT_DIRECTION = 'ASC';
    public const TABLE_NAME = NULL;
    public const JOIN_TABLES = [];

    var $count_all = 0, $insert_id = FALSE, $update_id = FALSE;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db->flush_cache();
        $cl_name = static::class;
        if (file_exists(APPPATH . 'model/' . $cl_name . '_lang.php')) {
            $this->lang->load('model/' . $cl_name, $this->config->item('language'));
        }
        if ($this->db->table_exists($this->db->dbprefix(static::TABLE_NAME))) {
            if (!empty(static::JOIN_TABLES)) {
                $this->count_all = $this->__count_joined();
            } else {
                $this->count_all = $this->db->count_all($this->db->dbprefix(static::TABLE_NAME));
            }
//            $this->db->start_cache();
//            $this->db->from($this->db->dbprefix(static::TABLE_NAME));
//            $this->db->stop_cache();
        } else {
            show_error(sprintf($this->lang->line('Table %s not found'), static::TABLE_NAME));
        }
    }

    public function replace(array $where, string $key, array $new_values, array $old_values) {
        $arr_to_delete = array_diff($new_values, $old_values);
        $arr_to_insert = array_diff($old_values, $new_values);
        $this->db->trans_start();

        //delete
        $this->db->where($where);
        $this->db->where_in($key, $arr_to_delete);
        $this->db->delete($this->db->dbprefix(static::TABLE_NAME));
        $this->db->flush_cache();

        //insert
        foreach ($arr_to_insert as $value) {
            $this->add(array_merge($where, [$key => $value]));
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            log_message('error', 'Query excuted whit error:' . $this->db->last_query());
            log_message('error', $this->db->error());
            return FALSE;
        }
        return TRUE;
    }

    public function del($where) {
        if (!is_array($where)) {
            $this->db->where($this->db->dbprefix(static::TABLE_NAME) . '.' . $this->db->primary($this->db->dbprefix(static::TABLE_NAME)), $where);
            $result = $this->db->delete($this->db->dbprefix(static::TABLE_NAME));
        } else {
            $result = $this->db->delete($this->db->dbprefix(static::TABLE_NAME), $where);
        }
        log_message('debug', $this->db->last_query());
        $this->db->flush_cache();
        return $result;
    }

    public function add(array $value) {
        if (isset($value[$this->db->primary($this->db->dbprefix(static::TABLE_NAME))])) {
            return FALSE;
        }
        $result = $this->db->insert($this->db->dbprefix(static::TABLE_NAME), $value);
        if ($result) {
            $this->insert_id = $this->db->insert_id();
        } else {
            $this->insert_id = FALSE;
        }
        $this->db->flush_cache();
        log_message('debug', $this->db->last_query());
        return $result;
    }

    public function upd(array $value) {
        if (!isset($value[$this->db->primary($this->db->dbprefix(static::TABLE_NAME))])) {
            return FALSE;
        }
        $the_id = $value[$this->db->primary($this->db->dbprefix(static::TABLE_NAME))];
        unset($value[$this->db->primary($this->db->dbprefix(static::TABLE_NAME))]);
        $result = $this->db->update(static::TABLE_NAME, $value, $this->db->primary($this->db->dbprefix(static::TABLE_NAME))." = ".$the_id);
        if ($result) {
            $this->update_id = $the_id;
        } else {
            $this->update_id = FALSE;
        }
        $this->db->flush_cache();
        log_message('debug', $this->db->last_query());
        return $result;
    }

    public function search($where, int $limit = null, float $offset = 0, $oreder_by = NULL, $group_by = null): array {
        $this->db->start_cache();
        if (is_array($where)) {
            $this->db->where($where);
        } else {
            $this->db->where($this->db->dbprefix(static::TABLE_NAME) . '.' . $this->db->primary($this->db->dbprefix(static::TABLE_NAME)), $where);
            $limit = 1;
        }
        $this->db->stop_cache();
        return $this->list($limit, $offset, $oreder_by, $group_by);
    }
    
    public function domain_list(array $fields, $oreder_by = NULL, $group_by = null): array {
        $limit = $this->count_all;
        $offset = 0;
        $result = [];
        foreach ($fields as $fild) {
            $result[] = self::get_unique_fild_name($fild);
        }
        $this->db->distinct(TRUE);
        $this->__prepare_select($result);
        $this->__add_group_by($group_by);
        $this->__add_oreder_by($oreder_by);
        ($this->db->cache_on()) ? $query = $this->db->get() : log_message('error', 'db cache_on erro');
        ($this->db->cache_off()) ? log_message('error', 'db cache_off erro') : $result = ($query->result_array() ?? []);
        log_message('debug', 'Last query executed: ' . $this->db->last_query());
        $this->db->flush_cache();
        return $result;
    }

    public function distinct(bool $distinct = TRUE, array $fields = NULL, $where, int $limit = null, float $offset = 0, $oreder_by = NULL, $group_by = null): array {
        $result = [];
        foreach ($fields as $fild) {
            $result[] = self::get_unique_fild_name($fild);
        }
        $this->__prepare_select($result);
        $this->db->start_cache();
        $this->db->distinct($distinct);
        if (is_array($where)) {
            $this->db->where($where);
        } else {
            $this->db->where($this->db->dbprefix(static::TABLE_NAME) . '.' . $this->db->primary($this->db->dbprefix(static::TABLE_NAME)), $where);
            $limit = 1;
        }
        $this->db->stop_cache();
        $this->__add_join();
        $this->__add_group_by($group_by);
        $this->__add_oreder_by($oreder_by);
        $this->__add_limit($limit, $offset);
        ($this->db->cache_on()) ? $query = $this->db->get() : log_message('error', 'db cache_on erro');
        ($this->db->cache_off()) ? log_message('error', 'db cache_off erro') : $result = ($query->result_array() ?? []);
        log_message('debug', 'Last query executed: ' . $this->db->last_query());
        $this->db->flush_cache();
        return $result;
    }

    public function list(int $limit = null, float $offset = 0, $oreder_by = NULL, $group_by = null): array {
        $this->__prepare_select();
        $this->__add_join();
        $this->__add_group_by($group_by);
        $this->__add_oreder_by($oreder_by);
        $this->__add_limit($limit, $offset);
        ($this->db->cache_on()) ? $query = $this->db->get() : log_message('error', 'db cache_on erro');
        ($this->db->cache_off()) ? log_message('error', 'db cache_off erro') : $result = ($query->result_array() ?? []);
        log_message('debug', 'Last query executed: ' . $this->db->last_query());
        $this->db->flush_cache();
        return $result;
    }

    private function __prepare_select(array $filds = NULL): void {
        $this->db->start_cache();
        $this->db->select(($filds ?? self::list_unique_filds(null, true)));
        $this->db->from($this->db->dbprefix(static::TABLE_NAME));
        $this->db->stop_cache();
    }

    private function __add_join(array $tables = NULL, $include_select_fields = true): void {
        $tables = ($tables ?? static::JOIN_TABLES);
        $this->db->start_cache();
        foreach ($tables as $value) {
            if (is_array($value)) {
                if ($this->db->field_exists($value['on'], $this->db->dbprefix(static::TABLE_NAME))) {
                    $value['on'] = $this->db->dbprefix(static::TABLE_NAME) . '.' . $value['on'] . '_' . $value['table'] . ' = ' . $this->db->dbprefix($value['table']) . '.' . $value['on'];
                } elseif ($this->db->field_exists($value['on'], $this->db->dbprefix($value['table']))) {
                    $value['on'] = $this->db->dbprefix(static::TABLE_NAME) . '.' . str_replace('_' . $this->db->dbprefix(static::TABLE_NAME), '', $value['on']) . ' = ' . $this->db->dbprefix($value['table']) . '.' . $value['on'];
                }
                if ($include_select_fields) {
                    $this->db->select(self::list_unique_filds($this->db->dbprefix($value['table']), TRUE));
                }
                $this->db->join($this->db->dbprefix($value['table']), $value['on'], ($value['type'] ?? null));
            } elseif (is_object($value)) {
                if ($this->db->field_exists($value->on, $this->db->dbprefix(static::TABLE_NAME))) {
                    $value->on = $this->db->dbprefix(static::TABLE_NAME) . '.' . $value->on . '_' . $value->table . ' = ' . $this->db->dbprefix($value->table) . '.' . $value->on;
                } elseif ($this->db->field_exists($value->on, $this->db->dbprefix($value->table))) {
                    $value->on = $this->db->dbprefix(static::TABLE_NAME) . '.' . str_replace('_' . $this->db->dbprefix(static::TABLE_NAME), '', $value->on) . ' = ' . $this->db->dbprefix($value->table) . '.' . $value->on;
                }
                if ($include_select_fields) {
                    $this->db->select(self::list_unique_filds($this->db->dbprefix($value->table), TRUE));
                }
                $this->db->join($this->db->dbprefix($value->table), $value->on, ($value->type ?? null));
            }
        }
        $this->db->stop_cache();
    }

    private function __add_group_by($group_by = null): void {
        $this->db->start_cache();
        (!empty($group_by)) ? $this->db->group_by($group_by) : false;
        $this->db->stop_cache();
    }

    private function __add_oreder_by($oreder_by = NULL): void {
        $this->db->start_cache();
        (!empty($oreder_by)) ? $this->db->order_by($oreder_by) : $this->db->order_by($this->db->dbprefix(static::TABLE_NAME) . '.' . $this->db->primary($this->db->dbprefix(static::TABLE_NAME)), static::DEFAULT_DIRECTION);
        $this->db->stop_cache();
    }

    private function __add_limit(int $limit = null, float $offset = 0): void {
        $this->db->start_cache();
        $this->db->limit(($limit ?? $this->config->item('per_page')), $offset);
        $this->db->stop_cache();
    }

    public function get_unique_fild_name(string $fild, string $table_name = NULL, bool $alias = FALSE): string {
        $actual_table = ($table_name ?? $this->db->dbprefix(static::TABLE_NAME));
        if (!empty($actual_table)) {
            if ($this->db->field_exists($fild, $actual_table)) {
                return $actual_table . '.' . $fild . (($alias) ? ' as "' . $actual_table . '.' . $fild . '"' : '');
            }
        }
        return $fild;
    }

    public function list_unique_filds(string $table_name = NULL, bool $alias = FALSE): array {
        $actual_table = ($table_name ?? $this->db->dbprefix(static::TABLE_NAME));
        $result = [];
        if (!empty($actual_table)) {
            foreach ($this->db->list_fields($actual_table) as $fild) {
                if ($actual_table !== $this->db->dbprefix(static::TABLE_NAME) && $this->db->primary($actual_table) === $fild) {
                    //pass by primary key for join tables.
                    continue;
                } else {
                    $result[] = self::get_unique_fild_name($fild, $actual_table, $alias);
                }
            }
        }
        return $result;
    }

    private function __count_joined() {
        $all = false;
        if ($this->db->table_exists($this->db->dbprefix(static::TABLE_NAME))) {
            $this->__add_join(null, false);
            $all = $this->db->count_all_results($this->db->dbprefix(static::TABLE_NAME));
            $this->db->flush_cache();
        }
        return $all;
    }

}
