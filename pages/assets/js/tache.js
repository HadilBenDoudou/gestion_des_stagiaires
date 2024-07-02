document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.form-check-input');
    
    checkboxes.forEach(function(checkbox) {
        // Charger l'état de la case à cocher depuis le stockage local
        const taskId = checkbox.id.replace('task_', ''); // Récupérer l'ID de la tâche
        const isChecked = localStorage.getItem('task_' + taskId) === 'true';
        checkbox.checked = isChecked;
        
        // Ajouter un écouteur d'événements sur le changement de la case à cocher
        checkbox.addEventListener('change', function() {
            // Mettre à jour l'état de la case à cocher dans le stockage local
            const taskId = this.id.replace('task_', ''); // Récupérer l'ID de la tâche
            localStorage.setItem('task_' + taskId, this.checked);
            
            // Appliquer le style de la ligne de travers en fonction de l'état de la case à cocher
            updateTaskStyle(this);
        });
        
        // Appliquer le style de la ligne de travers initialement
        updateTaskStyle(checkbox);
    });
    
    // Fonction pour mettre à jour le style de la tâche en fonction de l'état de la case à cocher
    function updateTaskStyle(checkbox) {
        const cardBody = checkbox.closest('.card-body'); // Trouver l'élément parent de la case à cocher
        const cardTitle = cardBody.querySelector('.card-title'); // Récupérer le titre de la carte
        
        if (checkbox.checked) {
            cardTitle.style.textDecoration = 'line-through';
        } else {
            cardTitle.style.textDecoration = 'none';
        }
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.form-check-input');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const taskId = this.id.replace('task_', '');
            const etat = this.checked ? 'Terminée' : 'En cours'; // Modifier selon votre structure de base de données
            
            // Envoyer une requête AJAX pour mettre à jour l'état de la tâche dans la base de données
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_task_status.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('État de la tâche mis à jour avec succès');
                } else {
                    console.error('Erreur lors de la mise à jour de l\'état de la tâche :', response.message);
                }
            };
            xhr.send('task_id=' + encodeURIComponent(taskId) + '&etat=' + encodeURIComponent(etat));
        });
    });
});
