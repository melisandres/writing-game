<?php
include_once("snippets/header.html");

?>


    <form action="client-store.php" method="post">
        <label>Nom
            <input type="text" name="nom">
        </label>
        <label>Adresse
            <input type="text" name="adresse">
        </label>
        <label>Code postal
            <input type="text" name="postal_code">
        </label>
        <label>Courriel
            <input type="email" name="courriel">
        </label>
        <label>Telephone
            <input type="text" name="phone">
        </label>
        <label>Date de naissance
            <input type="date" name="naissance">
        </label>
        <input type="submit" value="save">
    </form>
    
<?php
include_once("snippets/footer.html");
?>