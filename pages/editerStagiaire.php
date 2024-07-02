<?php
require_once 'connexiondb.php';
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;

$idS = isset($_GET['idS']) ? $_GET['idS'] : 0;
$requeteS = "SELECT * FROM stagiaire WHERE idStagiaire=$idS";
$resultatS = $pdo->query($requeteS);
$stagiaire = $resultatS->fetch();
$nom = $stagiaire['nom'];
$prenom = $stagiaire['prenom'];
$civilite = strtoupper($stagiaire['civilite']);
$idFiliere = $stagiaire['idFiliere'];
$nomPhoto = $stagiaire['photo'];
$carte_identite = $stagiaire['carte_identite'];
$email = $stagiaire['email'];
$requeteF = "SELECT * FROM filiere";
$resultatF = $pdo->query($requeteF);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Édition d'un stagiaire</title>
    <link rel="stylesheet" type="text/css" href="../pages/assets/css/editerstagiair.css">
</head>

<body>
    <div class="modal-background" id="hadil1">
        <div class="modal-content" style="width: 600px;">
            <a><button class="close" onclick="closeModal1()">&times;</button></a>
            <form method="post" action="updateStagiaire.php?idUser=<?php echo $sender; ?>" class="form" style="margin-top: 5px;" enctype="multipart/form-data">

                <h2 style="color: #414141;margin-top:5px">Édition du stagiaire</h2>
                <label for="idS" style="color: #414141;">ID du stagiaire: <?php echo $idS ?></label>
                <input type="hidden" name="idS" class="form-control" value="<?php echo $idS ?>" />
                <div class="form-group">
                    <label for="nom" style="color: #414141;">Nom</label>
                    <input type="text" name="nom" placeholder="Nom" class="form-control" value="<?php echo $nom ?>" />
                </div>
                <div class="form-group">
                    <label for="prenom" style="color: #414141;">Prénom</label>
                    <input type="text" name="prenom" placeholder="Prénom" class="form-control" value="<?php echo $prenom ?>" />
                </div>
                <div class="form-group">
                    <label for="idFiliere" style="color: #414141;">Filière</label>
                    <select name="idFiliere" class="form-control" id="idFiliere">
                        <?php while ($filiere = $resultatF->fetch()) { ?>
                            <option value="<?php echo $filiere['idFiliere'] ?>" <?php if ($idFiliere === $filiere['idFiliere']) echo "selected" ?>>
                                <?php echo $filiere['nomFiliere'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="photo" style="color: #414141;">Photo</label>
                    <input type="file" name="photo" class="form-control-file" />
                </div>
                <div class="form-group">
                    <label style="color: #414141;">Civilité</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="civilite" id="femme" value="F" <?php if ($civilite === "F") echo "checked" ?>>
                            <label class="form-check-label" for="femme">F</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="civilite" id="homme" value="M" <?php if ($civilite === "M") echo "checked" ?>>
                            <label class="form-check-label" for="homme">M</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="carte_identite" style="color: #414141;">Carte d'identité</label>
                    <input type="text" name="carte_identite" placeholder="Carte d'identité" class="form-control" value="<?php echo $carte_identite ?>" />
                </div>
                <div class="form-group">
                    <label for="email" style="color: #414141;">email</label>
                    <input type="email" name="email" placeholder="email" class="form-control" value="<?php echo $email ?>" />
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: #414141;">
                    <span class="glyphicon glyphicon-save"></span> Enregistrer
                </button>
                <div class="register_link"></div>
            </form>
        </div>
    </div>
</body>

</html>