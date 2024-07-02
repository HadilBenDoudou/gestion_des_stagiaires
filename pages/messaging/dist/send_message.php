<?php
// Récupérer les données du formulaire
$senderId = $_POST['sender'];
$receiverId = $_POST['receiver'];
$message = $_POST['message'];

// Votre logique de traitement de l'envoi du message, par exemple l'insertion dans la base de données

// Après avoir traité l'envoi du message, vous pouvez renvoyer le contenu du nouveau message
// Ici, je vais simplement renvoyer le contenu du message pour l'exemple
echo $message;
?>
