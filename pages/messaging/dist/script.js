// Récupérer tous les éléments avec la classe "msg-username"
const userElements = document.querySelectorAll('.msg-username');

// Parcourir chaque élément utilisateur
userElements.forEach(userElement => {
    // Ajouter un écouteur d'événements au clic sur chaque élément utilisateur
    userElement.addEventListener('click', function() {
        // Récupérer le nom d'utilisateur à partir du texte de l'élément cliqué
        const username = userElement.textContent.trim();

        // Faire une requête AJAX pour récupérer les messages de l'utilisateur
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Convertir la réponse JSON en objet JavaScript
                    const messages = JSON.parse(xhr.responseText);
                    
                    // Mettre à jour la zone de conversation avec les messages récupérés
                    const conversationArea = document.querySelector('.conversation-area');
                    conversationArea.innerHTML = ''; // Effacer le contenu précédent
                    messages.forEach(message => {
                        const msgElement = document.createElement('div');
                        msgElement.classList.add('msg');
                        msgElement.innerHTML = `
                            <img class="msg-profile" src="image2.png" alt="" />
                            <div class="msg-detail">
                                <div class="msg-username">${username}</div>
                                <div class="msg-content">
                                    <span class="msg-message">${message.message_text}</span>
                                </div>
                            </div>`;
                        conversationArea.appendChild(msgElement);
                    });
                } else {
                    console.error('Erreur lors de la récupération des messages');
                }
            }
        };
        xhr.open('GET', 'get_messages.php?username=' + encodeURIComponent(username), true);
        xhr.send();
    });
});
