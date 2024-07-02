<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs requis sont définis et non vides
    if (isset($_POST["userid"]) && isset($_POST["message"]) && !empty($_POST["userid"]) && !empty($_POST["message"])) {
        // Récupérer les données du formulaire
        $receiverId = $_POST["userid"];
        $message = $_POST["message"];

        // Connexion à la base de données avec PDO
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gestion_stag";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur PDO sur exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Récupérer l'ID de l'expéditeur à partir de l'URL
            if (isset($_GET['idUser'])) {
                $senderId = $_GET['idUser'];
            } else {
                // Gérer l'erreur si idUser n'est pas défini ou est vide
                echo "Erreur: Identifiant utilisateur expéditeur non trouvé.";
                exit;
            }

            // Insérer le message dans la base de données
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (:senderid, :receiverid, :message)");
            $stmt->bindParam(':senderid', $senderId);
            $stmt->bindParam(':receiverid', $receiverId);
            $stmt->bindParam(':message', $message);
            $stmt->execute();

            echo "Message envoyé avec succès!";
        } catch(PDOException $e) {
            echo "Erreur lors de l'envoi du message: " . $e->getMessage();
        }

        // Fermer la connexion à la base de données
        $conn = null;
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} else {
    // Rediriger l'utilisateur vers une autre page si le formulaire n'a pas été soumis
    header("Location: index.php"); // Remplacer index.php par la page souhaitée
    exit;
}
?>
