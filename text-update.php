<?php
require_once("class/Crud.php");
$crud = new Crud;

//FROM TEXT STORE:
//get the new keywords from POST, copy, and remove
$keywords = $_POST['keywords'];
unset($_POST['keywords']);


//NEW FOR THIS PAGE:
//get the previous keywords from POST, also remove
$lastKeywords = $_POST['lastKeywords'];
unset($_POST['lastKeywords']); 



//SIMILAR TO TEXT STORE, BUT WITH UPDATE:
//send what's left of the POST (text info) to CRUD
$update = $crud->update("text", $_POST);




//CHANGED from TEXT STORE:
//prepare keywords array... to send to CRUD
//words comes in as a string, and comes out as a clean arra
require_once('class/Prep.php');
$prep = new Prep;

$cleanedKeywords = $prep->keywords($keywords);
$cleanedLastKeywords = $prep->keywords($lastKeywords);
$wordsToCheck = array_diff($cleanedLastKeywords, $cleanedKeywords);



//FROM TEXT STORE-- except, we already did the trim
//each keyword needs to be treated:
foreach ($cleanedKeywords as $word) {
    //cleaned of spaces
    $assArr = ['word' => trim($word)];

    //inserted into the keywords table, (if it isn't already there)
    $crud->insert('keyword', $assArr, true);
    //we need that keyword's id: but we must remember that it comes as an array
    $keywordIdFromInsert = $crud->selectWordId($assArr);
    //with that id, we can build an associative array to send to text_has_keyword
    $textHasKeywordArray = ['text_id' => $_POST['id'], 'keyword_id' => $keywordIdFromInsert['id']];
    //now we can insert this keyword into text_has_keyword
    $crud->insertTextHasKeyWord('text_has_keyword',  $textHasKeywordArray);
}




if(isset($wordsToCheck) && !empty($wordsToCheck)){

    foreach($wordsToCheck as $word){
        //delete text_has_id lines for keywords no longer used
        $crud->deleteTextHasKeyword($word, $_POST['id']);

        //I'm getting errors here: I should possibly combine these two to make
        $wordsToCheck = array_filter($wordsToCheck, function($word) {
            return !empty($word);
        });

        //get an associative array with the whole keyword line
        $keywordInfos = $crud->selectId('keyword', $word, 'word', 'writers-show');
        //with the id, check if the key is being used elsewhere, if not, delete from keywords
        $crud->deleteUnusedKeywords($keywordInfos['id']);
    }
    header("location:texts-show.php");
}else{
    header("location:texts-show.php");
}








/* echo "lastkeywords:<br>";
var_dump($lastKeywords);
echo "<br>";
echo "keywords:<br>";
var_dump($keywords);
echo "<br>";
echo "words to delete:<br>";
var_dump($wordsToDelete);
die(); */




?>




