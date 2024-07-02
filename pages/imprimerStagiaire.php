<?php
// Inclure le fichier de connexion à la base de données
require_once 'connexiondb.php';
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;

// Récupérer la liste des stagiaires depuis la base de données
$requeteStagiaires = "SELECT nom, prenom, carte_identite,email FROM stagiaire";
$resultatStagiaires = $pdo->query($requeteStagiaires);
$stagiaires = $resultatStagiaires->fetchAll(PDO::FETCH_ASSOC);
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
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="../pages/assets/css/imprimer.css" rel="stylesheet">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <script src="../pages/assets/js/imprimer.js"></script>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
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
        </nav>
      </div>
    </header>
    <!-- les attestation -->
    <div class="container" style="margin-right: 2000px;padding-bottom:1200px">
      <!-- Afficher le message de succès ici -->
      <?php
      // Vérifier si le paramètre GET "success" est défini et égal à "true"
      if (isset($_GET['success'])) {
        if ($_GET['success'] === 'true') {
          // Afficher le message de succès
          echo '<div class="alert alert-success" role="alert">L\'e-mail a été envoyé avec succès.</div>';
        } else {
          // Afficher le message d'erreur
          echo '<div class="alert alert-danger" role="alert">Erreur : L\'e-mail n\'a pas pu être envoyé.</div>';
        }
      }
      ?>

      <h2>les attestations des stagiaires</h2>
      <button id="button1" onmouseover="this.style.backgroundColor='#f16623'" onmouseout="this.style.backgroundColor='#040b14'">
        <a class="email" href="../pages/assets/images/doc1.pdf" style="color:white;">Attestation d'inscription</a>
      </button><br>
      <button id="button1" onmouseover="this.style.backgroundColor='#aaaaad'" onmouseout="this.style.backgroundColor='#040b14'">
        <a style="color:white; text-decoration: none;" class="email" href="../pages/assets/images/doc2.pdf">
          Demande de Stage
        </a>
      </button>

      <button id="button1" onmouseover="this.style.backgroundColor='#f7941d'" onmouseout="this.style.backgroundColor='#040b14'"><a style="color: white;" class="email" onclick="showModal('attestationScolaireModal')">
          Attestation de scolarité</a></button>
      <div id="attestationScolaireModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="email" style="text-align: center;margin-left: 140px;"><strong>Attestation Scolaire</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 150px;">
                <a href="imprimerStagiaire.php?idUser=<?php echo $sender; ?>" aria-hidden="true">&times;</a>
              </button>
            </div>

            <div class="modal-body">
              <!-- Contenu de l'attestation scolaire modal -->
              <form action="../pages/generate/index.php" method="post" id="attestationForm" style="margin-left: 140px;">
                <label for="stagiaire">Stagiaire :</label><br>
                <!-- Utiliser une liste déroulante pour afficher les stagiaires existants -->
                <select name="stagiaire" id="stagiaire" onchange="updateFields()">
                  <option value="">Sélectionner un stagiaire</option>
                  <?php foreach ($stagiaires as $stagiaire) : ?>
                    <?php
                    $nom = $stagiaire['nom'];
                    $prenom = $stagiaire['prenom'];
                    $carte_identite = $stagiaire['carte_identite'];
                    $email = $stagiaire['email']; // Add email field
                    ?>
                    <option value="<?php echo $carte_identite; ?>" data-nom="<?php echo $nom; ?>" data-prenom="<?php echo $prenom; ?>" data-email="<?php echo $email; ?>"><?php echo $nom . ' ' . $prenom . ' - ' . $carte_identite; ?></option>
                  <?php endforeach; ?>
                </select><br>
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" required><br>
                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" required><br>
                <label for="carte">Carte d'identité :</label><br>
                <input type="text" id="carte" name="carte" required><br>
                <label for="email">Email :</label><br> <!-- Add email label -->
                <input type="email" id="email" name="email" required><br> <!-- Add email input -->
                <br>

                <input type="submit" value="Générer l'attestation" class="btn btn-secondary" onmouseout="this.style.color='white'" style="background-color:#333; margin-right: 10px;">
                <div style="display: inline-block;">
                  <a href="imprimerStagiaire.php?idUser=<?php echo $sender; ?>" class="btn btn-secondary" style="margin-top: 10px;">Fermer</a>
                  <button type="submit" formaction="../pages/generate/envoyer.php?idUser=<?php echo $sender; ?>" class="btn btn-secondary" onmouseout="this.style.color='white'" style="margin-top: 10px;">envoyer l'attestation</button>

                </div>

              </form>







              <script>
                function updateFields() {
                  var select = document.getElementById("stagiaire");
                  var nomField = document.getElementById("nom");
                  var prenomField = document.getElementById("prenom");
                  var carteField = document.getElementById("carte");
                  var emailField = document.getElementById("email"); // Get email field

                  var selectedOption = select.options[select.selectedIndex];
                  if (selectedOption.value !== "") {
                    nomField.value = selectedOption.getAttribute("data-nom");
                    prenomField.value = selectedOption.getAttribute("data-prenom");
                    carteField.value = selectedOption.value;
                    emailField.value = selectedOption.getAttribute("data-email"); // Set email field value
                  } else {
                    nomField.value = "";
                    prenomField.value = "";
                    carteField.value = "";
                    emailField.value = ""; // Clear email field value
                  }
                }
              </script>

            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </body>

</html>