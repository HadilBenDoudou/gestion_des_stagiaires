<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user']['iduser'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

// Récupère l'ID de l'utilisateur connecté depuis la session
$userId = $_SESSION['user']['iduser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receiverId = $_POST["receiverId"];
    $replyMessage = $_POST["replyMessage"];
    $photo = $_FILES['photo']; // Récupération du fichier photo
    $file = $_FILES['file']; // Récupération du fichier

    // Vérification si un fichier photo a été envoyé
    $photoPath = null;
    if ($photo['error'] === UPLOAD_ERR_OK) {
        // Assurez-vous que le fichier est une image
        $mime_type = mime_content_type($photo['tmp_name']);
        if (strpos($mime_type, "image/") !== false) {
            $uploadDir = '../../../img/'; // Modifier le chemin selon vos besoins
            $uploadPhoto = $uploadDir . basename($photo['name']);
            if (move_uploaded_file($photo['tmp_name'], $uploadPhoto)) {
                $photoPath = $uploadPhoto;
            } else {
                echo "Erreur lors de l'envoi de la photo.";
            }
        } else {
            echo "Le fichier photo n'est pas une image.";
        }
    }

    // Vérification si un fichier a été envoyé
    $filePath = null;
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Déplacer le fichier téléchargé vers un emplacement souhaité
        $uploadDir = '../../../fichier'; // Modifier le chemin selon vos besoins
        $uploadFile = $uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $filePath = $uploadFile;
        } else {
            echo "Erreur lors de l'envoi du fichier.";
        }
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insère la réponse dans la base de données
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text, image_path, file_path) VALUES (:senderid, :receiverid, :message, :photo, :file)");
        $stmt->bindParam(':senderid', $userId);
        $stmt->bindParam(':receiverid', $receiverId);
        $stmt->bindParam(':message', $replyMessage);
        $stmt->bindParam(':photo', $photoPath);
        $stmt->bindParam(':file', $filePath);
        $stmt->execute();

        // Redirige vers la page de la conversation après l'envoi de la réponse
        header("Location: page_messages.php?idUser=" . $receiverId);
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de l'envoi de la réponse: " . $e->getMessage();
    }
} else {
    // Redirige vers la page d'accueil si les données du formulaire sont invalides ou manquantes
    header("Location: ../../filieres.php");
    exit;
}
