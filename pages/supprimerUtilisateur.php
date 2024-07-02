<?php
session_start();
require_once('connexiondb.php');

$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : 0;
$sender = isset($_GET['sender']) ? $_GET['sender'] : ''; // Récupérer le paramètre sender

$requete = "DELETE FROM utilisateur WHERE idUser=?";
$params = array($idUser);
$resultat = $pdo->prepare($requete);
$resultat->execute($params);

// Rediriger vers indexx.php avec le paramètre sender dans l'URL
header('location:indexx.php?sender=' . $sender . '#services');
