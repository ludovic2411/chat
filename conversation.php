<?php
// On démarre la session (ceci est indispensable dans toutes les pages de notre section membre)
session_start ();
//connection à la db
try {
  $bd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'user');
} catch (Exception $e) {
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
//récupération
//on sélectionne les messages à afficher
$chat=$bd->query("SELECT message.id,pseudo_message, message, date_message FROM message JOIN users ON message.id_users=users.id order by message.id ");
$chat_fecth=$chat->fetchAll();//fecth
foreach ($chat_fecth as $chat_log) {//on récupère dans une boucle pour récupèrer et afficher plusieurs messages...
  $chat_pseudo=$chat_log['pseudo_message'];
  $chat_blabla=$chat_log['message'];
  $chat_date=$chat_log['date_message'];
   echo "<div class='chat'><i class='fab fa-rocketchat'>$chat_pseudo:<br>$chat_blabla(message envoyé le:$chat_date)</i></div><br/>";
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <title>chatroom</title>
  </head>
  <body>

  </body>
</html>
