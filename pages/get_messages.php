<?php
$servername = "localhost"; // Nom du serveur
$username = "root"; // Nom d'utilisateur de la base de données
$password = ""; // Mot de passe de la base de données
$dbname = "gestion_stag"; // Nom de la base de données

try {
// Initialisation de la connexion PDO
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// Définition du mode d'erreur PDO sur exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Vérification si un utilisateur sélectionné est passé en POST
if(isset($_POST['selectedUserId'])) {
    $selectedUserId = $_POST['selectedUserId'];
    
    // Récupération des messages entre l'utilisateur connecté et l'utilisateur sélectionné
    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = :senderid AND receiver_id = :receiverid) OR (sender_id = :receiverid AND receiver_id = :senderid)");
    $stmt->bindParam(':senderid', $userId);
    $stmt->bindParam(':receiverid', $selectedUserId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des messages
    foreach ($messages as $message) {
        echo '<li class="message ' . ($message['sender_id'] == $selectedUserId ? 'incoming' : 'outgoing') . '">';
        echo '<div class="message-content">' . $message['message_text'] . '</div>';
        echo '<div class="message-time">' . $message['timestamp'] . '</div>';
        echo '</li>';
    }
}} catch(PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit; // Arrêt du script en cas d'erreur de connexion
    }
    ?>


