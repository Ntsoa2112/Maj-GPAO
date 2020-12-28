<?php

include_once './PHPMailer-master/class.phpmailer.php';
$q1 = "";
$q2 = "";
$q3 = "";
$q4 = "";
$q5 = "";
$recommendation = "";
$suggestion = "";

if (isset($_POST['q1'])) {
    $q1 = $_POST['q1'];
}
if (isset($_POST['q2'])) {
    $q2 = $_POST['q2'];
}
if (isset($_POST['q3'])) {
    $q3 = $_POST['q3'];
}
if (isset($_POST['q4'])) {
    $q4 = $_POST['q4'];
}
if (isset($_POST['q5'])) {
    $q5 = $_POST['q5'];
}
if (isset($_POST['recommendation'])) {
    $recommendation = $_POST['recommendation'];
}
if (isset($_POST['suggestion'])) {
    $suggestion = $_POST['suggestion'];
}

echo "$q1.$q2.$q3.$q4.$q5.$recommendation.$suggestion";
//initialisation de l'envoi mail
ini_set("SMTP","ns0.ovh.net");
mail('dev@inovcom.fr', 'Suggestion', $suggestion, null,'dev@inovcom.fr');

?>
