<!--debut de php-->
<?php
session_start();
if (isset($_SESSION['erreurLogin']))
    $erreurLogin = $_SESSION['erreurLogin'];
else {
    $erreurLogin = "";
}
session_destroy();
?>
<!--fin de php-->
<!doctype html>
<html lang="en">
  <head>
  	<title>login</title>
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
									<h3 class="mb-4">Contactez-nous</h3>
									<div id="form-message-warning" class="mb-4"></div> 
				      		<div id="form-message-success" class="mb-4">
				            Your message was sent, thank you!
				      		</div>
									<form method="POST" id="contactForm" action="seConnecter.php"  class="contactForm">
									<?php if (!empty($erreurLogin)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erreurLogin ?>
                    </div>
                <?php } ?>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
												<label for="login">Login :</label>
                <input type="text" name="login" placeholder="Login" class="form-control" autocomplete="off"/>
											</div>
											</div>
											<div class="col-md-6"> 
												<div class="form-group">
												<label for="pwd">Mot de passe :</label>
                <input type="password" name="pwd" placeholder="Mot de passe" class="form-control"/>
											</div>
											</div>
											<div class="col-md-12">
											<div class="form-group">
											<input type="submit" value="Se connecter" class="btn btn-primary">
										<div class="submitting"></div>
										</div>
										</div>
										</div>
										<p class="text-right">
                    <a href="InitialiserPwd.php">Mot de passe Oublié</a>&nbsp &nbsp
                    <a href="nouvelUtilisateur.php">Créer un compte</a></p></form></div></div>
					<div class="col-md-5 d-flex align-items-stretch">
					<div class="info-wrap w-100 p-5 img" style="background-image: url(contact-form-03/images/img.png);"></div></div></div></div></div></div></div></section>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>


