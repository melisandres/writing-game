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

    public function selectId($table, $value, $field='id', $url='client-index'){
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        //SELECT * FROM $table WHERE $field = :id
        //the : is a "bind" and creates a hidden variable inside... 
        
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        //:id = $value 
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        }

        //other method prepare...

        return $stmt->fetch();
    }

    public function insert($table, $data){
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldValue)";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
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