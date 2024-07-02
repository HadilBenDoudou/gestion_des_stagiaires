<?php
// Vérifiez d'abord si l'utilisateur est connecté et récupérez son ID d'utilisateur depuis une session ou toute autre source sécurisée.
session_start(); // Démarrez la session si ce n'est pas déjà fait
if (!isset($_SESSION['user'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit; // Arrêtez l'exécution du script après la redirection
}

// Récupérez l'ID de l'utilisateur connecté
$idUser = $_SESSION['user']['iduser'];

// Connexion à la base de données (exemple avec PDO)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les tâches de l'utilisateur connecté
    $query = $pdo->prepare("SELECT * FROM taches WHERE id_utilisateur = ?");
    $query->execute([$idUser]);
    $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$taskColors = ['#336d57', '#708090', '#778899', '#D3D3D3', '#A9A9A9', '#808080','#708090','	#DCDCDC','#90806F','#c7d3d9','#bcd5e3','#d1d0cf','#']; // Liste de couleurs

// Utilisation de la fonction array_rand pour sélectionner une couleur aléatoire pour chaque tâche
$tasksWithColors = array_map(function($task) use ($taskColors) {
    $task['color'] = $taskColors[array_rand($taskColors)]; // Sélectionne une couleur aléatoire pour chaque tâche
    return $task;
}, $tasks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <title>Editer filiere</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="../pages/assets/css/tache.css">
    <script src="../pages/assets/js/tache.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-gIMoIQ8wy+TSV7cGqFpF+OS4vVfN4D2Qki0q0oe3gA56cjruTFLzUt9V0SfNzgseW6x0MR2A5FTsLQ05+gM0Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="JS copy/main.js" type="text/javascript"> </script>
    
  
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <style>
    body {
    /* Définir la hauteur du corps sur 100% de la hauteur de la fenêtre du navigateur */
      background-image: url("./assets/images/meetings-bg.jpg");
      /* Centrez l'image horizontalement et verticalement */
  }</style>
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
                            <li><a href="../pages/filieres.php#categorySelect">Les Filières</a></li>
                           
                            <li><a href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>"><i class="fa fa-user-circle-o"></i> <?php echo ' ' . $_SESSION['user']['login']?></a></li>
                            <li>
                                <a href="tache.php">
                                    <i class="scroll-to-section"></i>
                                    les taches
                                </a>
                            </li>
                            <li><a href="seDeconnecter.php"><i class="fa fa-sign-out-alt"></i> Déconnecter</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>


<!-- Section pour afficher les tâches -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="margin-top: 200px;">
            <div id = "header">
            <div class="flexrow-container">
            <div class="standard-theme theme-selector"></div>
            <div class="light-theme theme-selector"></div>
            <div class="darker-theme theme-selector"></div>
        </div>
        <h1 id="title" style="color: white;">les taches effectuées<div id="border"></div></h1><br>
    </div>
                
                <?php if (!empty($tasks)): ?>
                    <div class="row">
                        
                        <?php foreach ($tasksWithColors as $task): ?>
                            <div class="col-md-4 mb-4">
                            <div class="card task-card" style="background-color: <?php echo $task['color']; ?>">
                                    <div class="card-body">
                                        <!-- Placer l'image ici -->
                                        <img src="../images/889668.png" style="width: 30px; float: right; margin-left: 10px;">
                                        <h5 class="card-title"><?php echo $task['titre']; ?></h5>
                                        <p class="card-text"><?php echo $task['description']; ?></p>

                                        <p class="card-text"> date limite est <?php echo $task['date_limite']; ?></p>
                                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="task_completed" value="1" id="task_<?php echo $task['id']; ?>">
                        <label class="form-check-label" for="task_<?php echo $task['id']; ?>">
                            Tâche accomplie
                        </label>
                    </div>
                                        <?php if (isset($task['pinned']) && $task['pinned']): ?>
                                            <i class="fas fa-thumbtack"></i> <!-- Icône d'épinglage -->
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; ?>
                    </div>
                    <p style="width: 70px;height:70px;margin-left:590px;margin-top:500px"></p>
                <?php else: ?>
                 
      
                    <img src="../images/ZKZg.gif" style="width: 70px;height:70px;margin-left:590px;margin-top:50px">
                    <p style="width: 70px;height:70px;margin-left:590px;margin-top:500px"></p>
                    
                <?php endif; ?>
           
        </div>
    </div>
</section>





<!-- Scripts JS et fermeture du corps et de l'élément HTML -->
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Additional Scripts -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/owl.js"></script>
<script src="assets/js/lightbox.js"></script>
<script src="assets/js/isotope.js"></script>

</body>
</html>
