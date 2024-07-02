<?php
// Paramètres de connexion à la base de données (à remplir avec vos propres informations)
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Définition du mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Quitter le script en cas d'échec de la connexion à la base de données
}

// Traitement pour l'ajout d'un encadreur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        // Récupère les autres données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $numero_telephone = $_POST['numero_telephone'];

        // Vérifier si le numéro de téléphone existe déjà dans la base de données
        $check_query = $pdo->prepare("SELECT COUNT(*) AS count FROM encadreurs WHERE numero_telephone = :numero_telephone");
        $check_query->bindParam(':numero_telephone', $numero_telephone);
        $check_query->execute();
        $result = $check_query->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo "<script>alert('Le numéro de téléphone est déjà utilisé. Veuillez en saisir un nouveau.'); window.location.href = 'indexx.php#encadreurs';</script>";
        } else {
            // Traitement pour télécharger le fichier CV
            $cv_file = $_FILES['cv'];
            $cv_file_name = $cv_file['name'];
            $cv_file_tmp = $cv_file['tmp_name'];
            $cv_file_path = "uploads/cv/" . $cv_file_name; // Chemin où le CV sera stocké sur le serveur

            // Déplacer le fichier téléchargé vers le répertoire de destination
            move_uploaded_file($cv_file_tmp, $cv_file_path);

            // Requête d'insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO encadreurs (nom, prenom, cv_path, numero_telephone) VALUES (:nom, :prenom, :cv_path, :numero_telephone)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':cv_path', $cv_file_path);
            $stmt->bindParam(':numero_telephone', $numero_telephone);

            // Exécute la requête
            $stmt->execute();

            // Rediriger vers indexx.php après l'ajout
            header("Location: indexx.php#encadreurs");
            exit();
        }
    }
}
