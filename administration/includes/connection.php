<?php
    try{
        $db = new PDO('mysql:host=localhost;dbname=amina;port=3308', "root", "");
    } catch (PDOException $e){
        print "Erreur" . $e->getMessage() . "<br/>";
        die(); 
    }
?>