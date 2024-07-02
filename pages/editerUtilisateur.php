<?php
    require_once('identifier.php');
    require_once('connexiondb.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $requete = "SELECT * FROM utilisateur WHERE iduser = ?";
    $resultat = $pdo->prepare($requete);
    $resultat->execute([$id]);
    $utilisateur = $resultat->fetch();
    $login = isset($utilisateur['login']) ? $utilisateur['login'] : "";
    $email = isset($utilisateur['email']) ? $utilisateur['email'] : "";

?>



<!DOCTYPE html>
<html lang="en">

  <head>

  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>editer utilisateur</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
     <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  </head>

<body>

  <!-- Sub Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">
          
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a href="menu.html" class="logo">
                                WeDo Consult
                            </a>
                        </div>
                        <ul class="nav">
                            <li><a href="../index.php" class="scroll-to-section">Gestion des stagiaires</a></li>
                            <li><a href="stagiaires.php" class="scroll-to-section">Les Stagiaires</a></li>
                            <li><a href="../pages/filieres.php#categorySelect">Les Filières</a></li>

                    

                            <li>
                              <!--pour recuperer utilisteur qui login-->
                                <a href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>">
                                    <i class="fa fa-user-circle-o"></i>
                                    <?php echo ' ' . $_SESSION['user']['login']?>
                                </a>
                            </li>
                            <li>
                                <a href="tache.php">
                                    <i class="scroll-to-section"></i>
                                    les taches
                                </a>
                            </li>
                            <li>
                               <!--pour sedeconnection pour logout-->
                                <a href="seDeconnecter.php">
                                    <i class="scroll-to-section"></i>
                                    Déconnecter
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
  
            
          
              
  <section class="section main-banner" id="top" data-section="section1"  >
     
     <img src="./assets/images/meetings-bg.jpg" alt="" />
 

 <div class="video-overlay header-text" style="margin-top: 70px;">
     <div class="container">
       <div class="row">
         <div class="col-lg-12">
           <div class="caption">
               
           <section class="contact-us" id="contact" style="margin-bottom: 500px;">
<div class="container">
 <div class="row">
   <div class="col-lg-9 align-self-center" style="margin-top: 100px;">
     <div class="row">
       <div class="col-lg-12">
         <form id="contact" action="updateUtilisateur2.php" class="form" method="post">
           <div class="row">
             <div class="col-lg-12">
               <h2>Edition de l'utilisateur </h2>
             </div>
             <div class="col-lg-4">
               <fieldset>
               <input type="hidden" name="iduser" class="form-control" value="<?php echo $id ?>"/>
                 
               </fieldset>
             </div>
             <div class="col-lg-4">
               <fieldset>
               <input type="text" name="login" placeholder="Login" class="form-control" value="<?php echo $login ?>"/>
             </fieldset>
             </div>
             <div class="col-lg-4">
               <fieldset>
               <input type="email" name="email" placeholder="email" class="form-control"
                              value="<?php echo $email ?>"/>
               </fieldset>
             </div>
             <div class="col-lg-12">
               <fieldset>
                 <textarea name="message" type="text" class="form-control" id="message" placeholder="YOUR MESSAGE..." ></textarea>
               </fieldset>
             </div>
             <div class="col-lg-12">
               <fieldset>
                 <button type="submit" id="form-submit" class="button">enregistrer</button>
                 <a href="rapport/index.php" style="color: white;"><button>Upload a rapport</a></button>
               </fieldset>
             </div>
           </div>
           <a href="editPwd.php" style="color: black;">Changer le mot de passe</a>
         </form>
       </div>
     </div>
   </div>
   <div class="col-lg-3" style="margin-top: 100px;">
     <div class="right-info">
       <ul>
         <li>
           <h6>telephone</h6>
           <span>+ 21672393679</span>
         </li>
         <li>
           <h6>Email</h6>
           <span>contact@wedo-consult.com</span>
         </li>
         <li>
           <h6>Addresse</h6>
           <span>4ème étage, Bureau D2 Rue de la république, Grombalia, Tunisie, Grombalia, Nabeul</span>
         </li>
         <li>
           <h6>linkedin</h6>
           <span>WeDo Consult</span>
         </li>
       </ul>
     </div>
   </div>
 </div>
</div>

</section>
 </div>
 </div>
 </div>
 </div>
 </div>
</section>  
</body>
</html>











      