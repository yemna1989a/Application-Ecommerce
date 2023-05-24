<?php

/*$tab_prod=array(array('produit'=>'ecran','prix'=>250),array('produit'=>'clavier','prix'=>25),
array('produit'=>'pc portable asus','prix'=>1250),array('produit'=>'souris','prix'=>15),
array('produit'=>'imprimente epson 3en1','prix'=>350));*/


//connexion à la base de données
include "connexion.php";
$sql="select * from produits";
$produits=$cnx->query($sql)->fetchAll(PDO::FETCH_ASSOC);
/*echo "<pre>";
print_r($produits); exit;
"</pre>";*/


?>