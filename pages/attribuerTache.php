<?php
// Assurez-vous de récupérer l'ID de la tâche depuis l'URL ou toute autre source sécurisée
$taskId = isset($_POST['taskId']) ? intval($_POST['taskId']) : null;
$sender = isset($_GET['sender']) ? $_GET['sender'] : null;
// Assurez-vous de récupérer l'ID de l'utilisateur depuis l'URL ou toute autre source sécurisée
$idUser = isset($_GET['idUser']) ? intval($_GET['idUser']) : null;

// Connexion à la base de données (exemple avec PDO)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les tâches de l'utilisateur avec l'ID approprié
    $query = $pdo->prepare("SELECT * FROM taches WHERE id_utilisateur = ?");
    $query->execute([$idUser]);
    $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une tâche</title>

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
    <script src="../pages/assets/js/attribuertache.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="../pages/assets/css/updateutilisateur.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">

    <!-- font awesome (https://fontawesome.com) for basic icons; source: https://cdnjs.com/libraries/font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />

    <link rel="shortcut icon" type="image/png" href="assets/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../pages/assets/css/attribuertache.css">
    <!-- Inclusion de jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Script JavaScript pour ouvrir la modal -->
    <script src="scripts/modal.js"></script>

</head>
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

<body>
    </head>

    <body>

        <div class="task-list" style="margin-left: 1400px;">


            <button type="submit" name="add_task" class="btn btn-primary" style="width: 200px;background-color:#333" onclick="tache()">Ajouter une tâche</button>
            <div id="tachess"></div>


            <span id="datetime"></span>
            <script src="../pages/assets/js/time.js"></script>
        </div>
        <!-- Affichage des tâches -->
        <div class="modal-background" id="taches">


            <form action="ajouter_tache.php?idUser=<?php echo $idUser; ?>&sender=<?php echo $sender; ?>" method="POST" enctype="multipart/form-data">

                <a class="close" onclick="close2()">&times;</a>
                <h4 style="margin-left: 70px;"><strong>tâches effectuées</strong> </h4>
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>

                <label for="date_limite">Date limite :</label>
                <input type="date" id="date_limite" name="date_limite">

                <!-- État -->
                <label for="etat">État :</label>
                <select id="etat" name="etat">
                    <option value="A_faire">À faire</option>
                    <option value="En_cours">En cours</option>
                    <option value="Terminee">Terminée</option>
                </select>
                <button type="submit" style="background-color: #3f4448;margin-top:20px;width:200px;margin-left:60px">Ajouter la tâche</button>
            </form>
        </div>



        <div class="task-list">
            <h2 style="text-align: center;"><strong>Tâches ajoutées</strong></h2>
            <?php if (empty($tasks)) : ?>
                <div class="loading">
                    <img src="../images/ZKZg.gif" alt="Loading" width="50px" class="rotation">
                    <p>Chargement en cours...</p>
                </div>
            <?php else : ?>
                <div id="tasks-container">
                    <?php foreach ($tasks as $task) : ?>
                        <div class="card <?php echo ($task['etat'] === 'Terminee') ? 'completed-task' : ''; ?>">
                            <div class="card-body">
                                <input type="checkbox" class="task-checkbox" <?php echo ($task['etat'] === 'Terminee') ? 'checked' : ''; ?>>
                                <h5 class="card-title"><?php echo $task['titre']; ?></h5>
                                <p class="card-text">Travail à faire: <?php echo $task['description']; ?></p>
                                <p class="card-text">Date limite: <?php echo $task['date_limite']; ?></p>
                                <p class="card-text">État: <?php echo $task['etat']; ?></p><br>
                                <form action="supprimer_tache.php?idUser=<?php echo $idUser; ?>&sender=<?php echo $sender; ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" class="icon-btn delete-btn" style="background-color: red;width: 50px;height: 35px;">
                                        <i class="fas fa-trash-alt" style="text-align: center;"></i> <!-- Font Awesome trash icon -->
                                    </button>
                                </form>










                                <button type="button" onclick="ouvrirModalModifier(<?php echo $task['id']; ?>)" class="icon-btn edit-btn" style="background-color:#3f4448;width: 50px;height: 35px;"><i class="fas fa-edit"></i></button>

                                <!-- Modal de modification -->
                                <div class="modal-background" id="modifierModal_<?php echo $task['id']; ?>">

                                    <form>
                                        <a class="close" onclick="closeModal(<?php echo $task['id']; ?>)">&times;</a>

                                        <h1>Modifier les taches</h1>
                                        <!-- Champs de modification de la tâche -->
                                        <input type="text" id="titre_<?php echo $task['id']; ?>" value="<?php echo $task['titre']; ?>">
                                        <textarea id="description_<?php echo $task['id']; ?>" style="margin-left:10px"><?php echo $task['description']; ?></textarea>
                                        <input type="date" id="date_limite_<?php echo $task['id']; ?>" value="<?php echo $task['date_limite']; ?>">
                                        <select id="etat_<?php echo $task['id']; ?>" style="margin-left:10px">
                                            <option value="A_faire" <?php if ($task['etat'] == 'A_faire') echo 'selected'; ?>>À faire</option>
                                            <option value="En_cours" <?php if ($task['etat'] == 'En_cours') echo 'selected'; ?>>En cours</option>
                                            <option value="Terminee" <?php if ($task['etat'] == 'Terminee') echo 'selected'; ?>>Terminée</option>
                                        </select><br><br>
                                        <!-- Bouton de modification -->
                                        <button type="button" style="margin-left:100px;width: 150px;background-color:#333" onclick="modifierTache(<?php echo $task['id']; ?>)">Modifier la tâche</button>
                                    </form>
                                </div>






                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>


    </body>

</html>