<?php
$sender = isset($_GET['idUser']) ? $_GET['idUser'] : null;
$host = "localhost";
$dbname = "gestion_stag";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Autres configurations PDO...
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}

$idS = isset($_GET['idS']) ? $_GET['idS'] : 0;

$requete = "delete from stagiaire where idStagiaire=?";

$params = array($idS);

$resultat = $pdo->prepare($requete);

$resultat->execute($params);

header('Location: indexx.php?idUser=' . $sender . '#facts');
exit();
