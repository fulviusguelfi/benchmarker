<?php

/*
  | Column           | Data type     | Note
  | ---------------- | ------------- | -------------------------------------
  | id               | INTEGER       | AUTO_INCREMENT, UNSIGNED                                                          |
  | uuid             | CHAR(36)      | or CHAR(16) binary                                                                |
  | title            | VARCHAR(255)  |                                                                                   |
  | full name        | VARCHAR(70)   |                                                                                   |
  | gender           | TINYINT       | UNSIGNED                                                                          |
  | description      | TINYTEXT      | often may not be enough, use TEXT
  instead
  | post body        | TEXT          |                                                                                   |
  | email            | VARCHAR(255)  |                                                                                   |
  | url              | VARCHAR(2083) | MySQL version < 5.0.3 - use TEXT                                                  |
  | salt             | CHAR(x)       | randomly generated string, usually of
  fixed length (x)
  | digest (md5)     | CHAR(32)      |                                                                                   |
  | phone number     | VARCHAR(20)   |                                                                                   |
  | US zip code      | CHAR(5)       | Use CHAR(10) if you store extended
  codes
  | US/Canada p.code | CHAR(6)       |                                                                                   |
  | file path        | VARCHAR(255)  |                                                                                   |
  | 5-star rating    | DECIMAL(3,2)  | UNSIGNED                                                                          |
  | price            | DECIMAL(10,2) | UNSIGNED                                                                          |
  | date (creation)  | DATE/DATETIME | usually displayed as initial date of
  a post                                       |
  | date (tracking)  | TIMESTAMP     | can be used for tracking changes in a
  post                                        |
  | tags, categories | TINYTEXT      | comma separated values *                                                          |
  | status           | TINYINT(1)    | 1 – published, 0 – unpublished, … You
  can also use ENUM for human-readable
  values
  | json data        | JSON          | or LONGTEXT
 */

/**
 * Description of Migration_Add_user
 *
 * @author fulvi
 */
class Migration_Add_user extends CI_Migration {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->lang->load('table/role', $this->config->item('language'));
        $this->lang->load('table/behavior', $this->config->item('language'));
        $this->db->cache_delete_all();
    }

    public function up() {





        //table sub_hability
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'hint' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'weigth' => array(
                'type' => 'FLOAT',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'max_expected_per_minute' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_hability_level' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_scale' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_scale_analogic_type_sub_hability' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('sub_hability', TRUE, $attributes);

        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name' => array(
                'type' => 'INT',
            ),
            'content' => [
                
            ],
            'assert' => [
                
            ],
        ]);
        $this->dbforge->create_table('scale_analogic_type_sub_hability', TRUE, $attributes);
        
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'id_hability' => array(
                'type' => 'INT',
            ),
            'id_sub_hability' => array(
                'type' => 'INT',
            ),
        ]);
        $this->dbforge->create_table('hability_sub_hability', TRUE, $attributes);
        
        
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_sub_hability' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'text_or_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('sub_hability_sample', TRUE, $attributes);


        //table hability_level
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'id_hability' => array(
                'type' => 'INT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_level' => array(
                'type' => 'INT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'permited_qtd_expected_per_minute' => array(
                'type' => 'FLOAT',
//                'constraint' => '255',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('hability_level', TRUE, $attributes);

        //table scale
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'level' => array(
                'type' => 'FLOAT',
//                'constraint' => '3',
//                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('scale', TRUE, $attributes);
        $this->db->insert('scale', [
            'level' => 0,
            'title' => $this->lang->line('not desired behavior'),
        ]);
        $this->db->insert('scale', [
            'level' => 0.5,
            'title' => $this->lang->line('you got something'),
        ]);
        $this->db->insert('scale', [
            'level' => 1,
            'title' => $this->lang->line('now at baby steps'),
        ]);
        $this->db->insert('scale', [
            'level' => 1.5,
        ]);
        $this->db->insert('scale', [
            'level' => 2,
        ]);
        $this->db->insert('scale', [
            'level' => 2.5,
        ]);
        $this->db->insert('scale', [
            'level' => 3,
        ]);
        $this->db->insert('scale', [
            'level' => 3.5,
        ]);
        $this->db->insert('scale', [
            'level' => 4,
        ]);
        $this->db->insert('scale', [
            'level' => 4.5,
        ]);
        $this->db->insert('scale', [
            'level' => 5,
        ]);


        //table hability
        $this->dbforge->add_field('id');
        $this->dbforge->add_field([
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
            'id_hability' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
//                'default' => 'King of Town',
//                'unique' => TRUE,
//                'unsigned' => TRUE,
//                'auto_increment' => TRUE
            ),
        ]);
        $this->dbforge->create_table('hability', TRUE, $attributes);
//        $this->db->insert('user', [
//            'first_name' => 'Fulvius',
//            'last_name' => 'Titanero Guelfi',
//            'email' => 'fulvius@gpmail.com.br',
//            'passwd' => 'h7t846m2',
//            'id_role' => $administratos_insert_id
//        ]);








        $this->db->cache_delete_all();
        return true;
    }

    public function down() {
        $this->dbforge->drop_table('user_element_behavior');
        $this->dbforge->drop_table('element');
        $this->dbforge->drop_table('permission');
        $this->dbforge->drop_table('user');
        $this->dbforge->drop_table('behavior');
        $this->dbforge->drop_table('role');
//        $this->dbforge->drop_table('migrations');
        $this->db->cache_delete_all();
        return true;
    }

}
