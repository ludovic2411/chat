

<?php

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
  $bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'root');
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
if (isset($_POST['submit_register'])) {//Si on appuie sur le bouton envoyer...
  $nom=sanitize($_POST['name']);//on récupère le nom...
  $email=sanitize($_POST['email']); //On récupère le mail
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
    header ('location: index.php');
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
  <title>Login</title>
</head>
<body>
  <h1>Bienvenue</h1>
  <h2>Veuillez introduire vos coordonnées<br>
    avant de rejoindre le chat</h2>
    <form class="register" action="login.php" method="post">
      <input type="text" name="name" value="" placeholder="introduisez votre pseudo" required><br>
      <input type="text" name="email" value="" placeholder="mailexemple@mail.com" required><br>
      <input type="password" name="password" value="" placeholder="choisissez un mot de passe" required><br>
      <input type="submit" name="submit_register" value="Envoyer">
      <input type="reset" name="reset_register" value="Annuler">
    </form>
<h3>Energistré?</h3>
<a href="http://localhost/chat/login.php">Connectez vous</a>
  <h1>Connectez-vous</h1>
  <h2>Entrez votre nom d'utilisateur <br>
    et votre mot de passe</h2>
    <form class="" action="login.php" method="post">
      <input type="text" name="name_login" placeholder="inscrivez votre nom d'utilisateur" required value=""><br>
      <input type="password" name="password_login"  placeholder="inscrivez votre mot de passe"required value=""><br>
      <input type="submit" name="submit_login" value="Connection">
      <input type="reset" name="reset_login" value="Annuler">
    </form>
  </body>
  </html>
