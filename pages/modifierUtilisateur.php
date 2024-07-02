<?php
// Assurez-vous que l'utilisateur est connecté ou a les autorisations nécessaires pour modifier les utilisateurs
// Vous pouvez ajouter votre logique de vérification d'autorisation ici

require_once("connexiondb.php");

// Récupérer les données envoyées depuis le formulaire d'édition
$idUser = isset($_POST['idUser']) ? $_POST['idUser'] : null;
$login = isset($_POST['login']) ? $_POST['login'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$role = isset($_POST['role']) ? $_POST['role'] : null;
$sender = isset($_GET['sender']) ? $_GET['sender'] : null; // Récupérer le paramètre sender de l'URL

// Vérifier si toutes les données nécessaires sont fournies
if (!$idUser || !$login || !$email || !$role) {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    echo "Toutes les données nécessaires n'ont pas été fournies.";
    exit; // Arrêter l'exécution du script
}

// Requête de mise à jour de l'utilisateur dans la base de données
$requeteMiseAJour = "UPDATE utilisateur SET login = :login, email = :email, role = :role WHERE iduser = :idUser";
$stmt = $pdo->prepare($requeteMiseAJour);
$stmt->bindParam(':login', $login);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':idUser', $idUser);

// Exécuter la requête de mise à jour
if ($stmt->execute()) {
    // Rediriger vers une page de succès ou afficher un message de succès
    echo "<script>alert('Utilisateur mis à jour avec succès.');</script>";
    // Rediriger vers la page indexx.php avec le paramètre sender dans l'URL
    echo "<script>window.location = 'indexx.php?sender=$sender#services';</script>";
} else {
    // Gérer les erreurs de mise à jour (afficher un message d'erreur, journaliser l'erreur, etc.)
    echo "<script>alert('Une erreur est survenue lors de la mise à jour de l'utilisateur.');</script>";
    // Rediriger vers la page indexx.php avec le paramètre sender dans l'URL
    echo "<script>window.location = 'indexx.php?sender=$sender#services';</script>";
}
