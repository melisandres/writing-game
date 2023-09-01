<?php
$pageName = "show me!";

if(!isset($_GET['id']) || $_GET['id']==null){
    header('location:text-create.php');
    exit;
}

$id=$_GET['id'];


require_once('class/Crud.php');
$crud = new Crud;

$selectId = $crud->selectId('text', $id);

extract($selectId);


include_once("./snippets/header.html");
?>



    <p><strong>title: </strong><?=$title;?></p>
    <p><strong>date: </strong><?=$date;?></p>
    <p><strong>text: </strong><?=$writing;?></p>

    <form action="text-delete.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="delete" >
    </form>
    <form action="text-edit.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="Mise a jour" >
    </form>



<?php
    include_once("./snippets/footer.html");
?>