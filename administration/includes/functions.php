<?php 
    function auth($pseudo, $password)
    {
        require('includes/connection.php');

        $req = $db->prepare("SELECT * FROM users WHERE pseudo=:pseudo AND password=:password");

        $req->bindValue("pseudo", $pseudo);
        $req->bindValue("password", $password);

        $req->execute();

        $compteExiste = $req->rowCount();

        if($compteExiste > 0)
        {
            $dataCompte = $req->fetch();
            $_SESSION['pseudo'] = $dataCompte['pseudo'];
            $_SESSION['password'] = $dataCompte['password'];

            if($dataCompte['pseudo'] == $pseudo && $dataCompte['password'] == $password)
            {
                header('Location:backoffice.php');
            }
        } else {
            $_SESSION["erreur"] = "Erreur d'identifiants ou de mot de passe <br> Veuillez réessayer";
        }


        $req->closeCursor();

    }

    function mesContacts()
    {
        require('includes/connection.php');

        $req = $db->prepare("SELECT * FROM contacts ORDER BY datePublication");
        $req->execute();
        
        $contacts = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();

        return $contacts;
    }
?>