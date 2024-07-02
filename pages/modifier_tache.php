<?php
// Assurez-vous que la connexion à la base de données est correcte
require_once "connexiondb.php"; // Assurez-vous que le chemin d'accès est correct

// Assurez-vous que la connexion à la base de données est établie avec succès
if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Vérifie si l'ID de la tâche est passé via le formulaire
$taskId = isset($_POST['taskId']) ? intval($_POST['taskId']) : null;

if (!$taskId) {
    die("ID de tâche non fourni.");
}

try {
    // Récupération des données soumises via le formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_limite = $_POST['date_limite'];
    $etat = $_POST['etat'];

    // Préparation de la requête SQL pour la mise à jour de la tâche
    $query = $pdo->prepare("UPDATE taches SET titre=?, description=?, date_limite=?, etat=? WHERE id=?");
    $query->execute([$titre, $description, $date_limite, $etat, $taskId]);

    // Répondre avec un message de succès
    echo "success";
} catch(PDOException $e) {
    // Répondre avec un message d'erreur
    echo "Erreur : " . $e->getMessage();
}
?>
