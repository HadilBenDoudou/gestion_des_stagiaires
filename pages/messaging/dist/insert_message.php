<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si les champs requis sont définis et non vides
        if (isset($_POST["userid"]) && isset($_POST["message"]) && !empty($_POST["userid"]) && !empty($_POST["message"])) {
            // Récupérer les données du formulaire
            $receiverId = $_POST["userid"];
            $message = $_POST["message"];

            // Récupérer l'ID de l'expéditeur à partir du champ caché du formulaire
            $senderId = isset($_POST['senderid']) ? $_POST['senderid'] : '';

            // Insérer le message dans la base de données
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (:senderid, :receiverid, :message)");
            $stmt->bindParam(':senderid', $senderId);
            $stmt->bindParam(':receiverid', $receiverId);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            echo "Message envoyé avec succès!";
        } else {
            echo "Tous les champs doivent être remplis.";
        }
    } else {
        echo "La requête n'est pas de type POST.";
    }
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
