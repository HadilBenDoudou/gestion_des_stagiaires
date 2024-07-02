<?php
session_start();
require_once 'connexiondb.php';
$sender = isset($_GET['id']) ? $_GET['id'] : null;
$msg = "";

// Vérifier si le compteur de tentatives existe en session
$attemptCount = isset($_SESSION['attempt_count']) ? $_SESSION['attempt_count'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $iduser = $_POST['id'];
  $oldpwd = $_POST['oldpwd'];
  $newpwd = $_POST['newpwd'];

  // Vérification de l'ancien mot de passe
  $requete = "SELECT * FROM utilisateur WHERE iduser = ? AND pwd = MD5(?)";
  $resultat = $pdo->prepare($requete);
  $resultat->execute([$iduser, $oldpwd]);

  if ($resultat->fetch()) {
    // Mise à jour du mot de passe
    $requete = "UPDATE utilisateur SET pwd = MD5(?) WHERE iduser = ?";
    $resultat = $pdo->prepare($requete);
    $resultat->execute([$newpwd, $iduser]);

    // Réinitialiser le compteur de tentatives
    unset($_SESSION['attempt_count']);

    $msg = "<div class='alert alert-success'>
                    <strong>Félicitations!</strong> Votre mot de passe a été modifié avec succès.
                </div>";
    header("Location: login.php");
    exit();
  } else {
    $attemptCount++;
    $_SESSION['attempt_count'] = $attemptCount;

    if ($attemptCount >= 3) {
      // Redirection après 3 tentatives
      header("Location: login.php");
      exit();
    }

    $remainingAttempts = 3 - $attemptCount; // Calculate remaining attempts
    $msg = "<div class='alert alert-danger'>
            <strong>Erreur!</strong> L'ancien mot de passe est incorrect. Nombre de tentatives restantes : $remainingAttempts
            </div>";
  }
}
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
    <div class="container" style="margin-right: 2000px;  height: 100vh;">

      <h2 style="text-align: center;">Modifier le mot de passe</h2>
      <?php echo $msg; ?>
      <form action="changer_mot_de_passe.php?id=<?php echo $sender; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">


        <input type="password" id="oldpwd" name="oldpwd" class="email" placeholder="Ancien mot de passe " required>


        <input type="password" id="newpwd" name="newpwd" class="email" placeholder="Nouveau mot de passe " required>

        <button type="submit" style="margin-top: 20px;margin-left:90px;background-color:#333">Modifier le mot de passe</button>
      </form>
    </div>
    </div>
  </body>

</html>