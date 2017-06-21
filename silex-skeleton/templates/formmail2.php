<?php

//Renvoie du mail de contact pour l'offre BtoB vers le mail des fleursdici (pour le moment mon mail à changer)
//Il faut tester en ligne et non en local !
$T0 = "tanguy.pichavant@hotmail.com";
$h = "From: " . $TO; 

$message = ""; 

while (list($key, $val) = each($HTTP_POST_VARS)) { 
$message .= "$key : $val\n"; 
} 

mail($TO, $subject, $message, $h);

Header("Location: contact.html.twig"); 

?>