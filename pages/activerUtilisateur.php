<?php
//Démarre une nouvelle session ou reprend une session existante.  
session_start();

require_once('connexiondb.php');

$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : 0;
$etat = isset($_GET['etat']) ? $_GET['etat'] : 0;

if ($etat == 1)
    $newEtat = 0;
else
    $newEtat = 1;

$requete = "UPDATE utilisateur SET etat=? WHERE iduser=?";
$params = array($newEtat, $idUser);

$resultat = $pdo->prepare($requete);
$resultat->execute($params);

// Récupération du paramètre 'sender' depuis la requête GET
$sender = isset($_GET['sender']) ? $_GET['sender'] : '';

// Redirection avec le paramètre 'sender' inclus dans l'URL
header('Location: indexx.php?sender=' . $sender . '#services');
