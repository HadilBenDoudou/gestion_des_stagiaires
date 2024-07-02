function close2() {
    document.getElementById("taches").style.display = "none"; // Masquer la modal avec l'identifiant "taches"
}
function tache() {
    document.getElementById("taches").style.display = "block";
}
  // Ajoutez un écouteur d'événements pour détecter le changement d'état de la case à cocher
  document.querySelectorAll('.task-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        // Si la case à cocher est cochée, ajoutez la classe 'completed-task' à la carte parent
        if (this.checked) {
            this.closest('.card').classList.add('completed-task');
        } else {
            // Sinon, retirez la classe 'completed-task'
            this.closest('.card').classList.remove('completed-task');
        }
    });
});
function ouvrirModalModifier(taskId) {
    var modalId = "modifierModal_" + taskId;
    document.getElementById(modalId).style.display = "block";
}

function modifierTache(taskId) {
    // Récupérer les données du formulaire
    var titre = document.getElementById('titre_' + taskId).value;
    var description = document.getElementById('description_' + taskId).value;
    var dateLimite = document.getElementById('date_limite_' + taskId).value;
    var etat = document.getElementById('etat_' + taskId).value;

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'modifier_tache.php',
        data: {
            taskId: taskId,
            titre: titre,
            description: description,
            date_limite: dateLimite,
            etat: etat
        },
        success: function(response) {
            // Afficher un message de succès ou effectuer d'autres actions si nécessaire
            alert('La tâche a été modifiée avec succès.');
            // Actualiser la page ou effectuer d'autres actions si nécessaire
            location.reload(); // Recharger la page après la modification de la tâche
        },
        error: function(xhr, status, error) {
            // Afficher un message d'erreur en cas d'échec de la requête AJAX
            console.error('Erreur lors de la modification de la tâche:', error);
            alert('Erreur lors de la modification de la tâche. Veuillez réessayer.');
        }
    });

}
function closeModal(taskId) {
    var modalId = "modifierModal_" + taskId;
    document.getElementById(modalId).style.display = "none";
}
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.task-checkbox');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const cardBody = this.parentNode;
            const cardTitle = cardBody.querySelector('.card-title');
            const cardTexts = cardBody.querySelectorAll('.card-text');
            
            if (this.checked) {
                cardTitle.classList.add('completed');
                cardTexts.forEach(function(cardText) {
                    cardText.classList.add('completed');
                });
            } else {
                cardTitle.classList.remove('completed');
                cardTexts.forEach(function(cardText) {
                    cardText.classList.remove('completed');
                });
            }
        });
    });
});
