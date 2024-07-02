<?php

use Dompdf\Css\Color;

$idUtilisateurConnecte = isset($_GET['sender']) ? $_GET['sender'] : null;

// Connexion à la base de données
$servername = "localhost";
$dbname = "gestion_stag";
$username = "root";
$password = "";

// Traitement de l'envoi de message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $messageText = $_POST['message'];
    $photo = $_FILES['photo']; // Récupération du fichier photo
    $file = $_FILES['file']; // Récupération du fichier

    // Vérification si un fichier photo a été envoyé
    if ($photo['error'] === UPLOAD_ERR_OK) {
        // Assurez-vous que le fichier est une image
        $mime_type = mime_content_type($photo['tmp_name']);
        if (strpos($mime_type, "image/") !== false) {
            $uploadDir = '../../../img'; // Modifier le chemin selon vos besoins
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

    // Insertion du message dans la base de données
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt_insert_message = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text, image_path, file_path) VALUES (:sender, :receiver, :message, :photo, :file)");
        $stmt_insert_message->bindParam(':sender', $sender);
        $stmt_insert_message->bindParam(':receiver', $receiver);
        $stmt_insert_message->bindParam(':message', $messageText);
        $stmt_insert_message->bindParam(':photo', $photoPath);
        $stmt_insert_message->bindParam(':file', $filePath);

        if ($stmt_insert_message->execute()) {
            // Redirection après envoi du message
            header("Location: {$_SERVER['PHP_SELF']}?sender=$sender&receiver=$receiver");
            exit();
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

// Maintenant, commencez votre code HTML
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../../css/monstyle.css">
    <!-- Template Main CSS File -->
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="../pages/assets/css/imprimer.css" rel="stylesheet">
    <link href="./assets/img/favicon.png" rel="icon">
    <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <script src="../pages/assets/js/imprimer.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAFA;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            overflow: hidden;
        }

        .message-container {
            margin-bottom: 20px;
            max-height: 300px;
            /* Hauteur maximale de la zone de messages */
            overflow-y: auto;
            /* Activer le défilement vertical */
        }

        .message {
            clear: both;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .message .sender,
        .message .receiver {
            border-radius: 10px;
            padding: 10px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .message .sender {
            background-color: #0086ff;
            float: left;
        }

        .message .receiver {
            background-color: #adb3b6;
            float: right;
        }

        .message .receiver1 {

            float: right;
        }

        .message .meta {
            font-size: 0.8em;
            color: #333;
            clear: both;
        }

        .message .meta span {
            margin-right: 10px;
        }

        .message .meta .sender {
            float: left;
        }

        .message .meta .receiver {
            float: right;
        }

        .message .clear {
            clear: both;
        }

        h2 {
            color: #fff;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            resize: none;
            color: #333;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <!-- ======= Mobile nav toggle button ======= -->
    <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>
    <!-- ======= Header ======= -->
    <header id="header">
        <div class="d-flex flex-column">

            <div class="profile">
                <img src="../../assets/img/wedo-technologies.png" alt="" class="img-fluid rounded-circle">
                <h1 class="text-light"><a href="index2.php">WeDo Consult</a></h1>
                <div class="social-links mt-3 text-center">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>

            <nav id="navbar" class="nav-menu navbar">
                <ul>

                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>bienvenus</span></a></li>

                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Filiere</span></a></li>
                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>#facts" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Stagiaire</span></a></li>
                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>document imprimer</span></a></li>
                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Utilisateurs</span></a></li>
                    <li><a href="../../indexx.php?idUser=<?php echo $idUtilisateurConnecte; ?>#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Compte</span></a></li>

                    <li><a href="../../seDeconnecter.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Deconnexion</span></a></li>

                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <?php
        // Récupérer l'ID de l'utilisateur connecté à partir de la requête GET
        $idUtilisateurConnecte = isset($_GET['sender']) ? $_GET['sender'] : null;

        // Vérifier si l'ID de l'utilisateur connecté est disponible
        if ($idUtilisateurConnecte === null) {
            echo "Erreur: ID de l'utilisateur non spécifié.";
            exit(); // Arrêter l'exécution du script
        }

        // Connexion à la base de données (à remplacer avec vos propres informations de connexion)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gestion_stag";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Définir le mode d'erreur PDO à exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Récupération des informations sur l'utilisateur connecté
            $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE iduser = :idUtilisateur");
            $stmt->bindParam(':idUtilisateur', $idUtilisateurConnecte);
            $stmt->execute();

            // Vérifier si l'utilisateur existe dans la base de données
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p style='color: #333;'>Utilisateur connecté: " . $row["login"] . " - Email: " . $row["email"] . "</p><br>";

                // Récupération des autres utilisateurs pour afficher la liste
                $stmt_users = $conn->prepare("SELECT * FROM utilisateur WHERE iduser != :idUtilisateur");
                $stmt_users->bindParam(':idUtilisateur', $idUtilisateurConnecte);
                $stmt_users->execute();

                // Affichage des autres utilisateurs
                echo "<h2 style='color: #333; font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase;'>Autres utilisateurs :</h2>";

                echo "<ul>";
                while ($user_row = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="msg">';
                    echo '<img class="msg-profile" src="image2.png" alt="" />';
                    echo "<li style='color:#333;'><a style='color:#333;' href='?sender={$idUtilisateurConnecte}&receiver={$user_row['iduser']}'>" . $user_row["login"] . "</a></li>";

                    echo '</div>';
                }
                echo "</ul>";

                // Vérifier si un utilisateur destinataire a été sélectionné
                $idDestinataire = isset($_GET['receiver']) ? $_GET['receiver'] : null;

                if ($idDestinataire !== null) {
                    // Afficher les messages échangés avec l'utilisateur sélectionné
                    $stmt_messages = $conn->prepare("SELECT * FROM messages WHERE (sender_id = :idUtilisateur AND receiver_id = :idDestinataire) OR (sender_id = :idDestinataire AND receiver_id = :idUtilisateur)");
                    $stmt_messages->bindParam(':idUtilisateur', $idUtilisateurConnecte);
                    $stmt_messages->bindParam(':idDestinataire', $idDestinataire);
                    $stmt_messages->execute();
                    // Récupérer les informations sur le destinataire
                    $stmt_receiver = $conn->prepare("SELECT * FROM utilisateur WHERE iduser = :idDestinataire");
                    $stmt_receiver->bindParam(':idDestinataire', $idDestinataire);
                    $stmt_receiver->execute();
                    if ($stmt_receiver->rowCount() > 0) {
                        $receiver_row = $stmt_receiver->fetch(PDO::FETCH_ASSOC);
                    } else {
                        // Gérer le cas où le destinataire n'est pas trouvé
                        // Vous pouvez afficher un message d'erreur ou effectuer une autre action appropriée
                    }
                    // Fonction pour obtenir l'icône correspondant à l'extension du fichier
                    function getFileIcon($filename)
                    {
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                        switch ($extension) {
                            case 'pdf':
                                return 'icon-pdf.png';
                            case 'doc':
                            case 'docx':
                                return 'icon-doc.png';
                            case 'txt':
                                return 'icon-txt.png';
                                // Ajoutez des cas pour d'autres types de fichiers selon vos besoins
                            default:
                                return 'icon-file.png'; // Icône par défaut pour les autres types de fichiers
                        }
                    }
                    // Afficher les messages
                    echo "<h2>Messages avec " . $row['login'] . " :</h2>";
                    // Afficher les messages
                    echo "<div class='message-container' id='message-container'>";
                    while ($message_row = $stmt_messages->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='message'>";
                        if ($message_row['sender_id'] == $idUtilisateurConnecte) {
                            echo "<div class='sender'>";
                        } else {
                            echo "<div class='receiver'>";
                        }
                        echo "<p>" . $message_row['message_text'] . "</p>";
                        if (!empty($message_row['image_path'])) {
                            echo "<img src='" . $message_row['image_path'] . "' class='message-image'>";
                        }
                        if (!empty($message_row['file_path'])) {
                            $fileIcon = getFileIcon($message_row['file_path']);
                            echo "<img style='width:20px;height;20px' src='$fileIcon'>"; // Afficher l'icône correspondant à l'extension du fichier
                            echo "<a href='" . $message_row['file_path'] . "'>" . basename($message_row['file_path']) . "</a>"; // Afficher le nom du fichier
                        }
                        echo "</div>";
                        echo "<div class='meta'>";
                        // Afficher les informations sur l'expéditeur ou le destinataire
                        echo "</div>";
                        echo "</div>";
                    }

                    echo "</div>";


                    // Formulaire pour envoyer un nouveau message
                    echo "<h2>Envoyer un nouveau message :</h2>";
                    echo "<form method='post' enctype='multipart/form-data'>";
                    echo "<input type='hidden' name='sender' value='{$idUtilisateurConnecte}'>";
                    echo "<input type='hidden' name='receiver' value='{$idDestinataire}'>";
                    echo "<textarea name='message' placeholder='Votre message' style='background-color: #f0f0f0; box-shadow: 0 0 5px rgba(0,0,0,0.3);'></textarea><br>";

                    echo '<input type="file" accept="image/*" name="photo" id="photo" style="display:none;">';
                    echo '<label for="photo">';
                    echo '<img src="fichiers-image.png" style="width: 30px; height: 30px; margin-left: 30px;" class="message-image" id="preview">';
                    echo '</label>';

                    echo '<input type="file" name="file" id="file" style="display:none;">';
                    echo '<label for="file">';
                    echo '<img src="ajouter-un-document.png" style="width: 30px; height: 30px; margin-left: 30px;" class="message-image" id="preview">';
                    echo 'Sélectionner un fichier';
                    echo '</label>';


                    echo "<input  type='submit' style='margin-left:30px' value='Envoyer'>";
                    echo "</form>";
                }
            } else {
                echo "Utilisateur non trouvé dans la base de données.";
            }

            // Traitement de l'envoi de message
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $sender = $_POST['sender'];
                $receiver = $_POST['receiver'];
                $messageText = $_POST['message'];

                $stmt_insert_message = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (:sender, :receiver, :message)");
                $stmt_insert_message->bindParam(':sender', $sender);
                $stmt_insert_message->bindParam(':receiver', $receiver);
                $stmt_insert_message->bindParam(':message', $messageText);

                if ($stmt_insert_message->execute()) {
                    // Redirection après envoi du message
                    header("Location: {$_SERVER['PHP_SELF']}?sender=$sender&receiver=$receiver");
                    exit();
                } else {
                    echo "Erreur lors de l'envoi du message.";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }

        $conn = null; // Fermer la connexion
        ?>
        <script>
            // Fonction pour faire défiler vers le bas de la page et de la zone de messages
            function scrollToBottom() {
                var messageContainer = document.getElementById('message-container');
                messageContainer.scrollTop = messageContainer.scrollHeight;
                window.scrollTo(0, document.body.scrollHeight);
            }

            // Appeler la fonction scrollToBottom lorsque la page est chargée
            window.onload = function() {
                scrollToBottom();
            };
        </script>


    </div>
</body>

</html>