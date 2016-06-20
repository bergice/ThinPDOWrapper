<?php

require_once("Database.php");

class Table {

    var $db;
    var $table;
    var $selection;
    var $where;
    var $group;

    function __construct (Database $db, $table) {
        $this->db = $db;
        $this->table = array($table);
        $this->defaults();
    }

    /** Chainable method. */
    function defaults () {
        $this->selection = array();
        $this->where = array('1');
        $this->group = array();
        return $this;
    }

    private function add (&$array, $value) {
        if (!in_array($value, $array)) {
            $array[] = $value;
        }
        return $this;
    }

    /** Chainable method. */
    function select ($value = "*") {
        return $this->add($this->selection, $value);
    }

    /** Chainable method. */
    function where ($value) {
        return $this->add($this->where, $value);
    }

    /** Chainable method. */
    function group ($value) {
        return $this->add($this->group, $value);
    }

    function getQuery () {
        $what = "*";
        if (count($this->selection)!=0) $what = implode($this->selection, ',');
        $tables = implode($this->table, ',');
        $where  = implode($this->where, ' AND ');
        $group = null;
        if (count($this->group)!=0) $group = implode($this->group, ',');

        $query = "SELECT $what FROM $tables WHERE $where";
        if ($group != null) $query .=  " GROUP BY $group";

        return $query;
    }

    /** Chainable method. */
    function get ($callback) {
        $query = $this->getQuery();

        foreach ($this->db->getPDO()->query($query) as $row) {
            call_user_func($callback, $row);
        }

        return $this->defaults();
    }

}