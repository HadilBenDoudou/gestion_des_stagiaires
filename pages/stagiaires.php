<?php
    require_once('identifier.php');
    
    require_once("connexiondb.php");
  
    $nomPrenom=isset($_GET['nomPrenom'])?$_GET['nomPrenom']:"";
    $idfiliere=isset($_GET['idfiliere'])?$_GET['idfiliere']:0;
    
    $size=isset($_GET['size'])?$_GET['size']:5;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;
    
    $requeteFiliere="select * from filiere";

    if($idfiliere==0){
        $requeteStagiaire="select idStagiaire,nom,prenom,nomFiliere,photo,civilite 
                from filiere as f,stagiaire as s
                where f.idFiliere=s.idFiliere
                and (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                order by idStagiaire
                limit $size
                offset $offset";
        
        $requeteCount="select count(*) countS from stagiaire
                where nom like '%$nomPrenom%' or prenom like '%$nomPrenom%'";
    }else{
         $requeteStagiaire="select idStagiaire,nom,prenom,nomFiliere,photo,civilite 
                from filiere as f,stagiaire as s
                where f.idFiliere=s.idFiliere
                and (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and f.idFiliere=$idfiliere
                 order by idStagiaire
                limit $size
                offset $offset";
        
        $requeteCount="select count(*) countS from stagiaire
                where (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and idFiliere=$idfiliere";
    }

    $resultatFiliere=$pdo->query($requeteFiliere);
    $resultatStagiaire=$pdo->query($requeteStagiaire);
    $resultatCount=$pdo->query($requeteCount);

    $tabCount=$resultatCount->fetch();
    $nbrStagiaire=$tabCount['countS'];
    $reste=$nbrStagiaire % $size;   
    if($reste===0) 
        $nbrPage=$nbrStagiaire/$size;   
    else
        $nbrPage=floor($nbrStagiaire/$size)+1;  
?>

<?php
    require_once('identifier.php');
    
    require_once("connexiondb.php");
  
    $nomPrenom=isset($_GET['nomPrenom'])?$_GET['nomPrenom']:"";
    $idfiliere=isset($_GET['idfiliere'])?$_GET['idfiliere']:0;
    
    $size=isset($_GET['size'])?$_GET['size']:5;
    $page=isset($_GET['page'])?$_GET['page']:1;
    $offset=($page-1)*$size;
    
    $requeteFiliere="select * from filiere";

    if($idfiliere==0){
        $requeteStagiaire="select idStagiaire,nom,prenom,nomFiliere,photo,civilite 
                from filiere as f,stagiaire as s
                where f.idFiliere=s.idFiliere
                and (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                order by idStagiaire
                limit $size
                offset $offset";
        
        $requeteCount="select count(*) countS from stagiaire
                where nom like '%$nomPrenom%' or prenom like '%$nomPrenom%'";
    }else{
         $requeteStagiaire="select idStagiaire,nom,prenom,nomFiliere,photo,civilite 
                from filiere as f,stagiaire as s
                where f.idFiliere=s.idFiliere
                and (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and f.idFiliere=$idfiliere
                 order by idStagiaire
                limit $size
                offset $offset";
        
        $requeteCount="select count(*) countS from stagiaire
                where (nom like '%$nomPrenom%' or prenom like '%$nomPrenom%')
                and idFiliere=$idfiliere";
    }

    $resultatFiliere=$pdo->query($requeteFiliere);
    $resultatStagiaire=$pdo->query($requeteStagiaire);
    $resultatCount=$pdo->query($requeteCount);

    $tabCount=$resultatCount->fetch();
    $nbrStagiaire=$tabCount['countS'];
    $reste=$nbrStagiaire % $size;   
    if($reste===0) 
        $nbrPage=$nbrStagiaire/$size;   
    else
        $nbrPage=floor($nbrStagiaire/$size)+1;  
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Template Mo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>les stagiaires</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="../pages/assets/css/stagiaire.css">
     <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


    <script src="../pages/assets/js/stagiaire.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-av5aX8tx3MUp3PagwLMUfLo5YHeer6PhuV4UeaVNqtHCVa9ASe+KDlNtMOqBDWd+dfBD8IqVD8VgazJ5EFXwWg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
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
  <!-- ***** Header Area End ***** -->

  <section class="heading-page header-text" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h6>bienvenus</h6>
          <h2>les stagiaires dans WeDo Consult</h2>
        </div>
      </div>
    </div>
  </section>
 

  <section class="meetings-page" id="meetings">
  <div class="container" >
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success margin-top-60">
                <div class="panel-heading" style="color:white;margin-left:400px ">Rechercher des stagiaires</div>
                <div class="panel-body">
                    <form method="get" action="stagiaires.php" class="form-inline">
                        <div class="form-group">
                        <input type="text" name="nomPrenom" placeholder="Nom et prénom" class="form-control custom-input" value="<?php echo $nomPrenom ?>" />

                        </div>
                        <label class="custom-label" for="idfiliere">Filière:</label>
                      
                        <select name="idfiliere" class="form-control custom-select" id="idfiliere" onchange="this.form.submit()">
 <option value="0">Toutes les filières</option>
                            <?php while ($filiere = $resultatFiliere->fetch()) { ?>
                                <option value="<?php echo $filiere['idFiliere'] ?>" <?php if ($filiere['idFiliere'] === $idfiliere) echo "selected" ?>>
                                    <?php echo $filiere['nomFiliere'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button   type="submit" class="btn btn-success custom-button">
                            <span class="btn" style="border-radius: 50px;"></span>Chercher...
                        </button>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

   <div class="col-lg-12" style="margin-left: 90px;">
    <div class="row grid" >
        <?php while($stagiaire = $resultatStagiaire->fetch()) { ?>
            <div class="col-lg-4 templatemo-item-col all soon" style="width: 434px;">
                <div class="meeting-item">
                    <div class="thumb">
                        <a href="editerStagiaire.php?idS=<?php echo $stagiaire['idStagiaire'] ?>">
                            <img src="../images/<?php echo $stagiaire['photo'] ?>" alt="">
                        </a>
                    </div>
                    <div class="down-content">
                        <a href="editerStagiaire.php?idS=<?php echo $stagiaire['idStagiaire'] ?>">
                            <h4><?php echo $stagiaire['nom'] . ' ' . $stagiaire['prenom'] ?></h4>
                        </a>
                        <p><?php echo $stagiaire['nomFiliere'] ?></p>
                       

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="col-lg-12">
    <div class="pagination">
        <ul>
            <?php for ($i = 1; $i <= $nbrPage; $i++) { ?>
                <li class="<?php if ($i == $page) echo 'active' ?>">
                    <a href="stagiaires.php?page=<?php echo $i; ?>&nomPrenom=<?php echo $nomPrenom ?>&idfiliere=<?php echo $idfiliere ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

  </section>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
   
</body>


  </body>

</html>
