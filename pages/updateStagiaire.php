<?php
require_once 'connexiondb.php';
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
// Retrieve form data
$idS = isset($_POST['idS']) ? $_POST['idS'] : 0;
$nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
$civilite = isset($_POST['civilite']) ? $_POST['civilite'] : "F";
$idFiliere = isset($_POST['idFiliere']) ? $_POST['idFiliere'] : 1;
$carte_identite = isset($_POST['carte_identite']) ? $_POST['carte_identite'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Check if the carte_identite is repeated
$requeteCheckCarte = "SELECT idStagiaire FROM stagiaire WHERE carte_identite = ? AND idStagiaire != ?";
$stmtCheckCarte = $pdo->prepare($requeteCheckCarte);
$stmtCheckCarte->execute([$carte_identite, $idS]);
$existingStagiaire = $stmtCheckCarte->fetch();

// If a stagiaire with the same carte d'identité exists and it's not the current stagiaire being edited
if ($existingStagiaire) {
    echo '<script>alert("Une autre stagiaire avec la même carte d\'identité existe déjà.");</script>';
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';

    exit; // Stop further execution
}

// Check the length of carte_identite
if (strlen($carte_identite) != 8) {
    echo '<script>alert("Le numéro de carte d\'identité doit contenir exactement 8 caractères.");</script>';
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';

    exit; // Stop further execution
}

// Check if email is valid and has an extension
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/\.[a-zA-Z]{2,}$/', $email)) {
    echo '<script>alert("L\'adresse e-mail n\'est pas valide ou ne possède pas d\'extension valide.");</script>';
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';

    exit; // Stop further execution
}

// Check if the email is repeated
$requeteCheckEmail = "SELECT idStagiaire FROM stagiaire WHERE email = ? AND idStagiaire != ?";
$stmtCheckEmail = $pdo->prepare($requeteCheckEmail);
$stmtCheckEmail->execute([$email, $idS]);
$existingEmail = $stmtCheckEmail->fetch();

// If a stagiaire with the same email exists and it's not the current stagiaire being edited
if ($existingEmail) {
    echo '<script>alert("Une autre stagiaire avec le même e-mail existe déjà.");</script>';
    echo '<script>window.location.href = "indexx.php?idUser=' . $sender . '#facts";</script>';

    exit; // Stop further execution
}

// Handle photo update
$nomPhoto = "";
if (!empty($_FILES['photo']['name'])) {
    $nomPhoto = $_FILES['photo']['name'];
    $imageTemp = $_FILES['photo']['tmp_name'];
    move_uploaded_file($imageTemp, "../images/" . $nomPhoto);
} else {
    $requetePhoto = "SELECT photo FROM stagiaire WHERE idStagiaire = ?";
    $stmtPhoto = $pdo->prepare($requetePhoto);
    $stmtPhoto->execute([$idS]);
    $resultatPhoto = $stmtPhoto->fetch();
    $nomPhoto = $resultatPhoto['photo'];
}

// Prepare the update query
if (!empty($carte_identite)) {
    $requete = "UPDATE stagiaire SET nom=?, prenom=?, idFiliere=?, photo=?, civilite=?, carte_identite=?, email=? WHERE idStagiaire=?";
    $params = array($nom, $prenom, $idFiliere, $nomPhoto, $civilite, $carte_identite, $email, $idS);
} else {
    $requete = "UPDATE stagiaire SET nom=?, prenom=?, idFiliere=?, photo=?, civilite=?, email=? WHERE idStagiaire=?";
    $params = array($nom, $prenom, $idFiliere, $nomPhoto, $civilite, $email, $idS);
}

// Execute the update query
$resultat = $pdo->prepare($requete);
$resultat->execute($params);

// Redirect to the appropriate page
header("Location: indexx.php?idUser=" . $sender . "#facts");
exit();
