<?php /*
					    if(isset($_POST['message'])){
					        $entete  = 'MIME-Version: 1.0' . "\r\n";
					        $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					        $entete .= 'From: ' . $_POST['email'] . "\r\n";

					        $message = '<h1>Message envoyé depuis la page Contact de monsite.fr</h1>
					        <p><b>Nom : </b>' . $_POST['nom'] . '<br>
					        <b>Email : </b>' . $_POST['email'] . '<br>
					        <b>Message : </b>' . $_POST['message'] . '</p>';

					        $retour = mail('destinataire@free.fr', 'Envoi depuis page Contact', $message, $entete);
					        if($retour) {
					            echo '<p>Votre message a bien été envoyé.</p>';
					        }
					    }*/




	function isEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function isPhone($phone) 
    {
        return preg_match("/^[0-9 ]*$/",$phone);
    }

    function ajouterContact($nom, $prenom, $email, $phone, $contenu)
    {
        require('administration/includes/connection.php');

        $req = $db->prepare("INSERT INTO contacts (nom, prenom, email, phone, contenu, datePublication) VALUES(:nom, :prenom, :email, :phone, :contenu, NOW() )");

        $req->bindValue(":nom", $nom);
        $req->bindValue(":prenom", $prenom);
        $req->bindValue(":email", $email);
        $req->bindValue(":phone", $phone);
        $req->bindValue(":contenu", $contenu);

        $req->execute();

        $req->closeCursor();
    }

    if(isset($_POST["butt_envoie"]))
    {
        if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['contenu']))
        {
            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['contenu']))
            {
                
                $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
                $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
                $contenu = htmlspecialchars(strip_tags(trim($_POST['contenu'])));

                $email = ($_POST['email']);

                $phone = ($_POST['phone']);

                if(isEmail($email))
                {
                    if(isPhone($phone))
                    {
                        try{
                            ajouterContact($nom, $prenom, $email, $phone, $contenu);
                            $successMessage = "Votre formulaire a été envoyé avec succès";
                            header('Refresh: 5');
                        } catch(PDOException $e){
                            echo 'Erreur' . $e;
                        }
                    } else {
                        $message = "Veuillez ne pas entrer d'espaces ni autres caractères spéciaux.";
                    }
                } else {
                    $message = "Ceci doit etre un email";
                }

            } else {
                $message = "Veuillez remplir tous les champs";
            }
        } else {
            $message = "Des champs de ce formulaire n'existent pas";
        }

    }
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/site.css" />
		<link rel="stylesheet" href="css/contact.css" />
			<meta  name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Contact</title>
	</head>

		<body>
			<div id="bloc_page">
				<header>
					<div id="menu_partie_haute">
						<nav id="menu1">
							<div><a href="devis.html"><mark class="bouton_menu1">Devis</mark></a></div>
							<div><a href="accueil.html"><img class="logo_du_site" src="images/logo.png" alt="logo_site"></a></div>
							<div><a href="contact.php"><mark class="bouton_menu1">Nous contacter</mark></a></div>
						</nav>
					</div>
					<div id="menu_partie_basse">
						<nav id="menu2">
							<ul>
								<div><a href="actu.html"><li>Notre actualité</li></a></div>
								<div><a href="events.html"><li>Evenements</li></a></div>
								<div><a href="story.html"><li>Notre Histoire</li></a></div>
							</ul>
						</nav>
					</div>
				</header>
				<div id="contenu_page">
					<div id="contenu_fond">
						<section id="formulaire">
							<p id="phrase_pre_formulaire"> Une question , une envie, une suggestion ou un problème ? <br>
							<br />
							Ce formulaire est fait pour vous !</p>

						

		          			<form method="post" action="" id="contact_form">
								<div>
									<label>- Votre nom</label> <br />
										<input type="text" name="nom" id="nom" placeholder="Jean-Michel Exemple" size="55" maxlength="50" />
								</div>

								<div>
									<label>- Votre prenom</label> <br />
									<input type="text" name="prenom" id="prenom" placeholder=" Cohen Exemple" size="55" maxlength="50" />
								</div>

								<div>
									<label>- Votre e-mail</label> <br />
									<input type="email" name="email" id="mail" placeholder="jean-michel.exemple@unemessagerie.com" size="55" maxlength="50" />
								</div>

								<div>
									<label>- Votre numero</label> <br />
									<input type="tel" name="phone" id="tel" placeholder="06...m" size="55" maxlength="50" />
								</div>

								<div>
									<label>- Votre message</label> <br />
									<textarea name="contenu" id="message" rows="5" ></textarea>
								</div>

								<div id="bouton_envoyer">
									<input type="submit" value="Envoyer" name="butt_envoie"/>
								</div>

								<div>
									<?php
                    			if(isset($message) && $message)
                    			{?>
                        			<div class="alert alert-danger text-center" role="alert">
                            			<h3><?php echo $message; ?></h3>
                        			</div>
                        
            			<?php   } elseif( isset($successMessage) && $successMessage){ ?>
                        			<div class="alert alert-success text-center" role="alert">
                            			<h3><?php echo $successMessage; ?></h3>
                        			</div>
                        
            			<?php  
                    			}

                		?>
								</div>
							</form>

							








							<script type="text/javascript">
								function envoi() {
									let infos = document.getElementById('contact_form');

									for(let i=0; i<infos.length-1; i++) {
										alert(infos[i].value);
									}

									alert("Votre message est bien envoyé. Merci et à bientôt !");
								}
							</script>
						</section>
					</div>
				</div>
				<footer>
					<a href="administration/index.php" class="btn btn-secondary">Espace réservé</a>
					<div class="facebook"><a href="https://www.facebook.com/Sweet-Sisters-95-114500276654186/"><img src="images/facebook.png" alt="facebook_logo"></a></div>
					<div class="instagram"><a href="https://www.instagram.com/sweet_sisters_95/?hl=fr"><img src="images/instagram.png" alt="instagram_logo"></a></div>
					<div class="twitter"><a href="https://mobile.twitter.com"><img 
						src="images/twitter.png" alt="twitter_logo"></a></div>
				</footer>
			</div>
		</body>