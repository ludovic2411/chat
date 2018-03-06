<?php
//sanitization
function sanitize($key, $filter=FILTER_SANITIZE_STRING){
  $sanitized_variable = null;
  if(isset($_POST['name_login']) OR isset($_POST['password_login']) OR isset($_POST['submit_login'])){
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
$infos_valides=$bd->query("SELECT pseudo, password FROM users WHERE pseudo='".$_POST['name_login']."'"); //On déclare les pseudos déjà enregistrés dans la db
$infos_valides_fetch=$infos_valides->fetch();
// $login_valides="ludovic2411";
// $password_valides="zorglub69";
//on teste si nos variables sont définies
if (isset($_POST['name_login']) AND isset($_POST['password_login']) AND isset($_POST['submit_login'])) {
  //  on compare les logins introduits avec les données users dans la db...
  if ($infos_valides_fetch ['pseudo']==$_POST['name_login'] AND $infos_valides_fetch['password']==$_POST['password_login']) {
    //Si c'est bon on lance la session
    session_start();
    // on enregistre les paramètres de notre visiteur comme variables de session
    $session['login']=$_POST['name_login'];
    $session['password']=$_POST['password_login'];
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
