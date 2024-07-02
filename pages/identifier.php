 <?php
    //ce code vérifie si l'utilisateur est connecté en vérifiant s'il existe une variable de session appelée 'user'. S'il n'est pas connecté, il redirige l'utilisateur vers la page de connexion
    session_start();

    if (!isset($_SESSION['user'])) {
        header('location:login.php');
        exit();
    }


    ?>
