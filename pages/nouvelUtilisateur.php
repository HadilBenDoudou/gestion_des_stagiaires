<?php

require_once("connexiondb.php");

require_once("fonctions2.php");
$validationErrors = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = $_POST['login'];
    $pwd1 = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];
    $email = $_POST['email'];
    if (isset($login)) {
        $filtredLogin = filter_var($login, FILTER_SANITIZE_STRING);
        if (strlen($filtredLogin) < 4) {
            $validationErrors[] = "Erreur!!! Le login doit contenir au moins 4 caratères";
        }
    }

    if (isset($pwd1) && isset($pwd2)) {
        if (empty($pwd1)) {
            $validationErrors[] = "Erreur!!! Le mot ne doit pas etre vide";
        }
        if (md5($pwd1) !== md5($pwd2)) {
            $validationErrors[] = "Erreur!!! les deux mot de passe ne sont pas identiques";
        }
    }
    if (isset($email)) {
        $filtredEmail = filter_var($login, FILTER_SANITIZE_EMAIL);

        if ($filtredEmail != true) {
            $validationErrors[] = "Erreur!!! Email  non valid";
        }
    }
    if (empty($validationErrors)) {
        if (rechercher_par_login($login) == 0 & rechercher_par_email($email) == 0) {
            $requete = $pdo->prepare("INSERT INTO utilisateur(login,email,pwd,role,etat) 
                                        VALUES(:plogin,:pemail,:ppwd,:prole,:petat)");

            $requete->execute(array('plogin' => $login,
                'pemail' => $email,
                'ppwd' => md5($pwd1),
                'prole' => 'VISITEUR',
                'petat' => 0));

            $success_msg = "Félicitation, votre compte est crée, mais temporairement inactif jusqu'a activation par l'admin";
        } else {
            if (rechercher_par_login($login) > 0) {
                $validationErrors[] = 'Désolé le login exsite deja';
            }
            if (rechercher_par_email($email) > 0) {
                $validationErrors[] = 'Désolé cet email exsite deja';
            }
        }

    }

}
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>nouvelle utilisateur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="contact-form-03/css/style.css">
     <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
						<div class="row no-gutters">
							<div class="col-md-7">
								<div class="contact-wrap w-100 p-md-5 p-4">
									<h3 class="mb-4">Contactez-nous</h3>
									<div id="form-message-warning" class="mb-4"></div> 
				      		    <div id="form-message-success" class="mb-4">
				                 Your message was sent, thank you!
				      		    </div>
									<form class="form" method="post">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
												<label for="login">Login :</label>
                                                <input type="text" required="required" minlength="4" title="Le login doit contenir au moins 4 caractères..." name="login" placeholder="Taper votre nom d'utilisateur" autocomplete="off"class="form-control">
												</div>
											    </div>
											<div class="col-md-6"> 
												<div class="form-group">
												<label for="pwd">Mot de passe :</label>
                                                <input type="password" required="required" minlength="3" title="Le Mot de passe doit contenir au moins 3 caractères..." name="pwd1" placeholder="Taper votre mot de passe" autocomplete="new-password" class="form-control">
												</div>
											</div>
                                            <div class="col-md-6"> 
												<div class="form-group">
												<label for="pwd">confirmer Mot de passe :</label>
                                                <input type="password"  required="required" minlength="3" name="pwd2" placeholder="retaper votre mot de passe pour le confirmer" autocomplete="new-password" class="form-control">
												</div>
											</div>
                                            <div class="col-md-6"> 
												<div class="form-group">
												<label for="pwd">email:</label>
                                                <input type="email" required="required" name="email" placeholder="Taper votre email" autocomplete="off"  class="form-control">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Enregistrer">
												</div>
											</div>
										</div>
										
									</form>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-stretch">
								<div class="info-wrap w-100 p-5 img" style="background-image: url(contact-form-03/images/image.png);">
			                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/main.js"></script>
    <br>
    <!--k tbadel 7aja tarja3 mel loul-->
    <?php
    if (isset($validationErrors) && !empty($validationErrors)) {
        foreach ($validationErrors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
    }

    if (isset($success_msg) && !empty($success_msg)) {
        // Move the header() function before the echo statement
        header('refresh:4;url=login.php');
        echo '<div class="alert alert-success">' . $success_msg . '</div>';
    }
?>
</div>
</body>
</html>



