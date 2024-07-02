<?php
session_start();
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
function getLastMessage($userId, $otherUserId, $conn)
{
    try {
        $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = :userId AND receiver_id = :otherUserId) OR (sender_id = :otherUserId AND receiver_id = :userId) ORDER BY timestamp DESC LIMIT 1");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':otherUserId', $otherUserId);
        $stmt->execute();
        $lastMessage = $stmt->fetch(PDO::FETCH_ASSOC);
        return $lastMessage;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du dernier message: " . $e->getMessage();
        return false;
    }
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user']['iduser'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../../login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

// Récupère l'ID de l'utilisateur connecté depuis la session
$userId = $_SESSION['user']['iduser'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupère les utilisateurs, excluant l'utilisateur connecté
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE iduser != :userid");
    $stmt->bindParam(':userid', $userId);
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifie si un utilisateur est sélectionné
    $selectedUserId = isset($_GET['idUser']) ? $_GET['idUser'] : null;

    // Récupère les messages si un utilisateur est sélectionné
    if ($selectedUserId) {
        // Récupère les messages reçus et envoyés par l'utilisateur connecté avec les détails des expéditeurs et des destinataires
        $stmt = $conn->prepare("SELECT m.*, s.login AS sender_login, r.login AS receiver_login FROM messages m LEFT JOIN utilisateur s ON m.sender_id = s.iduser LEFT JOIN utilisateur r ON m.receiver_id = r.iduser WHERE (sender_id = :userid AND receiver_id = :selectedUserId) OR (sender_id = :selectedUserId AND receiver_id = :userid) ORDER BY timestamp ASC");
        $stmt->bindParam(':userid', $userId);
        $stmt->bindParam(':selectedUserId', $selectedUserId);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupère les informations de l'utilisateur sélectionné
        $stmt_user = $conn->prepare("SELECT * FROM utilisateur WHERE iduser = :selectedUserId");
        $stmt_user->bindParam(':selectedUserId', $selectedUserId);
        $stmt_user->execute();
        $selectedUser = $stmt_user->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Messaging App UI with Dark Mode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>



    <!-- partial:index.partial.html -->
    <div class="app">
        <div class="header">
            <div class="logo">
                <svg viewBox="0 0 513 513" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M256.025.05C117.67-2.678 3.184 107.038.025 245.383a240.703 240.703 0 0085.333 182.613v73.387c0 5.891 4.776 10.667 10.667 10.667a10.67 10.67 0 005.653-1.621l59.456-37.141a264.142 264.142 0 0094.891 17.429c138.355 2.728 252.841-106.988 256-245.333C508.866 107.038 394.38-2.678 256.025.05z" />
                    <path d="M330.518 131.099l-213.825 130.08c-7.387 4.494-5.74 15.711 2.656 17.97l72.009 19.374a9.88 9.88 0 007.703-1.094l32.882-20.003-10.113 37.136a9.88 9.88 0 001.083 7.704l38.561 63.826c4.488 7.427 15.726 5.936 18.003-2.425l65.764-241.49c2.337-8.582-7.092-15.72-14.723-11.078zM266.44 356.177l-24.415-40.411 15.544-57.074c2.336-8.581-7.093-15.719-14.723-11.078l-50.536 30.744-45.592-12.266L319.616 160.91 266.44 356.177z" fill="#fff" />
                </svg>
            </div>
            <div class="user-settings"></div>
            <div class="search-bar">

                <input type="text" id="searchInput2" placeholder="Rechercher..." style="margin-right: 1100px;">


                <script>
                    // Fonction pour filtrer les utilisateurs
                    function filterUsers() {
                        var input = document.getElementById('searchInput2');
                        var filter = input.value.toUpperCase();
                        var users = document.querySelectorAll('.msg');

                        users.forEach(function(user) {
                            var username = user.querySelector('.msg-detail a').textContent.toUpperCase();
                            if (username.indexOf(filter) > -1) {
                                user.style.display = '';
                            } else {
                                user.style.display = 'none';
                            }
                        });
                    }

                    // Ajouter un écouteur d'événement à l'entrée de recherche
                    document.getElementById('searchInput2').addEventListener('input', filterUsers);
                </script>




            </div>
            <div class="user-settings">
                <!-- Icônes de paramètres utilisateur ici -->
            </div>
        </div>
        <div class="wrapper">
            <div class="conversation-area">


                <?php foreach ($utilisateurs as $user) : ?>
                    <div class="msg" data-userid="<?= $user['iduser'] ?>">
                        <img class="msg-profile" src="image2.png" alt="" data-userid="<?= $user['iduser'] ?>" />
                        <div class="msg-detail">
                            <a href="?idUser=<?= $user['iduser'] ?>"><?= htmlspecialchars($user['login']) ?></a>
                            <?php

                            // Récupération du dernier message et de l'heure
                            $lastMessage = getLastMessage($userId, $user['iduser'], $conn);
                            if ($lastMessage) {
                                echo "<div class='msg-content'>";
                                echo "<span class='msg-message'>" . htmlspecialchars($lastMessage['message_text']) . "</span>";
                                echo "<span class='msg-date'>" . $lastMessage['timestamp'] . "</span>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button class="add">back</button>
                <div class="overlay"></div>


                <script>
                    document.querySelector('.add').addEventListener('click', function() {
                        window.location.href = '../../filieres.php';
                    });
                </script>

            </div>
            <div class="chat-area">
                <div class="chat-area-header">
                    <div class="chat-area-title">>Conversation avec <?= htmlspecialchars($selectedUser['login']) ?></div>
                    <div class="chat-area-group">
                        <!-- Ici, vous pouvez afficher des informations sur le groupe -->
                    </div>
                </div>
                <style>

                </style>

                <!-- Dans la section chat-area-main -->
                <div>
                    <div>
                        <?php if ($selectedUserId && isset($messages)) : ?>
                            <h2>Conversation avec <?= htmlspecialchars($selectedUser['login']) ?></h2>
                            <ul>
                                <div class="chat-messages">
                                    <ul class="messages">
                                        <?php foreach ($messages as $message) : ?>
                                            <li class="message <?= ($message['sender_id'] == $userId) ? 'outgoing' : 'incoming' ?>">
                                                <div class="message-content"><?= htmlspecialchars($message['message_text']) ?></div>
                                                <?php if (!empty($message['image_path'])) : ?>
                                                    <img src="<?= $message['image_path'] ?>" alt="Image">
                                                <?php endif; ?>
                                                <?php if (!empty($message['file_path'])) : ?>
                                                    <div class="file">
                                                        <?php


                                                        $fileIcon = getFileIcon($message['file_path']); ?>
                                                        <img style='width:20px;height:20px' src="<?= $fileIcon ?>">
                                                        <a href="<?= $message['file_path'] ?>" target="_blank"><?= basename($message['file_path']) ?></a>

                                                    </div>
                                                <?php endif; ?>
                                                <div class="message-time"><?= $message['timestamp'] ?></div>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="chat-area-footer">
                        <form action="repondre.php" method="post" class="message-form" enctype="multipart/form-data">
                            <input type="hidden" name="receiverId" value="<?= htmlspecialchars($selectedUserId) ?>">
                            <input type="text" name="replyMessage" placeholder="Entrez votre message ici">
                            <input type="file" accept="image/*" name="photo" id="photo" style="display:none;">
                            <label for="photo">
                                <img src="fichiers-image.png" style="width: 30px; height: 30px; margin-left: 30px;" class="message-image" id="preview">
                            </label>



                            <input type="file" name="file" id="file" style="display:none;">
                            <label for="file">
                                <img src="ajouter-un-document.png" style="width: 30px; height: 30px; margin-left: 30px;" class="message-image" id="preview">

                            </label>


                            <button type="submit" style='margin-left:30px'>Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="detail-area">
                <div class="detail-area-header">
                    <div class="msg-profile group">
                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M12 2l10 6.5v7L12 22 2 15.5v-7L12 2zM12 22v-6.5" />
                            <path d="M22 8.5l-10 7-10-7" />
                            <path d="M2 15.5l10-7 10 7M12 2v6.5" />
                        </svg>
                    </div>
                    <div class="detail-title">desgin Group</div>
                    <div class="detail-subtitle">welcome in your conversetion</div>
                    <div class="detail-buttons">


                    </div>
                </div>
                <div class="detail-changes">
                    <input type="text" id="searchInput" placeholder="Search in Conversation">

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var searchInput = document.getElementById("searchInput");

                            searchInput.addEventListener("input", function() {
                                var searchTerm = this.value.trim().toLowerCase();
                                var messages = document.querySelectorAll(".message");

                                messages.forEach(function(message) {
                                    var messageText = message.textContent.toLowerCase();
                                    if (messageText.includes(searchTerm)) {
                                        message.style.display = "block"; // Afficher le message
                                    } else {
                                        message.style.display = "none"; // Masquer le message s'il ne correspond pas
                                    }
                                });
                            });
                        });
                    </script>

                    <div class="detail-change">
                        Change Color
                        <div class="colors">
                            <div class="color blue selected" data-color="blue"></div>
                            <div class="color purple" data-color="purple"></div>
                            <div class="color green" data-color="green"></div>
                            <div class="color orange" data-color="orange"></div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var colors = document.querySelectorAll(".color");
                            var selectedColor = localStorage.getItem("selectedColor");

                            if (selectedColor) {
                                var chatMessages = document.querySelectorAll(".message.incoming");
                                chatMessages.forEach(function(message) {
                                    message.style.backgroundColor = selectedColor;
                                });
                            }

                            colors.forEach(function(color) {
                                color.addEventListener("click", function() {
                                    selectedColor = this.dataset.color;
                                    var chatMessages = document.querySelectorAll(".message.incoming");
                                    chatMessages.forEach(function(message) {
                                        message.style.backgroundColor = selectedColor;
                                    });

                                    // Enregistrer la couleur sélectionnée dans le stockage local
                                    localStorage.setItem("selectedColor", selectedColor);
                                });
                            });
                        });
                    </script>



                </div>
                <div class="detail-photos">
                    <div class="detail-photo-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <path d="M21 15l-5-5L5 21" />
                        </svg>
                        Shared photos
                    </div>
                    <div class="detail-photo-grid">
                        <img src="https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2168&q=80" />
                        <img src="https://images.unsplash.com/photo-1516085216930-c93a002a8b01?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" />
                        <img src="https://images.unsplash.com/photo-1458819714733-e5ab3d536722?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=933&q=80" />
                        <img src="https://images.unsplash.com/photo-1520013817300-1f4c1cb245ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2287&q=80" />
                        <img src="https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2247&q=80" />
                        <img src="https://images.unsplash.com/photo-1559181567-c3190ca9959b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1300&q=80" />
                        <img src="https://images.unsplash.com/photo-1560393464-5c69a73c5770?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1301&q=80" />
                        <img src="https://images.unsplash.com/photo-1506619216599-9d16d0903dfd?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2249&q=80" />
                        <img src="https://images.unsplash.com/photo-1481349518771-20055b2a7b24?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2309&q=80" />

                        <img src="https://images.unsplash.com/photo-1473170611423-22489201d919?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2251&q=80" />
                        <img src="https://images.unsplash.com/photo-1579613832111-ac7dfcc7723f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80" />
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2189&q=80" />
                    </div>

                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var photos = document.querySelectorAll(".detail-photo-grid img");
                        var chatMessages = document.querySelectorAll(".chat-messages");
                        var savedImageUrl = localStorage.getItem("backgroundImage");

                        if (savedImageUrl) {
                            chatMessages.forEach(function(message) {
                                message.style.backgroundImage = "url('" + savedImageUrl + "')";
                                message.style.backgroundSize = "cover";
                                message.style.backgroundRepeat = "no-repeat";
                            });
                        }

                        photos.forEach(function(photo) {
                            photo.addEventListener("click", function() {
                                var imageUrl = this.src;
                                chatMessages.forEach(function(message) {
                                    message.style.backgroundImage = "url('" + imageUrl + "')";
                                    message.style.backgroundSize = "cover";
                                    message.style.backgroundRepeat = "no-repeat";
                                    // Sauvegarder l'URL de l'image sélectionnée dans le stockage local
                                    localStorage.setItem("backgroundImage", imageUrl);
                                });
                            });
                        });
                    });
                </script>




                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Lorsque l'utilisateur clique sur un utilisateur
                        $('.msg').click(function() {
                            var userId = $(this).data('userid');
                            window.location.href = "index.php?idUser=" + userId;
                        });

                        function scrollToBottom() {
                            var chatArea = $('.chat-area');
                            chatArea.scrollTop(chatArea.prop("scrollHeight"));
                        }

                        // Appel de la fonction de défilement automatique au chargement de la page
                        scrollToBottom();

                        // Faire défiler vers le bas lorsqu'un nouveau message est envoyé
                        $("form").submit(function() {
                            // Utilisez une fonction de rappel pour garantir que le défilement se produit après l'envoi du message
                            setTimeout(scrollToBottom, 100); // Ajoutez un délai pour s'assurer que le message est rendu avant le défilement
                        });
                    });
                </script>
</body>

</html>

<style>
    body {
        background-color: #dfdfdf;
    }

    .message-content {
        color: #333;
    }

    /* Style de base pour les liens */
    a {
        color: black;
        /* Couleur du texte du lien */
        text-decoration: underline;
        /* Soulignement du lien */
    }

    ul,
    ol {
        list-style-type: none;
        /* Cela supprimera les puces des listes non ordonnées (ul) et ordonnées (ol) */
    }

    /* Style pour les liens avec la classe 'msg-username' */
    .msg-username {
        color: #333;
        /* Couleur du texte du lien */
        text-decoration: none;
        /* Aucun soulignement */
        font-weight: bold;
        /* Police en gras */
    }

    .msg-username:hover {
        text-decoration: underline;
        /* Soulignement au survol */
    }



    /* Dans votre fichier CSS */


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
        background-color: #0086ff;
        align-self: flex-start;
    }

    .outgoing {
        background-color: #e3e5e6;
        align-self: flex-end;
        margin-left: 200px;
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
        margin-right: 5px;
        /* Ajoute un espacement entre l'input et le bouton */
    }

    .message-form button {
        flex-shrink: 0;
        /* Empêche le bouton de rétrécir pour s'adapter */
    }
</style>