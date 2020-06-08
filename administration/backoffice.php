<?php 
session_start();
include('includes/functions.php');
include('includes/head.php');

if($_SESSION['pseudo'])
{
    $contacts = mesContacts();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Backoffice</title>
    </head>
    <body>
        <div class="container-fluid my-5">
            <a href="deconnexion.php" class="btn btn-secondary">Deconnexion</a>

            <div class="container">
                <h1 class="text-danger text-center">Bienvenue <?php echo $_SESSION['pseudo']; ?></h1>
                <h2 class="text-center">Voici la liste des clients</h2>
                <table id="tableContacts" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Objet</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($contacts as $contact) 
                            { ?>
                                <tr>
                                    <td><?php echo $contact->nom; ?></td>
                                    <td><?php echo $contact->prenom; ?></td>
                                    <td><?php echo $contact->email; ?></td>
                                    <td><?php echo $contact->contenu; ?></td>
                                    <td><?php echo $contact->datePublication; ?></td>
                                </tr>
                            <?php
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include('includes/scripts.php'); ?>
    </body>
    </html>

    <?php
} else {
    $_SESSION['message'] = "Veuillez vous authentifier";
    header('Location: index.php');
}
?>