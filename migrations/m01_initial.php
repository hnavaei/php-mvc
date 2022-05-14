<?php namespace app\migrations;

use app\core\Application;

class m01_initial{

    public function up(){
      $db = Application::$app->db;
      $db->pdo->exec("CREATE TABLE users (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          email VARCHAR(255) NOT NULL,
          password VARCHAR(255) NOT NULL,
          status TINYINT,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )ENGINE=INNODB");

    }

    public function down(){
        $db = Application::$app->db;
        $db->pdo->exec("DROP TABLE users");
    }
}