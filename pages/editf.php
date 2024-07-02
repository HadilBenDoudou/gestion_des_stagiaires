<?php
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        $host = "localhost";
        $dbname = "gestion_stag";
        $username = "root";
        $password = "";

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = "SELECT idFiliere, nomFiliere, niveau FROM filiere WHERE idFiliere = ?";
        $statement = $pdo->prepare($requete);

        $statement->execute([$_GET['id']]);

        $filiere = $statement->fetch(PDO::FETCH_ASSOC);
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Édition d'une filière</title>
            <link rel="stylesheet" type="text/css" href="../pages/assets/css/editf.css">
            <!-- Favicons -->
            <link href="assets/img/favicon.png" rel="icon">
            <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
        </head>

        <body>
            <div id="hadil6" class="modal">
                <div class="modal-content" style="width: 600px;">
                    <a class="close" onclick="closeModal6()">&times;</a>
                    <h2>Édition d'une filière</h2>
                    <form action="editf2.php?idUser=<?php echo $sender; ?>" method="post">
                        <input class="email" type="hidden" name="idFiliere" value="<?php echo $filiere['idFiliere']; ?>">
                        <input class="email" type="text" id="nomFiliere" name="nomFiliere" value="<?php echo $filiere['nomFiliere']; ?>"><br>
                        <input class="email" type="text" id="niveau" name="niveau" value="<?php echo $filiere['niveau']; ?>"><br><br>
                        <div class="form-group">
                            <div class="modal-buttons">
                                <button class="modal-confirm3">
                                    <span>Enregistrer</span>
                                </button>
                                <span class="modal-close" style="height: 40px;margin-top:10px"><a onclick="closeModal6()">Annuler</a></span>
                            </div>
                    </form>
                </div>
            </div>
        </body>

        </html>
<?php
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    echo "ID de la filière non fourni.";
}
?>