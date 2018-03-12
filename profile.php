<?php
//démarrage de session
session_start();
//connection à la bd
try {
  //$bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');//localhost/linux
  //$bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'root');//localhost/mac
  $bd = new PDO('mysql:host=localhost;dbname=id4745934_chat;charset=utf8', 'id4745934_ludovic', 'user@');//webhost
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
//Quand il y a session, pas de blanc avant php?
//sanitization
function sanitize($key, $filter=FILTER_SANITIZE_STRING){
  $sanitized_variable = null;
  if(isset($_POST['modif_pseudo']) OR isset($_POST['modif_mail']) OR isset($_POST['modif_password']) OR isset($_POST['save']) OR isset ($_POST['return_chat']) OR isset($_POST['logout'])){
    if(is_array($key)){ // si la valeur est un tableau...
      $sanitized_variable = filter_var_array($key, $filter);
    }
    else { // sinon ...
      $sanitized_variable = filter_var($key, $filter);
    }
  }
  return $sanitized_variable;
}
if (isset($_POST['logout'])) {//si on appuie sur le bouton pour se déconnecter
  // On détruit les variables de notre session
  session_unset ();

  // On détruit notre session
  session_destroy ();

  // On redirige le visiteur vers la page d'accueil
  header ('location: login.php');
}
if (isset($_POST['return_chat'])) {
  header('location:index.php');
}
$id_profile=$bd->query("SELECT id, pseudo, email FROM users WHERE pseudo='".$_SESSION['login']."'");
$id_profile_fetch=$id_profile->fetch();
$new_pseudo=sanitize($_POST['modif_pseudo']);
$new_email=sanitize($_POST['modif_mail'], FILTER_SANITIZE_EMAIL);
$new_password=sanitize($_POST['modif_password']);
//if (isset($_POST['save']) AND !empty($_POST['modif_pseudo'])) {
  //$pseudo_update=$bd->query("UPDATE users SET pseudo=$new_pseudo WHERE pseudo='".$id_profile_fetch['pseudo']."'");
  //var_dump($pseudo_update);
//}
//if (isset($_POST['save']) and !empty($_POST['modif_mail'])) {
  //$update_mail=$bd->query("UPDATE users SET email=".$_POST['modif_mail']."' WHERE email=$id_users_fetch['email'] ");
//}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="profile-style.css">
  <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
  <title><?php echo $_SESSION['login']; ?></title>
</head>
<body>
  <header class="header">
    <h1><i class="fas fa-rocket">Bienvenue sur Fuzee</i></h1>
    <nav>
      <hr>
      <ul class="title">
        <li class="title"><b>Le nouveau media rapide,sécurisé et gratuit</b></li>
      </ul>
      <ul class="nav">
        <li class="nav">About us</li>
        <li class="nav">Privacy</li>
        <li class="nav">FAQ</li>
        <li class="nav">Help</li>
        <li class="nav">Getting started</li>
      </ul>
    </nav>
  </header>
  <br>
  <hr>
  <section class="infos">
    <section class="image">
      <?php
      if ($_SESSION['login']=="Lorn@") {
        echo '<img src="img_test.jpg" alt="image">';
      }elseif ($_SESSION['login']=="Camille-kaze") {
        echo '<img src="Camille-kaze.jpg" alt="Camille-kaze">';
      }elseif ($_SESSION['login']=="Laurie2411") {
        echo '<img src="Laurie.jpg" alt="Laurie2411">';
      }elseif ($_SESSION['login']=="ludovic2411") {
        echo '<img src="Ludovic2411.jpg" alt="ludovic2411">';
      }
      else {
        echo '<i class="fas fa-rocket"></i>';
      }
      ?>
    </section>
    <section class="infos_texte">
      <ul>
        <li>Informations personnelles</li>
        <li>Nom d'utilisateur: <?php echo $id_profile_fetch['pseudo']; ?></li>
        <li>Email: <?php echo $id_profile_fetch['email']; ?></li>
      </ul>
    </section>
<section class="modif_données">
  <h2>Vous pouvez changer vos données personnelles</h2>
<form class="" action="profile.php" method="post">
<input type="text" name="modif_pseudo" placeholder="entrez votre nouveau mnom d'utilisateur"value=""><br>
<input type="email" name="modif_mail" placeholder="entrez votre nouvelle adresse email" value=""><br>
<input type="password" name="modif_password" placeholder="entrez votre nouveau mot de passe" value=""><br>
<input type="submit" name="save" value="enregistrer">
<input type="submit" name="logout" value="Se déconnecter">
<input type="submit" name="return_chat" value="retourner dans le chat">
</form>
</section>
</section>
<hr>
<footer class="footer">
  <ul class="col-1">
    <li><strong>Generals</strong></li>
    <li>About us</li>
    <li>Privacy</li>
    <li>FAQ</li>
    <li>Help</li>
    <li>Getting started</li>
  </ul>
  <ul class="col-2">
    <li><strong>Fuzee for business</strong></li>
    <li>B2B</li>
    <li>Advertise</li>
  </ul>
  <ul class="col-3">
    <li><strong>Careers</strong></li>
    <li>Jobs</li>
    <li>Working for Fuzee</li>
  </ul>
</footer>
</body>
</html>
