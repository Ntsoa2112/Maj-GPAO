<?php

include '../includes/fonctions.php';
$conn = openDb();

$query = "select current_date";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select current_time";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select current_timestamp";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select localtime";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select date_trunc('hour', timestamp '2001-02-16 20:38:40')";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select extract(hour from timestamp '2001-02-16 20:38:40')";
$res = queryOne($conn, $query);
echo '<br><b>Requête : </b>'.$query.'<br />';
echo $res.'<br />';

$query = "select now()";
$nowpg = queryOne($conn, $query);
echo '<br /><b>Requête : </b>'.$query.'<br />';
echo 'Postgres Now() ==>  '.$nowpg.'<br />';

echo '<br /><b>Fonctions créées : </b><br />';

$tmstPhp = pgTmst2tmst($nowpg);
echo '<br />Conversion Timestamp Postgres vers Timestamp PHP <br /> Timestamp PG : '.$nowpg.' ==> pgTmst2tmst ==> Timestamp PHP : '.$tmstPhp.'<br />';

$str2 = pgTmst2str("d/m/Y H:i:s", $nowpg);
echo '<br />Formattage Timestamp PG vers string PHP<br /> Timestamp PG : '.$nowpg.'==> pgTmst2str (format :"d/m/Y H:i:s") ==> String PHP : '.$str2.'<br />';

$tmstPg = phpTmst2tmst($tmstPhp);
echo '<br />Conversion Timestamp PHP vers Timestamp Postgres <br />Timestamp PHP : '.$tmstPhp.' ==> phpTmst2tmst ==> '.$tmstPg.'<br />';
// $query = "insert into tab_dates values(".phpTmst2tmst(1150400842)." - interval '1 day')";
// queryOne($conn, $query);

$str1 = date("d/m/Y H:i:s", $tmstPhp);
echo '<br />Formattage Timestamp PHP vers string<br />Timestamp PHP : '.$tmstPhp.' ==> date (format : "d/m/Y H:i:s") ==> '.$str1.'<br />';

$anniv = "15/06/1984 23:47:22";
$tmstPg = phpStr2tmstPg($anniv);
echo '<br />Formattage String PHP (formulaire) vers Timestamp PG<br />String PHP : '.$anniv.' ==> phpStr2tmstPg ==> Timestamp PG : '.$tmstPg.'<br />';
echo "Le format à l'entrée doit être : 15/06/1984 23:47:22<br />";
// $query = "insert into tab_dates values(".phpStr2tmst("15/06/1984").")";
// queryOne($conn, $query);

$tmstPhp = phpStr2tmstPhp($anniv);
echo '<br />Conversion String PHP (formulaire) vers Timestamp PHP<br />String PHP : '.$anniv.' ==> phpStr2tmstPhp ==> Timestamp PHP : '.$tmstPhp.'<br />';
echo "Le format à l'entrée doit être : 15/06/1984 23:47:22<br />";
echo ' echo date("d/m/Y H:i:s", "'.$tmstPhp.'") retourne bien '.date("d/m/Y H:i:s", $tmstPhp);

echo '<br />##########################################################<br />';

$test = new cDateStr('15/06/1984 15:05:03');
echo $test->toTmstPhp().'<br />';

$now = time();
$test2 = new cTmstPhp($now);
echo $test2->toTmstPg();
echo '<br />';
echo $test2->toStrPhp("d/m/Y H:i:s");

?>

