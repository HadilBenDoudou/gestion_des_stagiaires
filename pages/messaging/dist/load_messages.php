<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag"; // Remplacez par le nom de votre base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données GET
    $userId = $_GET['userId'];
    $senderId = $_GET['senderId'];

    // Vérifier si les données GET sont présentes
    if (isset($userId) && isset($senderId)) {
        // Récupérer les messages de la conversation entre l'expéditeur et le destinataire
        $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = :senderId AND receiver_id = :userId) OR (sender_id = :userId AND receiver_id = :senderId)");
        $stmt->bindParam(':senderId', $senderId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Afficher les messages
        foreach ($messages as $message) {
            $messageClass = ($message['sender_id'] == $senderId) ? 'sent' : 'received';
            echo '<div class="message ' . $messageClass . '">';
            echo '<p>' . $message['message_text'] . '</p>';
            echo '</div>';
        }
    } else {
        echo "Erreur: Données GET manquantes.";
    }
} catch(PDOException $e) {
    echo "Erreur lors de la récupération des messages: " . $e->getMessage();
}
?>
