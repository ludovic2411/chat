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
$chat=$bd("SELECT pseudo, message FROM message");
 ?>
