<?php
// On démarre la session (ceci est indispensable dans toutes les pages de notre section membre)
session_start ();
//Connection à la db...

try {
  //$bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');//localhost/linux
  //$bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'root');//localhost/mac
  $bd = new PDO('mysql:host=localhost;dbname=id4745934_chat;charset=utf8', 'id4745934_ludovic', 'user@');//webhost
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
//sanitization
function sanitize($key, $filter=FILTER_SANITIZE_STRING){
  $sanitized_variable = null;
  if(isset($_POST['message']) OR isset($_POST['send'])){
    if(is_array($key)){ // si la valeur est un tableau...
      $sanitized_variable = filter_var_array($key, $filter);
    }
    else { // sinon ...
      $sanitized_variable = filter_var($key, $filter);
    }
  }
  return $sanitized_variable;
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
$date_message=date("Y-m-d");//récuprèrer la date...
if (isset($_POST['send'])) {//Si on appuie sur "envoyer"
  $id_users=$bd->query("SELECT id, pseudo FROM users WHERE pseudo='".$_SESSION['login']."'");
  $id_users_fetch=$id_users->fetch();
  $clean_message=sanitize($_POST['message']);
  $message_sent=$bd->exec("INSERT INTO message(id_users, pseudo_message, message, date_message) VALUES('".$id_users_fetch['id']."','".$id_users_fetch['pseudo']."','".$clean_message."','".$date_message."')");//ON envoie le message dans la db avec sa date
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="index-style.css">
  <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
  <title>Welcome in the chat</title>
</head>
<body>
    <h1><i class="fas fa-rocket">Bienvenue sur Fuzee</i></h1>
    <header>
        <?php
            if (isset($_SESSION['login']) AND isset($_SESSION['password'])) {//Si la sessione existe...
              echo"<p style='color:LawnGreen' style='font-size:150%;'> '".$_SESSION['login']."'</p>";
              echo '<form class="logout_form" action="index.php" method="post">
              <input type="submit" name="logout" value="Se déconnecter">
              </form>'; //le form de déconnection apparaît
            }
            ?>
    </header>
  <main>
    <ul>
      <li class="item1">
        <?php
        if ($_SESSION['login']=="Lorn@") {
          echo '<a href="profile.php"><img src="img_test.jpg" alt="image"></a>';
        }elseif ($_SESSION['login']=="Camille-kaze") {
          echo '<a href="profile.php"><img src="Camille-kaze.jpg" alt="Camille-kaze"></a>';
        }elseif ($_SESSION['login']=="Laurie2411") {
          echo '<a href="profile.php"><img src="Laurie.jpg" alt="Laurie2411"></a>';
        }elseif ($_SESSION['login']=="ludovic2411") {
          echo '<a href="profile.php"><img src="Ludovic2411.jpg" alt="ludovic2411"></a>';
        }elseif (isset($_SESSION['login'])) {
          echo '<a href="profile.php"><i class="fas fa-rocket" style=c"olor:LawnGreen;""></i></a>';
        }
        else {
          echo '<i class="fas fa-rocket"></i>';
        }
         ?>
       </li>
      <li class="item2"><i class="fas fa-rocket"></i></li>
      <li class="item3"><i class="fas fa-rocket"></i></li>
      <li class="item4"><i class="fas fa-rocket"></i></li>
      <li class="item5"><i class="fas fa-rocket"></i></li>
      <li class="item6"><i class="fas fa-rocket"></i></li>
      <li class="item7"><i class="fas fa-rocket"></i></li>
      <li class="item8"><i class="fas fa-rocket"></i></li>
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
      <textarea name="message" rows="6" cols="80" autofocus></textarea>
      <input type="submit" name="send" value="Envoyer">
      <input type="reset" name="reset" value="Effacer">
      </form>';//le form du chat apparaît...
    }else{
      //echo '<a href="http://localhost:8888/chat/login.php">Connectez vous</a>'; //localhost
      echo '<a href="login.php">Connectez-vous</a>';
    }
    ?>
  </li>
  <li class="item14"><i class="fas fa-rocket"></i></li>
  <li class="item15"><i class="fas fa-rocket"></i></li>
  <li class="item16"><i class="fas fa-rocket"></i></li>
  <li class="message">
    <iframe src="conversation.php" width="650" height="650"></iframe>
  </li>
</ul>
</main>
</body>
</html>
