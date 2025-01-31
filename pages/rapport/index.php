<?php
// Inclusion des fichiers nécessaires
require_once('../identifier.php'); // Fichier pour vérifier l'authentification de l'utilisateur
require_once('../connexiondb.php'); // Fichier pour établir la connexion PDO à la base de données

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Vérifiez si le fichier a été correctement téléchargé et s'il s'agit d'un fichier PDF
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK && $_FILES['file']['type'] === 'application/pdf') {
        // Récupérez le nom du fichier envoyé via le formulaire
        $rapport = $_FILES['file']['name']; // Nom du fichier téléchargé

        // Récupérer l'identifiant de l'utilisateur à partir de la session
        $idUtilisateur = $_SESSION['user']['iduser'];

        // Configuration de la connexion à la base de données (utilisez les informations de connexion PDO)
        $dsn = 'mysql:host=localhost;dbname=gestion_stag;charset=utf8';
        $utilisateur = 'root';
        $mot_de_passe = '';

        // Tentative de connexion à la base de données avec PDO
        try {
            // Création d'une instance de la classe PDO
            $pdo = new PDO($dsn, $utilisateur, $mot_de_passe);

            // Définir le mode d'erreur PDO sur Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si l'utilisateur a déjà ajouté un rapport
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE iduser = :idUtilisateur");
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);
            $stmt->execute();
            $existingRapport = $stmt->fetch();

            if ($existingRapport) {
                // Si un rapport existe déjà pour cet utilisateur, mettre à jour le rapport existant
                $stmt = $pdo->prepare("UPDATE utilisateur SET rapport=:rapport WHERE iduser = :idUtilisateur");
            } else {
                // Sinon, insérer un nouveau rapport
                $stmt = $pdo->prepare("INSERT INTO utilisateur (rapport, iduser) VALUES (:rapport, :idUtilisateur)");
            }

            // Liaison des paramètres (liaison des valeurs aux paramètres nommés)
            $stmt->bindParam(':rapport', $rapport);
            $stmt->bindParam(':idUtilisateur', $idUtilisateur);

            // Exécution de la requête préparée
            $stmt->execute();

            // Déplacement du fichier téléchargé vers le dossier de destination
            $folder = "../pdf/";
            $file_loc = $_FILES['file']['tmp_name'];
            $final_file = $folder . $_FILES['file']['name'];
            move_uploaded_file($file_loc, $final_file);

            // Affichage d'une alerte JavaScript pour informer l'utilisateur que le rapport a été ajouté avec succès
            echo "<script>alert('Rapport ajouté avec succès dans la base de données.');</script>";
            // Redirection vers la page editerUtilisateur.php
            echo "<script>window.location = '../editerUtilisateur.php';</script>";

        } catch (PDOException $e) {
            // Capture d'exception en cas d'erreur lors de la connexion à la base de données
            echo "<script>alert('Erreur lors de la connexion à la base de données : " . $e->getMessage() . "');</script>";
            // Redirection vers la page editerUtilisateur.php
            echo "<script>window.location = '../editerUtilisateur.php';</script>";
        }
    } else {
        // Affichage d'une alerte JavaScript en cas d'erreur lors du téléchargement du fichier ou si ce n'est pas un fichier PDF
        echo "<script>alert('Veuillez sélectionner un fichier PDF.');</script>";
        // Redirection vers la page editerUtilisateur.php
        echo "<script>window.location = '../editerUtilisateur.php';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - File upload</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="modal">
	<div class="modal-header">
		<div class="modal-logo">
			<span class="logo-circle">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="419.116" viewBox="0 0 512 419.116">
					<defs>
						<clipPath id="clip-folder-new">
							<rect width="512" height="419.116" />
						</clipPath>
					</defs>
					<g id="folder-new" clip-path="url(#clip-folder-new)">
						<path id="Union_1" data-name="Union 1" d="M16.991,419.116A16.989,16.989,0,0,1,0,402.125V16.991A16.989,16.989,0,0,1,16.991,0H146.124a17,17,0,0,1,10.342,3.513L227.217,57.77H437.805A16.989,16.989,0,0,1,454.8,74.761v53.244h40.213A16.992,16.992,0,0,1,511.6,148.657L454.966,405.222a17,17,0,0,1-16.6,13.332H410.053v.562ZM63.06,384.573H424.722L473.86,161.988H112.2Z" fill="var(--c-action-primary)" stroke="" stroke-width="1" />
					</g>
				</svg>
			</span>
		</div>
		<button class="btn-close"><a href="../editerUtilisateur.php">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" fill="var(--c-text-secondary)"/></svg>
            </a>
        </button>
	</div>
	<div class="modal-body">
		<h2 class="modal-title">Upload a file pdf</h2>
		<p class="modal-description">Attach the file below</p>
		<button class="upload-area">
			<span class="upload-area-icon">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="340.531" height="419.116" viewBox="0 0 340.531 419.116">
  <g id="files-new" clip-path="url(#clip-files-new)">
    <path id="Union_2" data-name="Union 2" d="M-2904.708-8.885A39.292,39.292,0,0,1-2944-48.177V-388.708A39.292,39.292,0,0,1-2904.708-428h209.558a13.1,13.1,0,0,1,9.3,3.8l78.584,78.584a13.1,13.1,0,0,1,3.8,9.3V-48.177a39.292,39.292,0,0,1-39.292,39.292Zm-13.1-379.823V-48.177a13.1,13.1,0,0,0,13.1,13.1h261.947a13.1,13.1,0,0,0,13.1-13.1V-323.221h-52.39a26.2,26.2,0,0,1-26.194-26.195v-52.39h-196.46A13.1,13.1,0,0,0-2917.805-388.708Zm146.5,241.621a14.269,14.269,0,0,1-7.883-12.758v-19.113h-68.841c-7.869,0-7.87-47.619,0-47.619h68.842v-18.8a14.271,14.271,0,0,1,7.882-12.758,14.239,14.239,0,0,1,14.925,1.354l57.019,42.764c.242.185.328.485.555.671a13.9,13.9,0,0,1,2.751,3.292,14.57,14.57,0,0,1,.984,1.454,14.114,14.114,0,0,1,1.411,5.987,14.006,14.006,0,0,1-1.411,5.973,14.653,14.653,0,0,1-.984,1.468,13.9,13.9,0,0,1-2.751,3.293c-.228.2-.313.485-.555.671l-57.019,42.764a14.26,14.26,0,0,1-8.558,2.847A14.326,14.326,0,0,1-2771.3-147.087Z" transform="translate(2944 428)" fill="var(--c-action-primary)"/>
  </g>
</svg>
			</span>
			<form method="post" action="" enctype="multipart/form-data">
			<span class="upload-area-title">Drag file(s) here to upload.</span>
			<span class="upload-area-description">
				Alternatively, you can select a file by <br/><strong><input type="file" class="email" name="file" style="margin-top: 20px;color:gray;" /></strong>
			</span>
		</button>
	</div>
	<div class="modal-footer">
	<button type="submit" class="btn-secondary" name="submit">envoyer</button>
	<button class="btn-secondary"><a href="../editerUtilisateur.php" style="color: black;">Cancel</a></button>
		
    <br>
	</div>
</div>
</form>

<!-- partial -->
  
</body>
</html>
