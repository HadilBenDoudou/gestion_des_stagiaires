<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'utilisateur sélectionné depuis la requête AJAX
    $selectedUserId = isset($_GET['selectedUserId']) ? $_GET['selectedUserId'] : null;

    // Récupérer les messages de l'utilisateur sélectionné depuis la base de données
    $stmt = $conn->prepare("SELECT * FROM messages WHERE sender_id = :userid OR receiver_id = :userid ORDER BY message_id DESC");
    $stmt->bindParam(':userid', $selectedUserId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les messages
    foreach ($messages as $message) {
        echo '<div class="message">';
        echo '<div class="message-sender">' . $message['sender_id'] . '</div>';
        echo '<div class="message-content">' . $message['message_text'] . '</div>';
        echo '</div>';
    }
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
