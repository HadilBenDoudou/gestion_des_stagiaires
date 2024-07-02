<?php
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idFiliere'])) {
    try {
        $host = "localhost";
        $dbname = "gestion_stag";
        $username = "root";
        $password = "";

        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête de mise à jour
        $requete = "UPDATE filiere SET nomFiliere = :nomFiliere, niveau = :niveau WHERE idFiliere = :idFiliere";
        $statement = $pdo->prepare($requete);

        // Liaison des paramètres
        $statement->bindParam(':nomFiliere', $_POST['nomFiliere']);
        $statement->bindParam(':niveau', $_POST['niveau']);
        $statement->bindParam(':idFiliere', $_POST['idFiliere']);

        // Exécution de la requête de mise à jour
        $statement->execute();

        // Redirection vers la page principale après la mise à jour
        header("Location: indexx.php?idUser=" . $sender . "#about");
        exit();
    } catch (PDOException $e) {
        echo "Échec de la mise à jour : " . $e->getMessage();
    }
} else {
    echo "Formulaire non soumis ou ID de la filière non fourni.";
}
