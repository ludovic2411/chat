<?php
//Quand il y a session, pas de blanc avant php?
//sanitization
function sanitize($key, $filter=FILTER_SANITIZE_STRING){
  $sanitized_variable = null;
  if(isset($_POST['name_login']) OR isset($_POST['password_login']) OR isset($_POST['submit_login']) OR isset($_POST['name']) OR isset ($_POST['email']) OR isset($_POST['password']) OR isset($_POST['submit_register'])){
    if(is_array($key)){ // si la valeur est un tableau...
      $sanitized_variable = filter_var_array($key, $filter);
    }
    else { // sinon ...
      $sanitized_variable = filter_var($key, $filter);
    }
  }
  return $sanitized_variable;
}
//Connection à la db...
try {
  //$bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'root');//localhostMac
  $bd = new PDO('mysql:host=localhost;dbname=id4745934_chat;charset=utf8', 'id4745934_ludovic', 'user@');//webhost
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
if (isset($_POST['submit_register'])) {//Si on appuie sur le bouton envoyer...
  $nom=sanitize($_POST['name']);//on récupère le nom...
  $email=sanitize($_POST['email'], FILTER_SANITIZE_EMAIL); //On récupère le mail
  $password=sanitize($_POST['password']);//On récupère le pwd
  $safe_password=password_hash($password, PASSWORD_DEFAULT);//on crypte le pwd
  //insertion des données de l'user dans la table user...
  $user_data=$bd->exec("INSERT INTO users(pseudo,email, password) VALUES ('".$nom."','".$email."', '".$safe_password."') ");
}
//Partie login

$infos_valides=$bd->query("SELECT pseudo, password FROM users WHERE pseudo='".$_POST['name_login']."'"); //On déclare les pseudos déjà enregistrés dans la db
$infos_valides_fetch=$infos_valides->fetch();
$password_verify=password_verify($_POST['password_login'],$infos_valides_fetch['password']);//on décrypte les pwd...
// $loginalides="ludovic2411";
// $password_valides="zorglub69";
//on teste si nos variables sont définies
if (isset($_POST['name_login']) AND isset($_POST['password_login']) AND isset($_POST['submit_login'])) {
  //  on compare les logins introduits avec les données users dans la db...
  if ($infos_valides_fetch ['pseudo']==$_POST['name_login'] AND $password_verify==$_POST['password_login']) {
    //Si c'est bon on lance la session
    session_start();
    // on enregistre les paramètres de notre visiteur comme variables de session
    $_SESSION['login']=$_POST['name_login'];// $_SESSION=variable superglobale =>enregistre la session dans index.php
    $_SESSION['password']=$_POST['password_login'];
    // on redirige notre visiteur vers une page de notre section membre...
    header ('Location: index.php');//headerlocalhost
      //header ('location:https://gat-x102a.000webhostapp.com/index.php');
  }else {//Si les logins ne sont pas valides, on redirige dit au visiteur qu'il doit recommencer...
    echo "Veuillez réintroduire correctement vos données d'utilisateurs";
    // echo $login_valides;
    // echo $password_valides;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="login-style.css">
  <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
  <title>Login</title>
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
  <section class="wrapper">
    <section class="register">
      <h2>Veuillez introduire <br> vos coordonnées<br>
        avant de rejoindre <br> le chat</h2>
        <form class="" action="login.php" method="post">
          <input class="name_register" type="text" name="name" value="" placeholder="introduisez votre pseudo" required><br>
          <input class="email_register" type="email" name="email" value="" placeholder="mailexemple@mail.com" required><br>
          <input class="password_register" type="password" name="password" value="" placeholder="choisissez un mot de passe" required><br>
          <input class="name_register_class" type="submit" name="submit_register" value="Envoyer">
          <input class="reset_register" type="reset" name="reset_register" value="Annuler">
        </form>
      </section>
      <section class="login">
        <h2>Enregistré?</h2>
        <h2>Connectez-vous</h2>
        <h3>Entrez votre nom d'utilisateur<br>
          et votre mot de passe</h3>
          <form action="login.php" method="post">
            <input class="name_login_class" type="text" name="name_login" placeholder="inscrivez votre nom d'utilisateur" required value=""><br>
            <input class="password_login" type="password" name="password_login"  placeholder="inscrivez votre mot de passe"required value=""><br>
            <input class="submit_login_class" type="submit" name="submit_login" value="Connection">
            <input class="reset_login" type="reset" name="reset_login" value="Annuler">
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
