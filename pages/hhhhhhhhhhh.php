



  <a href="page_messages.php?id=<?php echo $_SESSION['user']['iduser']; ?>">Nouveau message</a>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs requis sont définis et non vides
    if (isset($_POST["userid"]) && isset($_POST["message"]) && !empty($_POST["userid"]) && !empty($_POST["message"])) {
        // Récupérer les données du formulaire
        $receiverId = $_POST["userid"];
        $message = $_POST["message"];

        // Connexion à la base de données avec PDO
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

        } catch(PDOException $e) {
            echo "Erreur lors de l'envoi du message: " . $e->getMessage();
        }

        // Fermer la connexion à la base de données
        $conn = null;
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}

// Récupérer l'ID de l'utilisateur sélectionné à partir de l'URL
$selectedUserId = isset($_GET['idUser']) ? $_GET['idUser'] : null;

// Récupérer les utilisateurs depuis la base de données
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les utilisateurs depuis la base de données
    $stmt = $conn->query("SELECT * FROM utilisateur where role!='ADMIN'");
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les messages de l'utilisateur sélectionné
    if ($selectedUserId) {
        $stmt = $conn->prepare("SELECT * FROM messages WHERE receiver_id = :userid");
        $stmt->bindParam(':userid', $selectedUserId);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodePen - Messaging App UI with Dark Mode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<!-- partial:index.partial.html -->
<div class="app">
 <div class="header">

 
  <div class="user-settings">
  
   
  </div>
 
  <div class="search-bar">
   <input type="text" placeholder="Rechercher..." />
  </div>
  <div class="user-settings">
   <!-- Icônes de paramètres utilisateur ici -->
  </div>
 </div>
 <div class="wrapper">
  <div class="conversation-area">
   <?php foreach ($utilisateurs as $user): ?>
   <div class="msg" data-userid="<?= $user['iduser'] ?>">
    <img class="msg-profile" src="image2.png" alt="" data-userid="<?= $user['iduser'] ?>"/>
    <div class="msg-detail">
     <a class="msg-username" href="?idUser=<?= $user["iduser"] ?>"><?= $user["login"] ?></a>
     <div class="msg-content">
      <span class="msg-message"><?= $user['email'] ?></span>
      <span class="msg-date"><?= $user['role'] ?></span>
     </div>
    </div>
   </div>
   <?php endforeach; ?>
   <button class="add"></button>
   <div class="overlay"></div>
  </div>
  <div class="chat-area">
   <div class="chat-area-header">
    <div class="chat-area-title">CodePen Group</div>
    <div class="chat-area-group">
     <!-- Ici, vous pouvez afficher des informations sur le groupe -->
    </div>
   </div>
 <!-- Dans la section chat-area-main -->
<div class="chat-area-main">
    <?php if ($selectedUserId && isset($messages)): ?>
    <div class="chat-messages">
        <ul class="messages">
            <?php foreach ($messages as $message): ?>
            <li class="message <?= ($message['sender_id'] == $selectedUserId) ? 'outgoing' : 'incoming' ?>">
                <div class="message-content"><?= $message['message_text'] ?></div>
                <div class="message-time"><?= $message['timestamp'] ?></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<div class="chat-area-footer">
    <form method="post" class="message-form">
        <input type="hidden" name="userid" value="<?= $selectedUserId ?>">
        <input type="text" name="message" placeholder="Entrez votre message ici">
        <button type="submit">Envoyer</button>
    </form>
</div>

  <div class="detail-area">
   <!-- Détails de l'utilisateur sélectionné ici -->
  </div>
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Lorsque l'utilisateur clique sur un utilisateur
    $('.msg').click(function() {
        var userId = $(this.data('userid'));
        window.location.href = "index.php?idUser=" + userId;
    });
    function scrollToBottom() {
        var chatArea = $('.chat-area-main');
        chatArea.scrollTop(chatArea.prop("scrollHeight"));
    }

    // Appel de la fonction de défilement automatique au chargement de la page
    scrollToBottom();

    // Faire défiler vers le bas lorsqu'un nouveau message est envoyé
    $("form").submit(function() {
        scrollToBottom();
    });
});

</script>
</body>
</html>

<style>
    .message-content {
  color: #333;
}
    /* Style de base pour les liens */
    a {
    color: black; /* Couleur du texte du lien */
    text-decoration: underline; /* Soulignement du lien */
}

/* Style pour les liens avec la classe 'msg-username' */
.msg-username {
    color: #333; /* Couleur du texte du lien */
    text-decoration: none; /* Aucun soulignement */
    font-weight: bold; /* Police en gras */
}

.msg-username:hover {
    text-decoration: underline; /* Soulignement au survol */
}
    /* Dans votre fichier CSS */
.chat-area-main {
    flex: 1;
    overflow-y: auto;
}

.chat-messages {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.message {
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
    max-width: 70%;
}

.incoming {
    background-color: black;
    align-self: flex-start;
}

.outgoing {
    background-color: #e3e5e6;
    align-self: flex-end;
}

.message-content {
    word-wrap: break-word;
}

.message-time {
    font-size: 12px;
    color: #888;
    margin-top: 5px;
}
.message-form {
    display: flex;
}

.message-form input[type="text"] {
    flex: 1;
    margin-right: 5px; /* Ajoute un espacement entre l'input et le bouton */
}

.message-form button {
    flex-shrink: 0; /* Empêche le bouton de rétrécir pour s'adapter */
}


</style>













<?php
session_start(); // Démarrer la session pour accéder à $_SESSION

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['id'])) {
    $userId = $_GET['id']; // Récupérer l'ID de l'utilisateur depuis l'URL
} else {
    // Gérer l'erreur si l'ID de l'utilisateur n'est pas défini ou est vide
    echo "Erreur: Identifiant utilisateur non trouvé.";
    exit;
}

// Connexion à la base de données avec PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer tous les utilisateurs sauf celui dont l'ID est passé par l'URL
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE iduser != :userid");
    $stmt->bindParam(':userid', $userId);
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les messages de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM messages WHERE sender_id = :userid OR receiver_id = :userid");
    $stmt->bindParam(':userid', $userId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodePen - Messaging App UI with Dark Mode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="../pages/messaging/dist/style.css">
</head>
<body>
<div class="app">
 <div class="header">
  <div class="search-bar">
   <input type="text" placeholder="Rechercher..." />
  </div>
  <div class="user-settings">
   <!-- Icônes de paramètres utilisateur ici -->
  </div>
 </div>
 <div class="wrapper">
  <div class="conversation-area">
   <?php if (!empty($utilisateurs)): ?>
       <?php foreach ($utilisateurs as $user): ?>
           <div class="msg" data-userid="<?= $user['iduser'] ?>">
               <img class="msg-profile" src="./messaging/dist/image2.png" alt="" data-userid="<?= $user['iduser'] ?>"/>
               <div class="msg-detail">
                   <span class="msg-username"><?= $user["login"] ?></span>
                   <div class="msg-content">
                       <span class="msg-message"><?= $user['email'] ?></span>
                       <span class="msg-date"><?= $user['role'] ?></span>
                   </div>
               </div>
           </div>
       <?php endforeach; ?>
   <?php else: ?>
       <p>Aucun utilisateur trouvé.</p>
   <?php endif; ?>
   <button class="add"></button>
   <div class="overlay"></div>
  </div>
  <div class="chat-area">
   <div class="chat-area-header">
    <div class="chat-area-title">CodePen Group</div>
    <div class="chat-area-group">
     <!-- Ici, vous pouvez afficher des informations sur le groupe -->
    </div>
   </div>
   <div class="chat-area-main" id="messages-container">
     <!-- Les messages seront chargés ici via AJAX -->
   </div>
   <div class="chat-area-footer">
    <form id="message-form" class="message-form">
        <input type="hidden" name="userid" id="selectedUserId" value="">
        <input type="text" name="message" placeholder="Entrez votre message ici">
        <button type="submit">Envoyer</button>
    </form>
   </div>
   <div class="detail-area">
       <!-- Détails de l'utilisateur sélectionné ici -->
   </div>
  </div>
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.msg').click(function() {
        var userId = $(this).data('userid');
        $('#selectedUserId').val(userId);
        loadMessages(userId);
    });

    $('#message-form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.post('save_message.php', formData, function(response) {
            if (response.success) {
                loadMessages($('#selectedUserId').val());
                $('#message-form')[0].reset();
            } else {
                alert('Erreur lors de l\'envoi du message.');
            }
        }, 'json');
    });

    function loadMessages(userId) {
        $.get('get_messages.php?userid=' + userId, function(response) {
            if (response.success) {
                $('#messages-container').html(response.messages);
                scrollToBottom();
            } else {
                alert('Erreur lors du chargement des messages.');
            }
        }, 'json');
    }

    function scrollToBottom() {
        var chatArea = $('.chat-area-main');
        chatArea.scrollTop(chatArea.prop("scrollHeight"));
    }
});
</script>
</body>
</html>

