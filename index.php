<?php
// On démarre la session (ceci est indispensable dans toutes les pages de notre section membre)
session_start ();
//Connection à la db...

try {
  $bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
// On récupère nos variables de session

if (isset($_POST['logout'])) {//si on appuie sur le bouton pour se déconnecter
  // On détruit les variables de notre session
  session_unset ();

  // On détruit notre session
  session_destroy ();

  // On redirige le visiteur vers la page d'accueil
  header ('location: login.php');
}
echo "<p style='color:green;'> '".$_SESSION['login']."'</p>";
$date_message=date("Y-m-d");//récuprèrer la date...
if (isset($_POST['send'])) {//Si on appuie sur "envoyer"
  $id_users=$bd->query("SELECT id, pseudo FROM users WHERE pseudo='".$_SESSION['login']."'");
  $id_users_fetch=$id_users->fetch();
  echo $id_users_fetch['id'];
  $message_sent=$bd->exec("INSERT INTO message(id_users, pseudo_message, message, date_message) VALUES('".$id_users_fetch['id']."','".$id_users_fetch['pseudo']."','".$_POST['message']."','".$date_message."')");//ON envoie le message dans la db avec sa date
  echo $_POST['message'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="10">
  <link rel="stylesheet" href="index-style.css">
  <title>Welcome in the chat</title>
</head>
<body>
  <main>
    <?php
    if (isset($_SESSION['login']) AND isset($_SESSION['password'])) {//Si la sessione existe...
      echo '<form class="logout_form" action="index.php" method="post">
      <input type="submit" name="logout" value="Se déconnecter">
      </form>'; //le form de déconnection apparaît
    }
    ?>
    <ul>
      <li class="item1"></li>
      <li class="item2"></li>
      <li class="item3"></li>
      <li class="item4"></li>
      <li class="item5"></li>
      <li class="item6"></li>
      <li class="item7"></li>
      <li class="item8"></li>
      <li class="formulaire">
        <!--
        <form class="chat" action="index.php" method="post">
        <textarea name="message" rows="6" cols="80"></textarea>
        <input type="submit" name="send" value="Envoyer">
        <input type="reset" name="reset" value="Effacer">
      </form>
    -->
    <?php
    if (isset($_SESSION['login']) AND isset($_SESSION['password'])) {//si les variables de session existent..
      echo '<form class="chat" action="index.php" method="post">
      <textarea name="message" rows="6" cols="80"></textarea>
      <input type="submit" name="send" value="Envoyer">
      <input type="reset" name="reset" value="Effacer">
      </form>';//le form du chat apparaît...
    }else{
      echo '<a href="http://localhost/chat/login.php">Connectez vous</a>';
    }
    ?>
  </li>
  <li class="item14"></li>
  <li class="item15"></li>
  <li class="item16"></li>
  <li class="message">
    <iframe src="conversation.php" width="650" height="650"></iframe>
  </li>
</ul>
</main>
</body>
</html>
