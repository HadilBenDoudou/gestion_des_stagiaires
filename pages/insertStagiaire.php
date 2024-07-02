<?php
require_once('connexiondb.php');
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
$nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
$civilite = isset($_POST['civilite']) ? $_POST['civilite'] : "F";
$idFiliere = isset($_POST['idFiliere']) ? $_POST['idFiliere'] : 1;
$nomCarteIdentite = isset($_POST['carte_identite']) ? $_POST['carte_identite'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
// Vérifier la longueur du numéro de carte d'identité
if (strlen($nomCarteIdentite) != 8) {
    // Afficher un message d'erreur et rediriger
    echo "<script>alert('Le numéro de carte d\'identité doit contenir exactement 8 caractères.')</script>";
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';
    exit; // Arrêter le script
}

// Vérifier si l'email existe déjà dans la base de données
$requeteVerificationEmail = "SELECT COUNT(*) AS count FROM stagiaire WHERE email = ?";
$resultatVerificationEmail = $pdo->prepare($requeteVerificationEmail);
$resultatVerificationEmail->execute([$email]);
$donneesVerificationEmail = $resultatVerificationEmail->fetch();
if ($donneesVerificationEmail['count'] > 0) {
    // L'email existe déjà, affichez une alerte appropriée ou redirigez selon vos besoins
    // Par exemple :
    echo "<script>alert('Cet e-mail existe déjà.')</script>";
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';
    exit; // Arrêter le script pour éviter l'insertion dupliquée
}

// Vérifier si la carte d'identité existe déjà dans la base de données
$requeteVerification = "SELECT COUNT(*) AS count FROM stagiaire WHERE carte_identite = ?";
$resultatVerification = $pdo->prepare($requeteVerification);
$resultatVerification->execute([$nomCarteIdentite]);
$donneesVerification = $resultatVerification->fetch();
if ($donneesVerification['count'] > 0) {
    // La carte d'identité existe déjà, affichez une alerte appropriée ou redirigez selon vos besoins
    // Par exemple :
    echo "<script>alert('La carte d\'identité existe déjà.')</script>";
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';
    exit; // Arrêter le script pour éviter l'insertion dupliquée
} else {
    // Traitement de la photo du stagiaire
    $nomPhoto = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : "";
    $imageTemp = $_FILES['photo']['tmp_name'];
    move_uploaded_file($imageTemp, "../images/" . $nomPhoto);
    // Insertion des données
    $requete = "INSERT INTO stagiaire (nom, prenom, civilite, idFiliere, photo, carte_identite,email) VALUES (?, ?, ?, ?, ?, ?,?)";
    $params = array($nom, $prenom, $civilite, $idFiliere, $nomPhoto, $nomCarteIdentite, $email);
    $resultat = $pdo->prepare($requete);
    $resultat->execute($params);
    // Rediriger après l'insertion réussie
    header('Location: indexx.php?idUser=' . $sender . '#facts');
    exit();
    // Arrêter le script après la redirection
}
