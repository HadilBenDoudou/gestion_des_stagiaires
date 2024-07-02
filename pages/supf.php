<?php
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
// Vérification si l'identifiant de la filière est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Connexion à la base de données avec PDO
    try {
        $host = "localhost";
        $dbname = "gestion_stag";
        $username = "root";
        $password = "";

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Désactiver les contraintes de clé étrangère temporairement
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

        // Préparation de la requête de suppression
        $requete = "DELETE FROM filiere WHERE idFiliere = ?";
        $statement = $pdo->prepare($requete);

        // Exécution de la requête de suppression
        $statement->execute([$_GET['id']]);

        // Réactiver les contraintes de clé étrangère
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Redirection vers la page principale après la suppression
        header("Location: indexx.php?idUser=" . $sender . "#about");
        exit();
    } catch (PDOException $e) {
        echo "Échec de la connexion : " . $e->getMessage();
    }
} else {
    // Redirection vers la page principale si l'identifiant de la filière n'est pas passé en paramètre
    header("Location: indexx.php?idUser=" . $sender . "#about");
    exit();
}
