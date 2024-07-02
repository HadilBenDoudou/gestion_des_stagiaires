<?php
// Paramètres de connexion à la base de données (à remplir avec vos propres informations)
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données
$sender = isset($_GET['sender']) ? $_GET['sender'] : null;


// Connexion à la base de données avec PDO
$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
// Définition du mode d'erreur PDO sur Exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification de la présence de l'ID de l'utilisateur dans l'URL
if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];
    $sender = $_GET['idUser'];

    // Vérification si l'ID de l'utilisateur est valide
    if ($idUser) {
        // Préparation de la requête SQL
        $sql = "SELECT iduser, login, email FROM utilisateur WHERE iduser = :idUser";
        $stmt = $pdo->prepare($sql);
        // Liaison du paramètre :idUser avec la valeur de $idUser
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        // Exécution de la requête SQL
        $stmt->execute();

        // Vérification s'il y a des résultats
        if ($stmt->rowCount() > 0) {
            // Récupération des données
            $row = $stmt->fetch();
            $id = $row["iduser"];
            $login = $row["login"];
            $email = $row["email"];
        }
    }
}
// Affichage du formulaire avec les valeurs récupérées de la base de données
?>

<?php



require_once("connexiondb.php");

$nomPrenom = isset($_GET['nomPrenom']) ? $_GET['nomPrenom'] : "";
$idfiliere = isset($_GET['idfiliere']) ? $_GET['idfiliere'] : 0;

$requeteFiliere = "select * from filiere";

if ($idfiliere == 0) {
    $requeteStagiaire = "SELECT s.idStagiaire, s.nom, s.prenom, f.nomFiliere, s.photo, s.civilite, s.carte_identite,s.email
        FROM stagiaire AS s
        INNER JOIN filiere AS f ON s.idFiliere = f.idFiliere
        WHERE (s.nom LIKE '%$nomPrenom%' OR s.prenom LIKE '%$nomPrenom%')";
    $requeteCount = "select count(*) countS from stagiaire
                where nom like '%$nomPrenom%' or prenom like '%$nomPrenom%'";
} else {
    $requeteStagiaire = "select idStagiaire,nom,prenom,nomFiliere,photo,civilite 
                from filiere as f,stagiaire as s
                where f.idFiliere=s.idFiliere
                and (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and f.idFiliere=$idfiliere
                 order by idStagiaire
                ";
    $requeteCount = "select count(*) countS from stagiaire
                where (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and idFiliere=$idfiliere";
}

$resultatFiliere = $pdo->query($requeteFiliere);
$resultatStagiaire = $pdo->query($requeteStagiaire);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>partie administrateur</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/all-rapport-stagiaire.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="../pages/assets/css/admin.css" rel="stylesheet">
    <script src="../pages/assets/js/admin.js"></script>

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
                    <li><a href="#" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>bienvenus</span></a></li>

                    <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Filiere</span></a></li>
                    <li><a href="#encadreurs" class="nav-link scrollto"><i class="bx bx-user"></i> <span>encadreurs</span></a></li>
                    <li><a href="#facts" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Stagiaire</span></a></li>
                    <li><a href="#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>document imprimer</span></a></li>
                    <li><a href="#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Utilisateurs</span></a></li>
                    <li><a href="#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Compte</span></a></li>

                    <li><a href="../pages/messaging/dist/index.php?idUser=<?php echo $idUser ?>&sender=<?php echo $sender ?>" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>message</span></a></li>

                    <li><a href="seDeconnecter.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Deconnexion</span></a></li>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->
    <!-- ======= Hero Section ======= -->
    <section id="hero1" class="d-flex flex-column justify-content-center align-items-center">
        <div class="hero-container" data-aos="fade-in">
            <h1>WeDo Consult</h1>
            <p>entreprise <span class="typed" data-typed-items="de, Developpement,programmation , bienvenus"></span></p>
        </div>
    </section><!-- End Hero -->
    <main id="main">
        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">
                <div class="section-title" style="padding-top:0px;">
                    <h2>Filiere</h2>
                </div>
                <h2>Liste des Filières</h2>
                <button type="button" style=" position: absolute; right: 20px; color: white; background-color:#149ddd; height:40px" class="btn btn-success" onclick="openModal()">Ajouter une nouvelle filière</button>
                <div id="modalContainer5"></div>
                <script>
                    function openModal() {
                        // Charger le contenu de la boîte modale depuis un fichier séparé (modalContent.php)
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // Insérer le contenu de la boîte modale dans le conteneur
                                document.getElementById("modalContainer5").innerHTML = this.responseText;

                                // Afficher la boîte modale
                                document.getElementById("hadil5").style.display = "block";
                            }
                        };
                        xhttp.open("GET", "insertFiliere.php?idUser=<?php echo $sender; ?>", true);

                        xhttp.send();
                    }
                </script>
                <!-- Script pour charger et afficher la boîte de dialogue modale -->
                <!-- Champ de recherche -->
                <input type="text" id="searchInput" onkeyup="searchFiliere()" placeholder="Recherche par nom de filière" style="width: 890px;">
                <table id="filiereTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Filière</th>
                            <th>Niveau</th>
                            <th>Action</th> <!-- Nouvelle colonne pour les actions -->
                        </tr>
                    </thead>
                    <tbody>
                        <!--php pour sectionner filiere-->
                        <?php
                        // Connexion à la base de données avec PDO
                        try {
                            $host = "localhost";
                            $dbname = "gestion_stag";
                            $username = "root";
                            $password = "";
                            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            // Requête SQL pour récupérer les données de la table "filiere"
                            $requete = "SELECT idFiliere, nomFiliere, niveau FROM filiere";
                            $resultat = $pdo->query($requete);
                            // Vérification s'il y a des données
                            if ($resultat->rowCount() > 0) {
                                // Affichage des données dans le tableau
                                foreach ($resultat as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $row["idFiliere"]; ?></td>
                                        <td><?php echo $row["nomFiliere"]; ?></td>
                                        <td><?php echo $row["niveau"]; ?></td>
                                        <td>
                                            <button onclick="openModal6(<?php echo $row['idFiliere']; ?>, '<?php echo $sender; ?>')">Modifier</button>
                                            <script>
                                                function openModal6(idFiliere) {
                                                    var xhttp = new XMLHttpRequest();
                                                    xhttp.onreadystatechange = function() {
                                                        if (this.readyState == 4 && this.status == 200) {
                                                            document.getElementById("modalContainer6").innerHTML = this.responseText;
                                                            document.getElementById("hadil6").style.display = "block";
                                                        }
                                                    };
                                                    xhttp.open("GET", "editf.php?id=" + idFiliere + '&idUser=<?php echo $sender; ?>', true);
                                                    xhttp.send();
                                                }
                                            </script>

                                            <div id="modalContainer6"></div>
                                            <a href="indexx.php?idUser=<?php echo $sender; ?>#about" style="color:#000000" class="glyphicon glyphicon-trash" onclick="confirmDelete(<?php echo $row['idFiliere']; ?>)">Supprimer</a>

                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>Aucune filière trouvée</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Échec de la connexion : " . $e->getMessage();
                        }

                        // Fermeture de la connexion à la base de données
                        $pdo = null;
                        ?>
                    </tbody>
                </table>

                <!-- Modal pour la confirmation de suppression -->
                <div id="myModal" class="modal">
                    <div class="modal-content" style="width: 600px;">
                        <p>Êtes-vous sûr de vouloir supprimer cette filière ?</p>
                        <button id="confirmYes" style="width: 100px;">Oui</button>
                        <button id="confirmNo" style="width: 100px;">Non</button>
                    </div>
                </div>
            </div>
            <script>
                function confirmDelete(id) {
                    var modal = document.getElementById('myModal');
                    modal.style.display = "block";

                    var confirmYesBtn = document.getElementById('confirmYes');
                    var confirmNoBtn = document.getElementById('confirmNo');

                    // Empêcher le comportement par défaut du lien
                    event.preventDefault();

                    // Si l'utilisateur clique sur Oui, supprimer la filière
                    confirmYesBtn.onclick = function() {
                        modal.style.display = "none";
                        deleteFiliere(id);
                    }

                    // Si l'utilisateur clique sur Non, fermer la boîte de dialogue modale
                    confirmNoBtn.onclick = function() {
                        modal.style.display = "none";
                    }
                }


                // Fonction pour supprimer la filière via AJAX
                function deleteFiliere(id) {
                    // Faire une requête AJAX pour supprimer la filière avec l'ID spécifié
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            // Actualiser la page ou effectuer toute autre action nécessaire après la suppression
                            window.location.reload(); // Actualise la page après suppression
                        }
                    };
                    xhttp.open("GET", "supf.php?id=" + id + '&idUser=<?php echo $sender; ?>', true);
                    xhttp.send();
                }
            </script>
        </section><!-- End About Section -->






        <!-- Section pour afficher la liste des encadreurs -->
        <section id="encadreurs" class="encadreurs">
            <div class="container">
                <div class="section-title" style="padding-top:0px;">
                    <h2>Encadreurs</h2>
                </div>
                <!-- Ajoutez un champ de recherche -->
                <div style="display: flex; align-items: center;">
                    <input class="form-control" type="text" id="search2" name="search2" onkeyup="searchSupervisors()" placeholder="Entrez votre recherche ici..." style="margin-bottom: 20px; width: 50%; height: 44px; margin-right: 10px;">
                    <button id="addSupervisorBtn" style="height: 44px;">Ajouter un encadreur</button>
                </div>

                <script>
                    function searchSupervisors() {
                        var input = document.getElementById("search2").value.toUpperCase();
                        var table = document.getElementById("supervisorsTable");
                        var rows = table.getElementsByTagName("tr");

                        // Commencer à l'index 1 pour exclure la première ligne (en-tête de colonne)
                        for (var i = 1; i < rows.length; i++) {
                            var cells = rows[i].getElementsByTagName("td");
                            var found = false;
                            // Parcourir les cellules de chaque ligne pour voir si elles contiennent la recherche
                            for (var j = 0; j < cells.length; j++) {
                                var cellText = cells[j].textContent.toUpperCase();
                                if (cellText.indexOf(input) > -1) {
                                    found = true;
                                    break;
                                }
                            }
                            if (found) {
                                rows[i].style.display = "";
                            } else {
                                rows[i].style.display = "none";
                            }
                        }
                    }
                </script>


                <!-- Tableau pour afficher la liste des encadreurs -->
                <table id="supervisorsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>CV</th>
                            <th>Numéro de téléphone</th>
                            <th>Action</th>
                            <!-- Ajoutez plus de colonnes si nécessaire -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données

                        try {
                            // Connexion à la base de données avec PDO
                            $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                            // Définition du mode d'erreur PDO sur Exception
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                            exit(); // Quitter le script en cas d'échec de la connexion à la base de données
                        }
                        // Requête pour récupérer les encadreurs depuis la base de données
                        $query_supervisors = "SELECT * FROM encadreurs";
                        $result_supervisors = $pdo->query($query_supervisors);

                        // Vérification s'il y a des encadreurs
                        if ($result_supervisors->rowCount() > 0) {
                            // Parcourir chaque encadreur et les afficher dans une ligne du tableau
                            foreach ($result_supervisors as $supervisor) {
                                echo "<tr>";
                                echo "<td>" . $supervisor['id'] . "</td>";
                                echo "<td>" . $supervisor['nom'] . "</td>";
                                echo "<td>" . $supervisor['prenom'] . "</td>";
                                echo "<td><a href='" . $supervisor['cv_path'] . "' target='_blank'>Télécharger CV</a></td>";
                                echo "<td>" . $supervisor['numero_telephone'] . "</td>";
                                echo "<td>";
                                // Icône de modification
                                echo "<button onclick='openModal(" . $supervisor['id'] . ")'><i class='fa fa-edit'></i></button>";


                                echo "<span style='margin: 0 5px;'></span>"; // Ajout de la marge entre les icônes
                                // Icône de suppression avec une confirmation
                                echo "<a href='supprimer_encadreur.php?id=" . $supervisor['id'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet encadreur ?\")'><i class='fa fa-trash'></i></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Si aucun encadreur trouvé, afficher un message dans une seule ligne
                            echo "<tr><td colspan='3'>Aucun encadreur trouvé</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Modal pour afficher le formulaire de modification -->

                <div id="myModalencadreur" class="modal">
                    <div class="modal-content">
                        <!-- Formulaire de modification d'encadreur -->

                        <form id="editForm" action="modifier_encadreur.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="encadreurId">
                            <div>
                                <label for="nom">Nom:</label>
                                <input type="text" id="nom" name="nom" required>
                            </div>
                            <div>
                                <label for="prenom">Prénom:</label>
                                <input type="text" id="prenom" name="prenom" required>
                            </div>
                            <div>
                                <label for="numero_telephone">Numéro de téléphone:</label>
                                <input type="text" id="numero_telephone" name="numero_telephone" required>
                            </div>
                            <div>
                                <label for="cv_path">Chemin du CV:</label>
                                <input type="file" id="cv_path" name="cv_path" accept=".pdf,.doc,.docx">
                            </div>
                            <button type="submit" name="submit">Enregistrer</button>
                        </form>
                        <button onclick="closeModalencadreur()" style="width: 115px;background-color:#333">Fermer</button>
                    </div>
                </div>
                <script>
                    // Fonction pour ouvrir le modal
                    function openModal(id) {
                        document.getElementById("myModalencadreur").style.display = "block";

                        // Charger le formulaire de modification via AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                document.getElementById("editForm").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.open("GET", "modifier_encadreur.php?id=" + id, true); // id est l'ID de l'encadreur à modifier
                        xhr.send();
                    }


                    // Fonction pour fermer le modal
                    function closeModalencadreur() {
                        document.getElementById("myModalencadreur").style.display = "none";
                    }
                </script>


                <style>
                    /* Style pour la modal */
                    .modal {
                        display: none;
                        position: fixed;
                        /* Positionnement fixe */
                        top: 50%;
                        /* Centre vertical */
                        left: 50%;
                        /* Centre horizontal */
                        transform: translate(-50%, -50%);
                        /* Centrage */
                        z-index: 9999;
                        /* Z-index élevé pour afficher au-dessus du contenu */
                    }

                    .modal-content {
                        background-color: #fefefe;
                        padding: 20px;
                        border: 1px solid #888;
                        border-radius: 5px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        max-width: 80%;
                        /* Largeur maximale */
                        max-height: 80%;
                        /* Hauteur maximale */
                        overflow: auto;
                        /* Activation du défilement si le contenu dépasse */
                    }

                    .close {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        cursor: pointer;
                        color: #888;
                        font-size: 20px;
                    }
                </style>
            </div>
        </section>
        <!-- Fin de la section pour afficher la liste des encadreurs -->

        <!-- Formulaire pour ajouter un nouvel encadreur -->
        <div id="addSupervisorModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 style="margin-left: 200px;color:#000000">Ajouter un encadreur</h2>
                <form id="addSupervisorForm" action="ajouter_encadreur.php" method="post" enctype="multipart/form-data">
                    <div>

                        <input type="text" id="nom" name="nom" placeholder="Nom" required style="margin-left:250px;">
                    </div>
                    <div>

                        <input type="text" id="prenom" name="prenom" placeholder="Prénom" required style="margin-left:250px;">
                    </div>
                    <div>

                        <input type="text" id="numero_telephone" name="numero_telephone" placeholder="Numéro de téléphone" style="margin-left:250px;" required>
                    </div>
                    <div>

                        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" placeholder="CV (PDF, DOC, DOCX)" style="margin-left:250px;" required>
                    </div>
                    <button type="submit" name="submit" onclick="return checkDuplicatePhoneNumber()">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Button to open the modal -->


        <!-- Script pour le modal -->
        <script>
            // Afficher ou cacher le modal
            var modal = document.getElementById("addSupervisorModal");
            var btn = document.getElementById("addSupervisorBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Validation du numéro de téléphone
            function checkDuplicatePhoneNumber() {
                var phoneNumber = document.getElementById('numero_telephone').value;
                // Faire une requête AJAX pour vérifier la duplication du numéro de téléphone
                // Assurez-vous que la requête renvoie true ou false en fonction de la duplication

                // Temporairement, une alerte est utilisée pour la démonstration
                if (phoneNumber === 'numéro déjà utilisé') {
                    alert("Le numéro de téléphone est déjà utilisé. Veuillez en saisir un nouveau.");
                    return false; // Bloque la soumission du formulaire
                }
                return true; // Autorise la soumission du formulaire si le numéro n'est pas dupliqué
            }
        </script>
        <!-- Fin de la section pour ajouter un nouvel encadreur -->
























        <!-- ======= Facts Section ======= -->
        <section id="facts" class="facts">
            <div class="container">
                <div class="section-title">
                    <h2>Stagiaire</h2>
                </div>
                <button type="button" style="position: absolute; right: 20px; color: white; background-color: #149ddd; height:40px" class="btn btn-success" onclick="openModal1()"> Nouveau Stagiaire</button>
                <div id="modalContainer1"></div>
                <!-- ======= faire recherche des stagiaire ======= -->


                <!-- Add this code inside your HTML file where you want the search box to appear -->
                <div class="form-group">
                    <input type="text" class="form-control" id="search" placeholder="Nom, prénom ou filière du stagiaire" style="margin-bottom:20px;width: 100%;height:44px;">
                </div>

                <script>
                    function openModal1() {
                        // Charger le contenu de la boîte modale depuis un fichier séparé (modalContent.php)
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // Insérer le contenu de la boîte modale dans le conteneur
                                document.getElementById("modalContainer1").innerHTML = this.responseText;

                                // Afficher la boîte modale
                                document.getElementById("hadil").style.display = "block";
                            }
                        };
                        xhttp.open("GET", "nouveauStagiaire.php?idUser=<?php echo $sender; ?>", true);

                        xhttp.send();

                    }
                    // JavaScript function to handle the search functionality
                    function searchInterns() {
                        // Declare variables
                        var input, filter, table, tr, td, i, j, txtValue;
                        input = document.getElementById("search");
                        filter = input.value.toUpperCase();
                        table = document.querySelector(".table");
                        tr = table.getElementsByTagName("tr");

                        // Loop through all table rows, and hide those who don't match the search query
                        for (i = 0; i < tr.length; i++) {
                            var found = false;
                            td = tr[i].getElementsByTagName("td");
                            for (j = 0; j < td.length; j++) {
                                var cell = td[j];
                                if (cell) {
                                    txtValue = cell.textContent || cell.innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        found = true;
                                        break;
                                    }
                                }
                            }
                            if (found) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }

                    // Attach an event listener to the input field to trigger the search function on input
                    document.getElementById("search").addEventListener("input", searchInterns);
                </script>


                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Civilité</th>
                                <th>Photo</th>
                                <th>Filière</th>
                                <th>Carte d'Identité</th>
                                <th>email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--afficher table de stagiaire-->
                            <?php

                            while ($stagiaire = $resultatStagiaire->fetch()) { ?>
                                <tr>
                                    <td><?php echo $stagiaire['nom'] ?></td>
                                    <td><?php echo $stagiaire['prenom'] ?></td>
                                    <td><?php echo $stagiaire['civilite'] ?></td>
                                    <td><img src="../images/<?php echo $stagiaire['photo'] ?>" alt="Photo du stagiaire" style="width: 100px;"></td>
                                    <td><?php echo $stagiaire['nomFiliere'] ?></td>
                                    <td><?php echo $stagiaire['carte_identite'] ?></td>
                                    <td><?php echo $stagiaire['email'] ?></td>
                                    <td>
                                        <button onclick="openModal2(<?php echo $stagiaire['idStagiaire']; ?>, '<?php echo $sender; ?>')">Modifier</button>
                                        <div id="modalContainer2"></div>
                                        <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer le stagiaire')" style="color:#000000" class="glyphicon glyphicon-trash" href="supprimerStagiaire.php?idS=<?php echo $stagiaire['idStagiaire'] ?>&idUser=<?php echo $sender; ?>">Supprimer</a>


                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- Fin de la classe container -->
        </section><!-- Fin de la section Facts -->
        <script>
            function openModal2(idStagiaire) {
                // Charger le contenu de la modal depuis un fichier séparé (editerStagiaire.php) en incluant l'ID du stagiaire
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Insérer le contenu de la modal dans le conteneur
                        document.getElementById("modalContainer2").innerHTML = this.responseText;

                        // Afficher la modal
                        document.getElementById("hadil1").style.display = "block";
                    }
                };
                xhttp.open("GET", "editerStagiaire.php?idS=" + idStagiaire + '&idUser=<?php echo $sender; ?>', true);

                xhttp.send();
            }
        </script>
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio section-bg">
            <div class="container">
                <div class="section-title">
                    <h2>document imprimer</h2>
                    <p>nos stagiaires, des jeunes talents avides d'apprendre et de contribuer à notre équipe avec leur fraîcheur, leur enthousiasme et leur passion pour leur domaine d'étude.</p>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-app">Rapport</li>
                            <li data-filter=".filter-stagiaire">Stagiaire</li>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">
                    <?php
                    // Connexion à la base de données
                    $host = "localhost";
                    $dbname = "gestion_stag";
                    $username = "root";
                    $password = "";

                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        // Configuration supplémentaire de PDO si nécessaire...
                    } catch (PDOException $e) {
                        echo "Erreur de connexion : " . $e->getMessage();
                        die();
                    }

                    // Exécution de la requête SQL pour récupérer les données des rapports des utilisateurs
                    $sql = "SELECT * FROM utilisateur WHERE rapport IS NOT NULL";
                    $stmt = $pdo->query($sql);

                    // Affichage des rapports des utilisateurs
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap">
                                <img src="../pages/assets/images/pdf.webp" class="img-fluid" alt="PDF" style="width: 450px;height: 300px;">
                                <div class="portfolio-info">
                                    <!-- Ajoutez d'autres informations si nécessaire -->
                                </div>
                                <div class="portfolio-links">
                                    <!-- Lien pour télécharger le rapport -->
                                    <a href="pdf/<?php echo $row['rapport']; ?>" title="Télécharger le rapport"><i class="bx bx-download"></i>
                                        <h4> Télécharger le rapport</h4>
                                    </a>
                                    <a href="pdf/<?php echo $row['rapport']; ?>" title="Télécharger le rapport">
                                        <h4><?php echo $row['email'] . '<br><br> ' . $row['login']; ?></h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <?php

                    // Exécution de la requête SQL pour récupérer les données des stagiaires
                    $sql = "SELECT * FROM stagiaire";
                    $stmt = $pdo->query($sql);

                    // Affichage des stagiaires
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="col-lg-4 col-md-6 portfolio-item filter-stagiaire">
                            <div class="portfolio-wrap">
                                <img src="../images/<?php echo $row['photo']; ?>" class="img-fluid" alt="Photo" style="width: 450px;height: 300px;">
                                <div class="portfolio-info">
                                    <h4><?php echo $row['prenom'] . ' ' . $row['nom']; ?></h4>
                                    <!-- Ajoutez d'autres informations si nécessaire -->
                                </div>
                                <div class="portfolio-links">
                                    <!-- Lien pour imprimer le stagiaire -->
                                    <a href="imprimerStagiaire.php?idS=<?php echo $row['idStagiaire']; ?>&idUser=<?php echo $sender; ?>" target="_blank" title="Imprimer"><i class="bx bx-print"> </i></a>
                                    <!-- Si vous souhaitez ajouter un texte "Imprimer", vous pouvez le faire de la manière suivante -->
                                    <a href="imprimerStagiaire.php?idS=<?php echo $row['idStagiaire']; ?>&idUser=<?php echo $sender; ?>" target="_blank" title="Imprimer"><i class="bx bx-print" style="padding: 0 5px;">Imprimer</i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <?php
            $host = "localhost";
            $dbname = "gestion_stag";
            $username = "root";
            $password = "";
            $id = isset($_GET['idUser']) ? $_GET['idUser'] : null;

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                // Autres configurations PDO...
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
                die();
            }
            $login = isset($_GET['login']) ? $_GET['login'] : "";

            $requeteUser = "select * from utilisateur where login like '%$login%'";
            $requeteCount = "select count(*) countUser from utilisateur";

            $resultatUser = $pdo->query($requeteUser);
            $resultatCount = $pdo->query($requeteCount);

            $tabCount = $resultatCount->fetch();
            $nbrUser = $tabCount['countUser'];

            ?>
            <div class="container">
                <div class="section-title">
                    <h2>Utilisateurs</h2>
                    <p>But : accepter les utilisateurs. En implémentant ces étapes, vous pouvez mettre en place un système robuste où les administrateurs ont le contrôle sur l'approbation des utilisateurs avant qu'ils puissent accéder à certaines fonctionnalités critiques sur votre site ou votre application.</p>
                </div>

                <div class="panel panel-success margetop60" style="border: #ddd;">
                    <div class="panel-heading" style="background-color: #f2f2f2;border:#f2f2f2;color:black">Rechercher des utilisateurs</div>
                    <div class="panel-body" style="background-color: #f2f2f2;border:#f2f2f2">
                        <form method="get" action="indexx.php#services" class="form-inline">


                            <div class="form-group d-flex align-items-end">
                                <input type="text" name="login" placeholder="Login" class="form-control" value="<?php echo $login ?>" style="width:1900px" />
                                <input type="hidden" name="idUser" value="<?php echo $id; ?>">

                                <button type="submit" class="btn btn-success ml-2" style="background-color:#149ddd">
                                    <span class="glyphicon glyphicon-search"></span>Chercher...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-primary" style="background-color: #f2f2f2;border:#f2f2f2">
                    <div class="panel-heading" style="background-color: #f2f2f2;border:#f2f2f2;color:#000000">Liste des utilisateurs (<?php echo $nbrUser ?> utilisateurs)</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>login</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--pour afficher les utilisateurs -->
                                <?php while ($user = $resultatUser->fetch()) { ?>
                                    <tr class="<?php echo $user['etat'] == 1 ? 'success' : 'danger' ?>">
                                        <td><?php echo $user['login'] ?> </td>
                                        <td><?php echo $user['email'] ?> </td>
                                        <td><?php echo $user['role'] ?> </td>
                                        <td>
                                            <a href="updateUtilisateur.php?idUser=<?php echo $user['iduser']; ?>&sender=<?php echo $sender; ?>">

                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            &nbsp;&nbsp;
                                            <a onclick="return confirm('Etes vous sur de vouloir supprimer cet utilisateur')" href="supprimerUtilisateur.php?idUser=<?php echo $user['iduser']; ?>&sender=<?php echo $sender; ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                            &nbsp;&nbsp;
                                            <?php if ($user['etat'] == 1 && $user['role'] != 'ADMIN') { ?>
                                                <a href="attribuerTache.php?idUser=<?php echo $user['iduser']; ?>&sender=<?php echo $sender; ?>">
                                                    <span class="glyphicon glyphicon-tasks"></span>
                                                </a>
                                                &nbsp;&nbsp;
                                            <?php } ?>
                                            <a href="activerUtilisateur.php?idUser=<?php echo $user['iduser'] ?>&etat=<?php echo $user['etat'] ?>&sender=<?php echo $sender; ?>">
                                                <?php
                                                if ($user['etat'] == 1)
                                                    echo '<span class="glyphicon glyphicon-remove"></span>';
                                                else
                                                    echo '<span class="glyphicon glyphicon-ok"></span>';
                                                ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?><!--fin de utilisateur tableau-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section><!-- End Services Section -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="section-title">
                    <h2>Compte</h2>
                </div>
                <div class="row" data-aos="fade-in">
                    <div class="col-lg-5 d-flex align-items-stretch">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Location:</h4>
                                <p>Bureau D2 Rue de la république, Grombalia, Tunisie, Grombalia, Nabeul</p>
                            </div>
                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p>contact@wedo-consult.com</p>
                            </div>
                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>telephone:</h4>
                                <p>+ 21672393679</p>
                            </div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12812.466069549577!2d10.5001737!3d36.5995027!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd5bbdc8325c13%3A0xc49ded07806f791d!2sWeDo%20Consult!5e0!3m2!1sfr!2stn!4v1706365685722!5m2!1sfr!2stn" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
                        </div>
                    </div>
                    <!--compte admin-->
                    <!--compte admin-->

                    <?php
                    // Paramètres de connexion à la base de données (à remplir avec vos propres informations)
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données

                    try {
                        // Connexion à la base de données avec PDO
                        $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                        // Définition du mode d'erreur PDO sur Exception
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Vérification de la présence de l'ID de l'utilisateur dans l'URL
                        if (isset($_GET['idUser'])) {
                            $idUser = $_GET['idUser'];

                            // Vérification si l'ID de l'utilisateur est valide
                            if ($idUser) {
                                // Préparation de la requête SQL
                                $sql = "SELECT iduser, login, email FROM utilisateur WHERE iduser = :idUser";
                                $stmt = $pdo->prepare($sql);
                                // Liaison du paramètre :idUser avec la valeur de $idUser
                                $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                                // Exécution de la requête SQL
                                $stmt->execute();

                                // Vérification s'il y a des résultats
                                if ($stmt->rowCount() > 0) {
                                    // Récupération des données
                                    $row = $stmt->fetch();
                                    $id = $row["iduser"];
                                    $login = $row["login"];
                                    $email = $row["email"];
                                    // Affichage du formulaire avec les valeurs récupérées de la base de données
                    ?>
                                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" style="background-color: white;">
                                        <form action="updateUtilisateur3.php" method="post" role="form" style="padding-top: 100px;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                    <label for="name">Login</label>
                                                    <input type="text" id="login" name="login" value="<?php echo $login; ?>" required><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <div class="input_box">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>
                                                </div>
                                            </div>
                                            <div class="text-center"><button type="submit" class="btn btn-primary" style="background-color: #149ddd;">Enregistrer</button></div>
                                            <a href="changer_mot_de_passe.php?id=<?php echo $id; ?>">Modifier le mot de passe</a>

                                        </form>
                                    </div>
                    <?php
                                } else {
                                    echo "Aucun utilisateur trouvé avec cet ID";
                                }
                            } else {
                                echo "ID de l'utilisateur non spécifié dans l'URL";
                            }
                        } else {
                            echo "ID de l'utilisateur non spécifié dans l'URL";
                        }
                    } catch (PDOException $e) {
                        // Gestion des erreurs de connexion
                        echo "Erreur de connexion : " . $e->getMessage();
                    }




                    // Fermeture de la connexion à la base de données
                    $pdo = null;
                    ?>

                </div>
            </div>
            </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/typed.js/typed.umd.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>