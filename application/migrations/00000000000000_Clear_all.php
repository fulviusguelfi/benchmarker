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
class Migration_Clear_all extends CI_Migration {

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->db->cache_delete_all();
    }

    public function up() {
        $this->db->cache_delete_all();
        return true;
    }

    public function down() {
        $this->db->cache_delete_all();
        return true;
    }

}
