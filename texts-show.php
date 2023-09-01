<?php
require_once('class/Crud.php');

$crud = new Crud;
$select = $crud->select('text');
extract($select);

$pageName = "all the texts!";
include_once("./snippets/header.html"); ?>


<table>
        <tr>
            <th>title</th>
            <th>date</th>
            <th>writer_id</th>
        </tr>
        <?php
        foreach($select as $row){
        ?>
        <tr>
            <td><a href="text-show.php?id=<?= $row['id']?>"> <?= $row['title']; ?></a></td>
            <td><?= $row['date']; ?></td>
            <td><?= $row['writer_id']; ?></td>
        </tr>
        <?php
        }
        ?>


    </table>






<?php include_once("./snippets/footer.html"); ?>