<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_stag";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}

// Vérifier si l'identifiant de l'encadreur est présent dans la requête GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Préparer la requête SQL de suppression
        $stmt = $pdo->prepare("DELETE FROM encadreurs WHERE id = :id");
        // Liaison de paramètres
        $stmt->bindParam(':id', $id);
        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'affichage des encadreurs après la suppression
        header("Location: indexx.php#encadreurs");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'encadreur: " . $e->getMessage();
        exit();
    }
} else {
    echo "Identifiant de l'encadreur non spécifié.";
    exit();
}
