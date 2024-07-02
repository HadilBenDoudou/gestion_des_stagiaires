<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stag";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'ID de la tâche et le nouvel état sont reçus
    if (isset($_POST['task_id']) && isset($_POST['etat'])) {
        $taskId = $_POST['task_id'];
        $etat = $_POST['etat']; // Changer ici

        // Préparer et exécuter la requête de mise à jour de l'état de la tâche dans la base de données
        $query = $pdo->prepare("UPDATE taches SET etat = ? WHERE id = ?"); // Changer ici
        $query->execute([$etat, $taskId]);

        // Envoyer une réponse JSON pour indiquer le succès de l'opération
        echo json_encode(['success' => true]);
    } else {
        // Envoyer une réponse JSON pour indiquer qu'il y a eu une erreur
        echo json_encode(['success' => false, 'message' => 'Missing task ID or etat']); // Changer ici
    }
} catch(PDOException $e) {
    // Envoyer une réponse JSON pour indiquer qu'il y a eu une erreur
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
