<?php

require_once('class/Crud.php');
$crud = new Crud;

$insert = $crud->insert('text', $_POST);

echo $insert;

header("location:text-show.php?id=$insert");
?>