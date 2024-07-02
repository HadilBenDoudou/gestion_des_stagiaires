<?php
require_once 'connexiondb.php';
require_once 'fonctions2.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'mailer/autoload.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $user = rechercher_user_par_email($email);
        function genererMotDePasse($longueur = 8) {
            // Caractères pouvant être utilisés dans le mot de passe
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
            // Mélanger les caractères
            $melangeCaracteres = str_shuffle($caracteres);
            // Extraire la portion souhaitée pour former le mot de passe
            $motDePasse = substr($melangeCaracteres, 0, $longueur);
            return $motDePasse;
        }
        if ($user !== null) {
            $id = $user['iduser'];
            // plus de securiter
            $newPassword = genererMotDePasse(8);
            try {
                // Update mot de passe dans la base
               $stmt = $pdo->prepare("UPDATE utilisateur SET pwd=:newPassword WHERE iduser=:id");
               $stmt->bindParam(':newPassword', $newPassword);
               $stmt->bindParam(':id', $id);
if ($stmt->execute()) {
    // Generate a random temporire mot de passe
    $temporaryPassword = md5($newPassword);
    // Insert temporere mot de passe  dans table nommer 'oublier' .
    $stmtOublier = $pdo->prepare("INSERT INTO oublier (email, login, password) VALUES (:email, :login, :hashedTemporaryPassword)");
    $stmtOublier->bindParam(':email', $email);
    $stmtOublier->bindParam(':login', $user['login']);
    $stmtOublier->bindParam(':hashedTemporaryPassword', $temporaryPassword);
    $stmtOublier->execute();


    //  update nouveau mot de passe  dans table 'utilisateur' par mot de passe plus securiser 
    $stmtUpdateUser = $pdo->prepare("UPDATE utilisateur SET pwd=:hashedTemporaryPassword WHERE iduser=:id");
    $stmtUpdateUser->bindParam(':hashedTemporaryPassword', $temporaryPassword);
    $stmtUpdateUser->bindParam(':id', $id);
    $stmtUpdateUser->execute();
                    // envoyer mail
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Replace par votre SMTP 
                    $mail->SMTPAuth = true;
                    $mail->Username = 'consultwedo@gmail.com'; // Replace par votre email
                    $mail->Password = 'wsde nowg lpbr lspu'; // Replace par votre mot de passe 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->setFrom('consultwedo@gmail.com', 'wedo consult');
                    $mail->addAddress($user['email']);
                    $mail->Subject = "Initialisation de votre mot de passe";
                    $mail->Body = "Votre nouveau mot de passe est: $newPassword. Veuillez le modifier à la prochaine ouverture de session.";

                    if ($mail->send()) {
                        $msg = "Un message contenant votre nouveau mot de passe a été envoyé sur votre adresse Email.";
                    } else {
                        throw new Exception("Erreur lors de l'envoi de l'e-mail: " . $mail->ErrorInfo);
                    }
                } else {
                    throw new Exception("Erreur lors de la mise à jour du mot de passe: " . implode(", ", $stmt->errorInfo()));
                }
            } catch (Exception $e) {
                $msg = "Erreur: " . $e->getMessage();
            }
        } else {
            $msg = "L'Email est incorrect.";
        }
    } else {
        $msg = "Veuillez saisir une adresse email.";
    }
}
?>
<!--fin de php-->
<!doctype html>
<html lang="en">
  <head>
  	<title>Initialiser votre mot de passe</title>
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
			
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="wrapper">
						<div class="row mb-5">
							<div class="col-md-3">
								<div class="dbox w-100 text-center">
			        		<div class="icon d-flex align-items-center justify-content-center">
			        			<span class="fa fa-map-marker"></span>
			        		</div>
			        		<div class="text">
				            <p><span>Address:</span>4ème étage, Bureau D2 Rue de la république, Grombalia, Tunisie, Grombalia, Nabeul</p>
				          </div>
			          </div>
							</div>
							<div class="col-md-3">
								<div class="dbox w-100 text-center">
			        		<div class="icon d-flex align-items-center justify-content-center">
			        			<span class="fa fa-phone"></span>
			        		</div>
			        		<div class="text">
				            <p><span>Phone:</span> <a href="tel://1234567920">+ 21672393679</a></p>
				          </div>
			          </div>
							</div>
							<div class="col-md-3">
								<div class="dbox w-100 text-center">
			        		<div class="icon d-flex align-items-center justify-content-center">
			        			<span class="fa fa-paper-plane"></span>
			        		</div>
			        		<div class="text">
				            <p><span>Email:</span> <a href="contact@wedo-consult.com">contact@wedo-consult.com</a></p>
				          </div>
			          </div>
							</div>
							<div class="col-md-3">
								<div class="dbox w-100 text-center">
			        		<div class="icon d-flex align-items-center justify-content-center">
			        			<span class="fa fa-globe"></span>
			        		</div>
			        		<div class="text">
				            <p><span>linkedin</span> <a href="#">WeDo Consult</a></p>
				          </div>
			          </div>
							</div>
						</div>
						<div class="row no-gutters">
							<div class="col-md-7">
								<div class="contact-wrap w-100 p-md-5 p-4">
									<h3 class="mb-4">Initialiser votre mot de passe</h3>
                                    <label class="control-label">Veuillez saisir votre email de récupération</label>
									<div id="form-message-warning" class="mb-4"></div> 
									<form method="POST" id="contactForm" method="post" class="contactForm">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Entrer votre email"/>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
                                                <button type="submit" class="btn btn-primary">Initialiser le mot de passe</button>
													<div class="submitting"></div>
												</div>
											</div>
										</div>
										<p class="text-right">
									</form>
								</div>
                                <div class="text-center">
        <!--afficher message si envoyer-->
        <?php
        if (isset($msg)) {
            if (strpos($msg, 'Erreur') !== false) {
                echo '<div class="alert alert-danger">' . $msg . '</div>';
            } else {
                echo '<div class="alert alert-success">' . $msg . '</div>';
                header("refresh:3;url=login.php");
                exit();
            }
        }
        ?>
        <!--fin php-->
                        </div>
						</div>
					<div class="col-md-5 d-flex align-items-stretch">
						<div class="info-wrap w-100 p-5 img" style="background-image: url(contact-form-03/images/img.png);">
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
</body>
</html>


