<?php
$sender = isset($_GET['sender']) ? $_GET['sender'] : '';
$idUser = isset($_GET['idUser']) ? intval($_GET['idUser']) : null;

if ($idUser === null || $idUser <= 0) {
    die("ID utilisateur non valide.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['titre'], $_POST['description'], $_POST['etat'])) {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $date_limite = !empty($_POST['date_limite']) ? $_POST['date_limite'] : null;
            $etat = $_POST['etat'];

            $sql = "INSERT INTO taches (titre, description, date_limite, etat, id_utilisateur) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $date_limite, $etat, $idUser]);

            echo "<script>";
            echo "alert('La tâche a été ajoutée avec succès.');"; // Affiche une alerte une fois que la tâche est ajoutée avec succès
            echo "window.location.href = 'attribuerTache.php?idUser=$idUser&sender=$sender';"; // Redirection avec les paramètres sender et idUser
            echo "</script>";
        } else {
            echo "Veuillez remplir tous les champs obligatoires.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$query = $pdo->prepare("SELECT * FROM taches WHERE id_utilisateur = ?");
$query->execute([$idUser]);
$tasks = $query->fetchAll(PDO::FETCH_ASSOC);
