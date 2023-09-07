<?php

require_once('class/Crud.php');

try {
    $pdo = new Crud(); // Your database connection
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


include_once("texts-show.php");


?>