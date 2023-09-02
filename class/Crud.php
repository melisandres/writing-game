<?php

class Crud extends PDO{
    public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=tag; port=8889; charset=utf8', 'root', '');
    }

    public function select($table, $field = 'id', $order = 'ASC'){
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }


    public function selectId($table, $value, $field='id', $url='writer-show'){
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        //SELECT * FROM $table WHERE $field = :id
        //the : is a "bind" and creates a hidden variable inside... 
        
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        }

        return $stmt->fetch();
    }


    public function selectKeyword($idValue, $field='id'){
        $sql = "SELECT word, id FROM keyword INNER JOIN text_has_keyword ON keyword_id = keyword.id WHERE text_id = :$field";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $idValue);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id']] = $row['word'];
        }
    
        return $result;
    }


    public function selectIdText($table, $idValue, $field='id', $url='writer-show'){
        $sql = "SELECT text.*, writer.firstName AS firstName, writer.lastName AS lastName
        FROM text
        INNER JOIN writer ON text.writer_id = writer.id WHERE $table.$field = :$field;";
        
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $idValue);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        }

 
    }

    public function selectWordId($assArr){
        $value = $assArr['word'];
        $sql = "SELECT id FROM keyword WHERE word = :word;";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":word", $value);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            exit;
        }



    }



    public function selectText($table, $field = 'id'){
        $sql = "SELECT text.*, writer.firstName AS firstName, writer.lastName AS lastName
        FROM text
        INNER JOIN writer ON text.writer_id = writer.id;";


        //I need to make sure that I'm using : these to "prepare" my id... and other fields... but at the moment... it may be difficult with the dots. 
        
        $stmt = $this->prepare($sql);
        //$stmt->bindValue(":$field", $value);
        $stmt->execute();

        /* $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        } */

        return $stmt->fetchAll();

    }





    public function selectWriters($table, $cell1, $cell2, $cell3){
        $sql = "SELECT $cell1, $cell2, $cell3 FROM $table";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }



    public function insert($table, $data, $keyWordInsert = false){
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $keywordExtra = "";
        if ($keyWordInsert){
            $keywordExtra = "ON DUPLICATE KEY UPDATE word = VALUES(word)";
        }

        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldValue) $keywordExtra";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
        }

        $stmt->execute();

        return $this->lastInsertId();

/*         if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
        } */
    }

    public function delete($table, $value, $url, $field='id'){
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql); 
        $stmt->bindValue(":$field", $value);
        $stmt->execute(); 

        header("location:$url.php");
    }

    public function update($table, $data, $field = 'id'){
        $fieldName = null;

        foreach ($data as $key => $value) {
            $fieldName .= "$key = :$key, "; 
        }

        $fieldName = rtrim($fieldName, ", ");

        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field;";



        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);

        }


        if($stmt->execute()){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }else{
            print_r($stmt->errorInfo());
        }

    }

}

?>