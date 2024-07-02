<?php
// Paramètres de connexion à la base de données (à remplir avec vos propres informations)
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : null;
try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Définition du mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $id = $_POST["id"];
        $login = $_POST["login"];
        $email = $_POST["email"];

        // Préparation de la requête SQL pour la mise à jour
        $sql = "UPDATE utilisateur SET login = :login, email = :email WHERE iduser = :id";
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        // Exécution de la requête
        $stmt->execute();

        echo "<script>alert('Utilisateur mis à jour avec succès.');</script>";
        // Rediriger vers la page indexx.php
        echo "<script>window.location = 'indexx.php?idUser=$id#contact&idUser=$idUser';</script>";
    } else {
        echo "<script>alert('Le formulaire n'a pas été soumis.');</script>";
        // Rediriger vers la page indexx.php
        echo "<script>window.location = 'indexx.php?idUser=<?php echo $idUser; ?>#contact';</script>";
    }
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    echo "Erreur de connexion : " . $e->getMessage();
}

// Fermeture de la connexion à la base de données
$pdo = null;
