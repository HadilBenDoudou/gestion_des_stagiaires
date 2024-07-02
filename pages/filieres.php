<?php
require_once('identifier.php');
require_once("connexiondb.php");


$nomf = isset($_GET['nomF']) ? $_GET['nomF'] : "";
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : "all";

$size = isset($_GET['size']) ? $_GET['size'] : 6;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $size;

if ($niveau == "all") {
  $requete = "select * from filiere
                where nomFiliere like '%$nomf%'
                limit $size
                offset $offset";

  $requeteCount = "select count(*) countF from filiere
                where nomFiliere like '%$nomf%'";
} else {
  $requete = "select * from filiere
                where nomFiliere like '%$nomf%'
                and niveau='$niveau'
                limit $size
                offset $offset";

  $requeteCount = "select count(*) countF from filiere
                where nomFiliere like '%$nomf%'
                and niveau='$niveau'";
}

$resultatF = $pdo->query($requete);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="TemplateMo">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <title>les filieres</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-BJBs40zHwCJpXakFHA2WzSfxZRTKRXQ5LCRyyC+H8hT9KMfF+VCHc3IdEiNaK1vlyQJfQ8YrqV8tG0mZpvP/VA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/lightbox.css">
  <link rel="stylesheet" href="../pages/assets/css/filiere.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="../pages/assets/js/filiere.js"></script>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>

<body>


  <!-- Sub Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">

        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>

              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>




  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <div class="container-fluid">
              <div class="navbar-header">
                <a href="menu.html" class="logo">
                  WeDo Consult
                </a>
              </div>
              <ul class="nav">
                <li><a href="../index.php" class="scroll-to-section">Gestion des stagiaires</a></li>
                <li><a href="stagiaires.php" class="scroll-to-section">Les Stagiaires</a></li>
                <li><a href="#categorySelect">Les Filières</a></li>



                <li>
                  <a href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>">
                    <i class="fa fa-user-circle-o"></i>
                    <?php echo ' ' . $_SESSION['user']['login'] ?>
                  </a>
                </li>
                <li>
                  <a href="tache.php">
                    <i class="scroll-to-section"></i>
                    les taches
                  </a>
                </li>


                <li>
                  <a href="seDeconnecter.php">
                    <i class="scroll-to-section"></i>
                    Déconnecter
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </header>


  <!-- ***** header de filiere ***** -->
  <section class="section main-banner" id="top" data-section="section1">
    <video autoplay muted loop id="bg-video">
      <source src="assets/images/course-video.mp4" type="video/mp4" />
    </video>

    <div class="video-overlay header-text">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="caption">
              <h6>Bonjour à tous les stagiaires</h6>

              <p>nous sommes ravis de vous accueillir dans notre équipe. Nous espérons que votre expérience de stage sera enrichissante et que vous vous sentirez à l'aise parmi nous. N'hésitez pas à poser des questions et à profiter de cette opportunité pour apprendre et grandir professionnellement. Bonne chance dans vos missions et n'hésitez pas à nous solliciter si besoin .</p>
              <div class="main-button-red">
                <div class="scroll-to-section"><a href="#contact">Rejoignez-nous maintenant !</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** fin de header ***** -->

  <section class="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-service-item owl-carousel">

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-01.png" alt="">
              </div>
              <div class="down-content">
                <h4>stage d'initiation</h4>
                <p> Un stage d'observation permet à l'étudiant de découvrir le fonctionnement d'une entreprise ou d'une profession sans nécessairement être impliqué dans des tâches spécifiques. C'est souvent une introduction au monde professionnel.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="">
              </div>
              <div class="down-content">
                <h4>stage de perfectionement</h4>
                <p> Ce type de stage implique généralement la réalisation de tâches concrètes liées au domaine d'études de l'étudiant. Il offre une expérience pratique et permet de mettre en application les connaissances acquises en cours.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="">
              </div>
              <div class="down-content">
                <h4>pour les pfe</h4>
                <p> ce type de stage est réalisé en fin de cursus universitaire, le stage de fin d'études vise à permettre à l'étudiant de mettre en pratique l'ensemble de ses connaissances et compétences acquises au cours de sa formation.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="">
              </div>
              <div class="down-content">
                <h4>Stage en entreprise</h4>
                <p>Les stages en entreprise sont courants dans de nombreux domaines. Ils offrent une expérience directe dans le milieu professionnel et peuvent varier en fonction du secteur d'activité, de la taille de l'entreprise.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="">
              </div>
              <div class="down-content">
                <h4>Stage obligatoire </h4>
                <p>Certains cursus universitaires exigent la réalisation d'un stage obligatoire pour valider le diplôme. Ces stages sont souvent conçus pour intégrer la théorie enseignée en classe à des situations pratiques.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="upcoming-meetings" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>les spécialités de l'entreprise</h2>
          </div>
        </div>
        <?php
        require_once "connexiondb.php";

        // Récupérer les noms des encadreurs depuis la base de données
        $stmt = $pdo->prepare("SELECT nom, prenom, cv_path FROM encadreurs");
        $stmt->execute();
        $encadreurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="col-lg-4">
          <div class="categories">
            <h4>Les encadreurs</h4>
            <ul>
              <?php foreach ($encadreurs as $encadreur) : ?>
                <li style="display: flex; justify-content: space-between;">
                  <span><?php echo $encadreur['nom'] . ' ' . $encadreur['prenom']; ?></span>
                  <a href="<?php echo $encadreur['cv_path']; ?>" target="_blank" style="margin-left: 10px;">View More</a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>




        <div class="col-lg-8">
          <select id="categorySelect" style="width:700px;height:35px;background-color:#53585a;color: #ffffff;">
            <option class="option" value="all">All Categories</option>



            <!--petit php pour recherche-->
            <?php
            // Fetch unique filieres from the database
            $filiereQuery = "SELECT DISTINCT nomFiliere FROM filiere";
            $filiereResult = $pdo->query($filiereQuery);

            while ($filiere = $filiereResult->fetch()) {
              echo '<option class="option" value="' . strtolower($filiere['nomFiliere']) . '">' . $filiere['nomFiliere'] . '</option>';
            }
            ?>
            <!--petit php pour recherche fin-->


          </select>
          <button id="searchBtn">Search</button>

          <div class="row" id="filiere">

            <!-- faire recherche dynamique debut php -->
            <?php
            $filiereResult = $pdo->query("SELECT * FROM filiere");

            while ($filiere = $filiereResult->fetch()) {
              echo '<div class="col-lg-6 meeting-item ' . strtolower($filiere['nomFiliere']) . '" >';
              echo '<div class="thumb">';
              echo '<div class="price">';
              echo '<span>' . strtolower($filiere['nomFiliere']) . '</span>';
              echo '</div>';
              echo '<a href="meeting-details.html"><img src="assets/images/c3283fc1-bb4f-4e26-823b-41c7805d0c12.jpeg" alt="Meeting" style="height:300px"></a>';
              echo '</div>';
              echo '<div class="down-content">';
              echo '<div class="date">';
              echo '<h6>' . $filiere['niveau'] . ' <span><!-- Date or additional information --></span></h6>';
              echo '</div>';
              echo '<a href="meeting-details.html"><h4>' . $filiere['nomFiliere'] . '</h4></a>';
              echo '<p>Description or additional information about the filiere.</p>';



              echo '</div>';
              echo '</div>';
            }
            ?>
            <!-- End dynamic content -->
          </div>
        </div>
        <section class="apply-now" id="apply">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 align-self-center">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="item">
                      <h3>Objectifs du Stage</h3>
                      <p>Discutez des objectifs généraux du stage et de ce que l'entreprise ou l'institution espère accomplir en vous accueillant en tant que stagiaire.</p>
                      <div class="main-button-red">
                        <div class="scroll-to-section"><a href="#contact">bienvenus</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="item">
                      <h3>Projets Assignés</h3>
                      <p> Obtenez des informations détaillées sur les projets ou les tâches spécifiques qui vous seront assignés. Clarifiez les attentes quant aux résultats attendus.</p>
                      <div class="main-button-yellow">
                        <div class="scroll-to-section"><a href="#contact">bienvenus</a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="accordions is-first-expanded">
                  <article class="accordion">
                    <div class="accordion-head">
                      <span>Voici quelques langages de programmation populaires, chacun ayant ses propres forces et domaines d'application :</span>
                      <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                      </span>
                    </div>
                    <div class="accordion-body">
                      <div class="content">
                        <p>Le choix du langage de programmation dépend largement du contexte du projet, des préférences de l'équipe de développement, des exigences spécifiques de la tâche à accomplir et d'autres facteurs. voila un site qui aider<a href="https://openclassrooms.com/fr/" target="_parent">open classroom</a> plus d'information.</p>
                      </div>
                    </div>
                  </article>
                  <article class="accordion">
                    <div class="accordion-head">
                      <span>HTML CSS Bootstrap Layout</span>
                      <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                      </span>
                    </div>
                    <div class="accordion-body">
                      <div class="content">
                        <p>HTML (Hypertext Markup Language) : HTML est le langage de balisage standard utilisé pour créer et structurer le contenu d'une page web. Il définit les éléments tels que les titres, les paragraphes, les liens, les images, etc. dans un document web.<br><br>
                          CSS (Cascading Style Sheets) : CSS est utilisé pour styliser et mettre en forme le contenu HTML. Il permet de définir la présentation, les couleurs, la mise en page, les polices, etc. d'une page web.<br>
                          Bootstrap : Bootstrap est un framework front-end open-source développé par Twitter. Il fournit une collection d'outils et de composants pré-stylisés basés sur HTML, CSS, et JavaScript. Bootstrap permet de créer des pages web réactives et est largement utilisé pour le développement web rapide et la création d'interfaces utilisateur modernes.
                        </p>
                      </div>
                    </div>
                  </article>
                  <article class="accordion">
                    <div class="accordion-head">
                      <span>PHP</span>
                      <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                      </span>
                    </div>
                    <div class="accordion-body">
                      <div class="content">
                        <p>Un langage de script côté serveur largement utilisé pour le développement web dynamique. Il est souvent intégré dans le code HTML.<br><br>
                          <br>

                          <br>
                        </p>
                      </div>
                    </div>
                  </article>
                  <article class="accordion last-accordion">
                    <div class="accordion-head">
                      <span>jQuery </span>
                      <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                      </span>
                    </div>
                    <div class="accordion-body">
                      <div class="content">
                        <p>jQuery simplifie l'écriture du code JavaScript en fournissant des fonctions et des méthodes facilitant la manipulation du DOM (Document Object Model), la gestion des événements, les animations, les requêtes AJAX, et d'autres opérations courantes.<br><br>
                        </p>
                      </div>
                    </div>
                  </article>
                  <article class="accordion last-accordion">
                    <div class="accordion-head">
                      <span>java </span>
                      <span class="icon">
                        <i class="icon fa fa-chevron-right"></i>
                      </span>
                    </div>
                    <div class="accordion-body">
                      <div class="content">
                        <p>Un langage de programmation polyvalent utilisé pour le développement d'applications web, mobiles et d'entreprise. Il est également largement utilisé dans le développement d'applications Android.<br><br>
                        </p>
                      </div>
                    </div>
                  </article>
                </div>
              </div>
            </div>
          </div>
        </section>


        <section class="our-courses" id="courses">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <h2>Langages qui peut utiliser:</h2>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="owl-courses-item owl-carousel">
                  <div class="item">
                    <img src="assets/images/course-01.png" alt="Course One">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">

                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-02.png" alt="Course Two">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">

                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-03.jpg" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">

                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-04.png" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">

                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-05.jpg" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">
                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-06.png" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">

                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-07.png" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">

                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-08.png" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">

                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-09.jpg" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-8">


                          </div>
                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-10.webp" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">


                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-11.webp" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">


                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/images/course-12.jpg" alt="">
                    <div class="down-content">
                      <h4>exemple des langages</h4>
                      <div class="info">
                        <div class="row">


                          <div class="col-4">
                            <span>stage</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <?php
        require_once "connexiondb.php";

        // Récupérer le nombre de stagiaires
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total_stagiaires FROM stagiaire");
        $stmt->execute();
        $total_stagiaires = $stmt->fetch(PDO::FETCH_ASSOC)['total_stagiaires'];

        // Récupérer le nombre d'encadreurs
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total_encadreurs FROM encadreurs");
        $stmt->execute();
        $total_encadreurs = $stmt->fetch(PDO::FETCH_ASSOC)['total_encadreurs'];
        ?><?php
          require_once "connexiondb.php";

          // Récupérer le nombre total d'utilisateurs
          $stmt = $pdo->prepare("SELECT COUNT(*) AS total_utilisateurs FROM utilisateur");
          $stmt->execute();
          $total_utilisateurs = $stmt->fetch(PDO::FETCH_ASSOC)['total_utilisateurs'];
          ?>


        <section class="our-facts">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>pourcentage</h2>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-12">
                        <div class="count-area-content percentage">
                          <div class="count-digit">94</div>
                          <div class="count-title">conprehension</div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="count-area-content">
                          <div class="count-digit"><?php echo $total_utilisateurs; ?> </div>
                          <div class="count-title">les comptes utilisateurs</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-12">
                        <div class="count-area-content new-students">
                          <div class="count-digit"><?php echo $total_stagiaires; ?></div>
                          <div class="count-title"> les stagaire</div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="count-area-content">
                          <div class="count-digit"><?php echo $total_encadreurs; ?></div>
                          <div class="count-title">encadreurs</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 align-self-center">
                <div class="video">
                  <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank"><img src="assets/images/play-icon.png" alt=""></a>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="contact-us" id="contact">
          <div class="container">
            <div class="row">
              <div class="col-lg-9 align-self-center">
                <div class="row">
                  <div class="col-lg-12">

                  </div>
                </div>
              </div>

            </div>
          </div>

        </section>

        <div class="message-bubble">
          <a href="../pages/messaging/dist/page_messages.php?idUser=<?= $_SESSION['user']['iduser'] ?>" class="message-icon" style="color: #fff;"><i class="fa fa-envelope"></i></a>



        </div>

        <style>
          .message-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #a12c2f;
            color: #fff;
            width: 90px;
            /* Largeur et hauteur égales pour former un cercle */
            height: 90px;
            border-radius: 50%;
            /* Forme de cercle */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
            cursor: pointer;
          }

          .message-bubble:hover {
            background-color: #a12c2f;
          }


          .message-icon {
            margin-right: 0;
            /* Ajustez la marge pour centrer l'icône */
            font-size: 24px;
            /* Taille de l'icône */
          }

          .message-text {
            font-weight: bold;
            display: none;
            /* Masquez le texte pour le moment */
          }

          .message-bubble:hover .message-text {
            display: inline-block;
            /* Affichez le texte au survol */
          }
        </style>
        <!-- Scripts -->
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="assets/js/isotope.min.js"></script>
        <script src="assets/js/owl-carousel.js"></script>
        <script src="assets/js/lightbox.js"></script>
        <script src="assets/js/tabs.js"></script>
        <script src="assets/js/video.js"></script>
        <script src="assets/js/slick-slider.js"></script>
        <script src="assets/js/custom.js"></script>

</body>

</body>

</html>