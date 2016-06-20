<?php

require_once("Database.php");

$db = new Database("database", Driver::MySQL);

$table = $db->table("users")
            ->select("DISTINCT role")
            ->select("count(*) as counter")
            ->group("role");

echo $table->getQuery() ."<br><br>";

$table->get(function ($row) {
    echo "role: " . $row['role'] . ", count: " . $row['counter'] . "<br>";
});