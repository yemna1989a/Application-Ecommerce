<?php
//mysql dans php
/*$cnx=mysqli_connect(,,);
mysqli_select_db();
mysqli_query($sql,$cnx);*/

//connexion a mysql avec PDO

try {
$cnx = new PDO('mysql:host=localhost;dbname=vente', 'root', '');
$cnx->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}
catch ( PDOException $e ) {
echo "Connection à MySQL impossible : ", $e->getMessage();
exit(); //ou die();
} ?>