<?php
// Assurez-vous que l'utilisateur est connecté ou a les autorisations nécessaires pour éditer les utilisateurs
// Vous pouvez ajouter votre logique de vérification d'autorisation ici

require_once("connexiondb.php");
$sender = isset($_GET['sender']) ? $_GET['sender'] : null;
// Récupérer l'identifiant de l'utilisateur à partir de l'URL
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : null;

// Vérifier si l'identifiant de l'utilisateur est valide
if (!$idUser) {
  // Rediriger vers une page d'erreur ou afficher un message d'erreur
  echo "Identifiant d'utilisateur non fourni";
  exit; // Arrêter l'exécution du script
}

// Requête pour récupérer les détails de l'utilisateur à éditer
$requeteUtilisateur = "SELECT * FROM utilisateur WHERE iduser = :idUser";
$stmt = $pdo->prepare($requeteUtilisateur);
$stmt->bindParam(':idUser', $idUser);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe
if (!$utilisateur) {
  // Rediriger vers une page d'erreur ou afficher un message d'erreur
  echo "Utilisateur non trouvé";
  exit; // Arrêter l'exécution du script
}

// Afficher le formulaire d'édition de l'utilisateur
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Éditer l'utilisateur</title>
</head>

<body>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <script src="../pages/assets/js/updateutilisateur.js"></script>

  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/monstyle.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="../pages/assets/css/updateutilisateur.css" rel="stylesheet">
  </head>

  <body>

    <!-- ======= Mobile nav toggle button ======= -->
    <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

    <!-- ======= Header ======= -->
    <header id="header">
      <div class="d-flex flex-column">

        <div class="profile">
          <img src="assets/img/wedo-technologies.png" alt="" class="img-fluid rounded-circle">
          <h1 class="text-light"><a href="index2.php">WeDo Consult</a></h1>
          <div class="social-links mt-3 text-center">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
          </div>
        </div>

        <nav id="navbar" class="nav-menu navbar">
          <ul>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>bienvenus</span></a></li>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Filiere</span></a></li>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>#facts" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Stagiaire</span></a></li>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>document imprimer</span></a></li>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Utilisateurs</span></a></li>
            <li><a href="indexx.php?idUser=<?php echo $sender; ?>#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Compte</span></a></li>
            <li><a href="seDeconnecter.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Deconnexion</span></a></li>

          </ul>
        </nav><!-- .nav-menu -->
      </div>
    </header>
    <div class="container" style="margin-right: 2000px;">
      <h2>Éditer l'utilisateur</h2>
      <form action="modifierUtilisateur.php" method="POST">
        <input type="hidden" class="email" name="idUser" value="<?php echo $utilisateur['iduser']; ?>">
        <input type="text" class="email" id="login" name="login" value="<?php echo $utilisateur['login']; ?>">
        <input type="email" class="email" id="email" name="email" value="<?php echo $utilisateur['email']; ?>">
        <input type="text" class="email" id="role" name="role" value="<?php echo $utilisateur['role']; ?>">
        <input type="submit" class="register" style="margin-top: 20px;margin-left:60px;background-color:#414141;color:#fff" value="Enregistrer ">
      </form>
    </div>
  </body>

</html>