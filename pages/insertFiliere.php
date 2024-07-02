<?php
require_once('connexiondb.php');
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;


$nomf = isset($_POST['nomF']) ? $_POST['nomF'] : "";
$niveau = isset($_POST['niveau']) ? strtoupper($_POST['niveau']) : "";

if (!empty($nomf) && !empty($niveau)) {
    try {
        $requete = "INSERT INTO filiere (nomFiliere, niveau) VALUES (?, ?)";
        $params = array($nomf, $niveau);
        $resultat = $pdo->prepare($requete);
        $resultat->execute($params);

        // Redirection après l'insertion réussie
        header("Location: indexx.php?idUser=" . $sender . "#about");

        exit(); // Assurez-vous qu'aucun code supplémentaire n'est exécuté après la redirection
    } catch (PDOException $e) {
        // Gérer l'erreur de violation de contrainte d'unicité
        if ($e->errorInfo[1] == 1062) { // Code d'erreur MySQL pour la violation de la contrainte d'unicité
            echo "<script>alert('Erreur : Le nom de filière \"$nomf\" existe déjà.'); window.location.href = 'indexx.php#about';</script>";
        } else {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
        }
    }
} else {

    echo "<script>alert('Erreur : Veuillez remplir tous les champs.'); window.location.href = 'indexx.php#about';</script>";
}
?>
<!--fin php de insert-->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un filiere</title>
    <link rel="stylesheet" href="../pages/assets/css/insertFiliere.css">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>

<body>
    <div class="modal-background" id="hadil5">
        <div class="modal-content" style="width: 600px;">
            <a><button class="close" onclick="closeModal5()">&times;</button></a>
            <h2 id="h">Ajouter un filiere</h2>
            <form action="insertFiliere.php?idUser=<?php echo $sender; ?>" method="post" class="form" enctype="multipart/form-data">
                <input type="text" class="email" id="nomF" name="nomF" required placeholder="Nom de la Filiere">
                <br />
                <input type="text" class="pwd" id="niveau" name="niveau" placeholder="Niveau" required>
                <br />
                <div class="form-group">
                    <div class="modal-buttons">
                        <button class="modal-confirm">
                            <span>Enregistrer</span>
                        </button>
                        <button class="modal-close" onclick="closeModal5()">
                            <span>Annuler</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>