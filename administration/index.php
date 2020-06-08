<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php 
    include('includes/head.php');
    include('includes/functions.php'); 
    
    if(isset($_POST["butt"]))
    {
        if(isset($_POST["pseudo"]) && isset($_POST["password"]))
        {
            if(!empty('pseudo') && !empty('password'))
            {
                $pseudo = htmlspecialchars(strip_tags(trim($_POST['pseudo'])));

                $password_crypt = sha1(trim($_POST['password']));

                try{
                    auth($pseudo, $password_crypt);

                } catch(PDOException $e){
                    echo 'Erreur' . $e;
                }
            } else {
                $message = "Veuillez remplir tous les champs";
            }
        } else {
            $message = "Des champs du formulaire n'existent pas";
        }
    }


?>
<body>
    <div class="container-fluid mt-5">
        <a href="../index.php" class="btn btn-secondary">Page d'accueil</a>
        <h1 class="text-danger text-center my-5"><u>Espace d'administration</u></h1>
        <div class="container d-flex justify-content-center">
            <form method="post" action="">
                <div class="form-group">
                    <input class="form-control" type="text" name="pseudo" placeholder="Pseudo">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
                <div class="form-group text-center">
                    <input class="btn btn-success" type="submit" name="butt">
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/scripts.php'); ?>
</body>
</html>