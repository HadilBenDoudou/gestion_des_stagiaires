<?php
// Vérifier si un identifiant de tâche a été envoyé
if (isset($_POST['task_id'])) {
    // Connexion à la base de données (exemple avec PDO)
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stag', 'root', '');

    // Préparation et exécution de la requête de suppression
    $query = $pdo->prepare("DELETE FROM taches WHERE id = ?");
    $query->execute([$_POST['task_id']]);

    // Récupérer la valeur de la variable sender depuis l'URL
    $sender = isset($_GET['sender']) ? $_GET['sender'] : '';

    // Redirection vers la page précédente avec la variable sender dans l'URL
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '&sender=' . $sender);
    exit();
} else {
    // Si aucun identifiant de tâche n'a été envoyé, rediriger vers une page d'erreur ou afficher un message d'erreur
    echo "Erreur : aucun identifiant de tâche fourni.";
}
