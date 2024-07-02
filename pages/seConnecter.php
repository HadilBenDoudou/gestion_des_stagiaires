<?php
    session_start();
    require_once('connexiondb.php');
    
    $login=isset($_POST['login'])?$_POST['login']:"";
    
    $pwd=isset($_POST['pwd'])?$_POST['pwd']:"";

    $requete="select iduser,login,email,role,etat 
                from utilisateur where login='$login' 
                and pwd=MD5('$pwd')";
    
    $resultat=$pdo->query($requete);

    if($user=$resultat->fetch()){
        
       
        if($user['etat']==1){
            if ($user['role'] == 'VISITEUR') {
                $_SESSION['user']=$user;
            header('location:../index.php');
            } elseif ($user['role'] == 'ADMIN') {
                // Redirection vers la page protégée avec l'ID de l'utilisateur dans l'URL
                header('location:indexx.php?idUser=' . $user['iduser']);
                exit();
            }
          
            
        }else{
            
            $_SESSION['erreurLogin']="<strong>Erreur!!</strong> Votre compte est désactivé.<br> Veuillez contacter l'administrateur";
            header('location:login.php');
        }
    }else{
        $_SESSION['erreurLogin']="<strong>Erreur!!</strong> Login ou mot de passe incorrecte!!!";
        header('location:login.php');
    }

?>
