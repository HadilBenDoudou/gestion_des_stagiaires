
<?php
// Paramètres de connexion à la base de données (à remplir avec vos propres informations)
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_stag"; // Remplacez "votre_base_de_donnees" par le nom de votre base de données


    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Définition du mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification de la présence de l'ID de l'utilisateur dans l'URL
    if(isset($_GET['idUser'])) {
        $idUser = $_GET['idUser'];

        // Vérification si l'ID de l'utilisateur est valide
        if ($idUser) {
            // Préparation de la requête SQL
            $sql = "SELECT iduser, login, email FROM utilisateur WHERE iduser = :idUser";
            $stmt = $pdo->prepare($sql);
            // Liaison du paramètre :idUser avec la valeur de $idUser
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            // Exécution de la requête SQL
            $stmt->execute();

            // Vérification s'il y a des résultats
            if ($stmt->rowCount() > 0) {
                // Récupération des données
                $row = $stmt->fetch();
                $id = $row["iduser"];
                $login = $row["login"];
                $email = $row["email"];}}}
                // Affichage du formulaire avec les valeurs récupérées de la base de données
                ?>