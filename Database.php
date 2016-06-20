<?php

require_once("Driver.php");
require_once("Table.php");


class Database {

    public $DEFAULT_CHARSET = 'utf8';

    /** The PDO database connection object. */
    var $pdo;

    public function __construct ($dbname, $driver=Driver::MySQL, $host = 'localhost', $username = 'root', $password = '') {
        $dsn = "$driver:host=$host;dbname=$dbname;charset=$this->DEFAULT_CHARSET";

        try {
            $this->pdo = new PDO ($dsn, $username, $password);
        }
        catch (PDOException $e) {
            // Unknown database
            if ($e->getCode() == 1049) {
                die ($e->getMessage());
            }
            else {
                die ($e->getMessage());
            }
        }
    }

    public function table ($table) {
        if ($this->tableExists($table)) {
            return new Table($this, $table);
        }
        return NULL;
    }

    private function tableExists($table) {
        try {
            $result = $this->pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (Exception $e) {
            return FALSE;
        }

        return $result !== FALSE;
    }

    public function getPDO () {
        return $this->pdo;
    }

}
