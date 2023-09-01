<?php

print_r($_POST); 

require_once("class/Crud.php");
$crud = new Crud;
$update = $crud->update("text", $_POST);

echo $update;



?>