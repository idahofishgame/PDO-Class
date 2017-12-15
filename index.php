<?php

// Example of using the PDO class

namespace IDFGPDO;

@require("DBConnFactory.php");

$db = new PDOConnectionFactory;

// example connection vars
$vars = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "ch",
];

// example query
$sql = "SELECT * FROM lookups";
$qry = $db->doQuery($sql, $vars);

// uncomment this to examine the result
/*
echo "<pre>";
var_dump($qry);
echo "</pre>";
*/

// simple example loop
foreach ($qry as $row) {
    echo $row['HUNT_AREA'] . "<br/>";
}

$db->close();
