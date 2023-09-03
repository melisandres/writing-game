<?php
$pageName = "edit!";

if(!isset($_POST['id']) || $_POST['id']==null){
    header('location:index.php');
    exit;
}

$id = $_POST['id'];

require_once('class/Crud.php');
$crud = new Crud;

$selectText = $crud->selectIdText('text', $id);
$selectKeywords = $crud->selectKeywords($id);

extract($selectText);

include_once("snippets/header.html");
?>


    <form action="text-update.php" method="post">
        <span class="author"> <?=$selectText['firstName']." ".$selectText['lastName']?></span>
        <input type="hidden" name="id" value="<?=$id;?>">
        <label>title: 
            <input type="text" name="title" value="<?=$selectText['title']?>">
        </label>
        <label>write max 50 words: 
            <textarea name="writing" rows="10" cols="50"  value=""><?=$selectText['writing']?></textarea>
        </label>
            <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s") ?>">
        <input type="submit" value="save">
    </form>
    

    
<?php
include_once("snippets/footer.html");
?>