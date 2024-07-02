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
        echo "Utilisateur connecté: " . $row["login"]. " - Email: " . $row["email"]. "<br>";

        // Récupération des autres utilisateurs pour afficher la liste
        $stmt_users = $conn->prepare("SELECT * FROM utilisateur WHERE iduser != :idUtilisateur");
        $stmt_users->bindParam(':idUtilisateur', $idUtilisateurConnecte);
        $stmt_users->execute();
        
        // Affichage des autres utilisateurs
        echo "<h2>Autres utilisateurs :</h2>";
        echo "<ul>";
        while($user_row = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><a href='?sender={$idUtilisateurConnecte}&receiver={$user_row['iduser']}'>" . $user_row["login"] . "</a></li>";
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
            
            // Afficher les messages
            echo "<h2>Messages avec " . $row['login'] . " :</h2>";
            echo "<ul>";
            while ($message_row = $stmt_messages->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>De: " . $message_row['sender_id'] . " - À: " . $message_row['receiver_id'] . " - Contenu: " . $message_row['message_text'] . "</li>";
            }
            echo "</ul>";
            
            // Formulaire pour envoyer un nouveau message
            echo "<h2>Envoyer un nouveau message :</h2>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='sender' value='{$idUtilisateurConnecte}'>";
            echo "<input type='hidden' name='receiver' value='{$idDestinataire}'>";
            echo "<textarea name='message' placeholder='Votre message'></textarea><br>";
            echo "<input type='submit' value='Envoyer'>";
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
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null; // Fermer la connexion
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="assets/vendor/aos/aos.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
<!-- Template Main CSS File -->
<link href="./assets/css/style.css" rel="stylesheet">
<link href="../pages/assets/css/imprimer.css" rel="stylesheet">
<link href="./assets/img/favicon.png" rel="icon">
<link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<script src="../pages/assets/js/imprimer.js"></script>
     <!-- Favicons -->
     <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #444;
            border-radius: 10px;
            padding: 20px;
            overflow: hidden;
        }
        .message-container {
            margin-bottom: 20px;
            max-height: 300px; /* Hauteur maximale de la zone de messages */
            overflow-y: auto; /* Activer le défilement vertical */
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
            background-color: #4CAF50;
            float: left;
        }
        .message .receiver {
            background-color: #333;
            float: right;
        }
        .message .receiver1{
            
            float: right;
        }
        .message .meta {
            font-size: 0.8em;
            color: #999;
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
            height: 100px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            resize: none;
        }
        input[type="submit"] {
            background-color: #4CAF50;
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
      <img src="assets/img/wedo-technologies.png" alt="" class="img-fluid rounded-circle">
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
      <li><a href="indexx.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>bienvenus</span></a></li>
          <li><a href="indexx.php#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Filiere</span></a></li>
          <li><a href="indexx.php#facts" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Stagiaire</span></a></li>
          <li><a href="indexx.php#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>document imprimer</span></a></li>
          <li><a href="indexx.php#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Utilisateurs</span></a></li>
          <li><a href="indexx.php#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Compte</span></a></li>
          <li><a href="seDeconnecter.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Deconnexion</span></a></li>

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
        echo "Utilisateur connecté: " . $row["login"]. " - Email: " . $row["email"]. "<br>";

        // Récupération des autres utilisateurs pour afficher la liste
        $stmt_users = $conn->prepare("SELECT * FROM utilisateur WHERE iduser != :idUtilisateur");
        $stmt_users->bindParam(':idUtilisateur', $idUtilisateurConnecte);
        $stmt_users->execute();
        
        // Affichage des autres utilisateurs
        echo "<h2>Autres utilisateurs :</h2>";
        echo "<ul>";
        while($user_row = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><a href='?sender={$idUtilisateurConnecte}&receiver={$user_row['iduser']}'>" . $user_row["login"] . "</a></li>";
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

            // Afficher les messages
echo "<h2>Messages avec " . $row['login'] . " :</h2>";
echo "<div class='message-container' id='message-container'>";
while ($message_row = $stmt_messages->fetch(PDO::FETCH_ASSOC)) {
    if ($message_row['sender_id'] == $idUtilisateurConnecte) {
        echo "<div class='message'>";
        echo "<div class='sender'>" . $message_row['message_text'] . "</div>";
        echo "<div class='meta'><span >" . $row['login'] . "</span></div>";
        echo "</div>";
    } else {
        echo "<div class='message'>";
        echo "<div class='receiver'>" . $message_row['message_text'] . "</div>";
        echo "<div class='meta'><span class='receiver1'>" . $receiver_row['login'] . "</span></div>";
        echo "</div>";
    }
}
echo "</div>";

            
            // Formulaire pour envoyer un nouveau message
            echo "<h2>Envoyer un nouveau message :</h2>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='sender' value='{$idUtilisateurConnecte}'>";
            echo "<input type='hidden' name='receiver' value='{$idDestinataire}'>";
            echo "<textarea name='message' placeholder='Votre message'></textarea><br>";
            echo "<input type='submit' value='Envoyer'>";
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
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null; // Fermer la connexion
?>
<script>
    // Fonction pour faire défiler vers le bas de la zone de messages
    function scrollToBottom() {
        var messageContainer = document.getElementById('message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    // Appeler la fonction scrollToBottom lorsque la page est chargée
    window.onload = function() {
        scrollToBottom();
    };
</script>

    </div>
</body>
</html>
