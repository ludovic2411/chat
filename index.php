<?php
// On démarre la session (ceci est indispensable dans toutes les pages de notre section membre)
session_start ();
// On récupère nos variables de session
if (isset($session['login']) AND isset($session['password'])) {
  //test
  // echo $session['login'];
  // echo$session['password'];
}
if (isset($_POST['logout'])) {//si on appuie sur le bouton pour se déconnecter
  // On détruit les variables de notre session
session_unset ();

// On détruit notre session
session_destroy ();

// On redirige le visiteur vers la page d'accueil
header ('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="index-style.css">
  <title>Welcome in the chat</title>
</head>
<body>
  <main>
    <form class="logout_form" action="index.php" method="post">
      <input type="submit" name="logout" value="Se déconnecter">
    </form>
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
        <form class="chat" action="index.php" method="post">
          <textarea name="message" rows="6" cols="80"></textarea>
          <input type="submit" name="send" value="Envoyer">
          <input type="reset" name="reset" value="Effacer">
          <!-- <form  action="index.php" method="post">
          <textarea name="message" rows="8" cols="80"></textarea>
          <input type="submit" name="submit" value="Envoyer">
          <input type="reset" name="reset" value="Effacer">
        </form>
      -->
      </form>
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
