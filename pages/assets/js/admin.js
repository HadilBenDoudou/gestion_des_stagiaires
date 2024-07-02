
function closeModal5() {
        var modal = document.getElementById('hadil5'); // Récupère l'élément modal par son ID
        modal.style.display = 'none'; // Cache la modal
    }

    // Récupère le bouton "close" par sa classe et ajoute un gestionnaire d'événements
    var closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        closeModal(); // Appelle la fonction closeModal pour fermer la modal
    });

       // Fonction pour ouvrir la modal avec l'ID du stagiaire
       function openModal6(idFiliere) {
        // Charger le contenu de la modal depuis un fichier séparé (editerStagiaire.php) en incluant l'ID du stagiaire
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Insérer le contenu de la modal dans le conteneur
                document.getElementById("modalContainer6").innerHTML = this.responseText;

                // Afficher la modal
                document.getElementById("hadil6").style.display = "block";
            }
        };
        xhttp.open("GET", "editf.php?id=" + idFiliere + '&idUser=<?php echo $sender; ?>', true);


        xhttp.send();
    }

    // Fonction pour fermer la modal
    function closeModal6() {
        var modal = document.getElementById('hadil6'); // Récupère l'élément modal par son ID
        modal.style.display = 'none'; // Cache la modal
    }

    // Récupère le bouton "close" par sa classe et ajoute un gestionnaire d'événements
    var closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        closeModal(); // Appelle la fonction closeModal pour fermer la modal
    });

    // Ajoutez ce script après la définition de votre boîte de dialogue modale 

       // Sélectionnez le bouton de fermeture
       var closeButton = document.querySelector('.close');

       // Sélectionnez la boîte de dialogue modale
       var modal = document.getElementById('myModal');
   
       // Si le bouton de fermeture est cliqué, masquez la boîte de dialogue modale
       closeButton.addEventListener('click', function() {
           modal.style.display = "none";
       });
   


         // Fonction pour afficher la boîte de dialogue modale de confirmation de suppression
    function confirmDelete(id) {
        var modal = document.getElementById('myModal');
        modal.style.display = "block";
        
        var confirmYesBtn = document.getElementById('confirmYes');
        var confirmNoBtn = document.getElementById('confirmNo');
      
       
        
        // Si l'utilisateur clique sur Oui, supprimer la filière
        confirmYesBtn.onclick = function() {
            modal.style.display = "none";
            deleteFiliere(id);
        }

        // Si l'utilisateur clique sur Non, fermer la boîte de dialogue modale
        confirmNoBtn.onclick = function() {
            modal.style.display = "none";
        }
      
      
    }

    // Fonction pour supprimer la filière via AJAX
    function deleteFiliere(id) {
        // Faire une requête AJAX pour supprimer la filière avec l'ID spécifié
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Actualiser la page ou effectuer toute autre action nécessaire après la suppression
                window.location.reload(); // Actualise la page après suppression
            }
        };
        xhttp.open("GET", "supf.php?id=" + id+'&idUser=<?php echo $sender; ?>', true);
        xhttp.send();
    }




    function searchFiliere() {
        // Récupérer la valeur de recherche
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("filiereTable");
        tr = table.getElementsByTagName("tr");

        // Parcourir toutes les lignes et cacher celles qui ne correspondent pas à la recherche
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // 1 correspond à l'index de la colonne du nom de la filière
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }




 
    function closeModal() {
            var modal = document.getElementById('hadil'); // Récupère l'élément modal par son ID
            modal.style.display = 'none'; // Cache la modal
        }

        // Récupère le bouton "close" par sa classe et ajoute un gestionnaire d'événements
        var closeButton = document.querySelector('.close');
        closeButton.addEventListener('click', function() {
            closeModal(); // Appelle la fonction closeModal pour fermer la modal
        });

               // Fonction pour ouvrir la modal avec l'ID du stagiaire
    

    // Fonction pour fermer la modal
    function closeModal1() {
        var modal = document.getElementById('hadil1'); // Récupère l'élément modal par son ID
        modal.style.display = 'none'; // Cache la modal
    }

    // Récupère le bouton "close" par sa classe et ajoute un gestionnaire d'événements
    var closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        closeModal(); // Appelle la fonction closeModal pour fermer la modal
    });


    