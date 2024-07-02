<!--code nouveau stagiaire-->
<?php
require_once('connexiondb.php');
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
$requeteF = "select * from filiere";
$resultatF = $pdo->query($requeteF);
?>
<!--debut de html-->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un stagiaire</title>
    <link rel="stylesheet" href="../pages/assets/css/nouveaustagiaire.css">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>

<body>
    <div class="modal-background" id="hadil">
        <div class="modal-content" style="width: 600px;">
            <a><button class="close" onclick="closeModal()">&times;</button></a>
            <h2>un nouvelle stagiaire</h2>
            <form method="post" action="insertStagiaire.php?idUser=<?php echo $sender; ?>" class="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="email" style="color: gray;">Nom</label>
                    <input type="text" class="form-control" name="nom" placeholder="Nom" required />
                    <label class="email" style="color: gray;">Prenom</label>
                    <input type="text" class="form-control" name="prenom" placeholder="Prénom" required />
                    <label for="idFiliere" class="email" style="color: gray;">Filière:</label>
                    <select class="form-control" name="idFiliere" id="idFiliere">
                        <?php while ($filiere = $resultatF->fetch()) { ?>
                            <option value="<?php echo $filiere['idFiliere'] ?>">
                                <?php echo $filiere['nomFiliere'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <label for="photo" style="color: gray;">Photo :</label>
                    <input type="file" class="form-control" name="photo" style="margin-top: 20px; color: gray;" />
                    <div class="civility-section">
                        <label class="email" for="civilite" style="color: gray;">Civilité :</label>
                        <label style="color: gray;">
                            <input type="radio" name="civilite" value="F" checked /> F
                        </label>
                        <label style="color: gray;">
                            <input type="radio" name="civilite" value="M" /> M
                        </label>
                    </div>
                    <input type="text" class="form-control" name="carte_identite" placeholder="Carte d'identité" required /><br />
                    <input type="email" class="form-control" name="email" placeholder="email" required /><br />
                    <div class="modal-buttons">
                        <button class="modal-confirm1">
                            <span>Enregistrer</span>
                        </button>
                        <button class="modal-close" onclick="closeModal()">
                            <span>Annuler</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>