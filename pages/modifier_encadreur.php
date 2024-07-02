<?php
require_once "connexiondb.php";

if (isset($_POST['submit'])) {
    if (isset($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['numero_telephone'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $numero_telephone = $_POST['numero_telephone'];

        // Récupération du chemin du CV actuel
        $encadreur = $pdo->prepare("SELECT cv_path FROM encadreurs WHERE id = :id");
        $encadreur->bindParam(':id', $id);
        $encadreur->execute();
        $cv_path = $encadreur->fetchColumn();

        $new_cv_path = $cv_path; // Par défaut, utilise le chemin actuel

        if (isset($_FILES['cv_path']) && $_FILES['cv_path']['error'] === UPLOAD_ERR_OK) {
            // Si un nouveau fichier est téléchargé, met à jour le chemin
            $tmp_file = $_FILES['cv_path']['tmp_name'];
            $new_filename = $_FILES['cv_path']['name'];
            $new_file_path = "uploads/cv/" . $new_filename;

            if (move_uploaded_file($tmp_file, $new_file_path)) {
                $new_cv_path = $new_file_path;
            } else {
                echo "Erreur lors du déplacement du fichier téléchargé.";
                exit();
            }
        }

        $stmt = $pdo->prepare("UPDATE encadreurs SET nom = :nom, prenom = :prenom, numero_telephone = :numero_telephone, cv_path = :cv_path WHERE id = :id");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':numero_telephone', $numero_telephone);
        $stmt->bindParam(':cv_path', $new_cv_path);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: indexx.php#encadreurs");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de l'encadreur.";
        }
    } else {
        echo "Tous les champs du formulaire doivent être remplis.";
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM encadreurs WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $encadreur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$encadreur) {
        echo "L'encadreur avec l'ID spécifié n'existe pas.";
        exit();
    }
} else {
    echo "Identifiant de l'encadreur non spécifié.";
    exit();
}
?>
<h2 style="margin-left: 200px;color:#000000">Modifier Encadreur</h2>
<form method="post" action="modifier_encadreur.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $encadreur['id']; ?>">
    <div>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $encadreur['nom']; ?>" style="margin-left: 150px" required>
    </div>
    <div>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $encadreur['prenom']; ?>" style="margin-left: 127px" required>
    </div>
    <div>
        <label for="numero_telephone">Numéro de téléphone:</label>
        <input type="text" id="numero_telephone" name="numero_telephone" value="<?php echo $encadreur['numero_telephone']; ?>" style="margin-left: 15px" required>
    </div>
    <div>
        <label for="cv_path">Chemin du CV:</label>
        <input type="file" id="cv_path" name="cv_path" accept=".pdf,.doc,.docx" style="margin-left: 200px">
    </div>
    <button type="submit" name="submit">Enregistrer</button>
</form>