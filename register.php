<?php
//sanitization
function sanitize($key, $filter=FILTER_SANITIZE_STRING){
  $sanitized_variable = null;
  if(isset($_POST['name']) OR isset ($_POST['email']) OR isset($_POST['password']) OR isset($_POST['submit_register'])){
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
  $bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}

if (isset($_POST['submit_register'])) {//Si on appuie sur le bouton envoyer...
  $nom=sanitize($_POST['name']);//on récupère le nom...
  $email=sanitize($_POST['email']); //On récupère le mail
  $password=sanitize($_POST['password']);//On récupère le pwd
  //insertion des données de l'user dans la table user...
  $user_data=$bd->query("INSERT INTO users(pseudo,email, password) VALUES ('".$nom."','".$email."', '".$password."') ");
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
</head>
<body>
  <h1>Bienvenue</h1>
  <h2>Veuillez introduire vos coordonnées<br>
    avant de rejoindre le chat</h2>
    <form class="register" action="register.php" method="post">
      <input type="text" name="name" value="" placeholder="introduisez votre pseudo" required><br>
      <input type="text" name="email" value="" placeholder="mailexemple@mail.com" required><br>
      <input type="password" name="password" value="" placeholder="choisissez un mot de passe" required><br>
      <input type="submit" name="submit_register" value="Envoyer">
      <input type="reset" name="reset_register" value="Annuler">
    </form>
<h3>Energistré?</h3>
<a href="http://localhost/chat/login.php">Connectez vous</a>
  </body>
  </html>
