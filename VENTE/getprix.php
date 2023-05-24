<?php
include "config.php";
foreach($produits as $produit){
    if($produit['nom_produit']==$_POST['produit']){
        $prix=$produit['prix'];
        break;
    }
}
$res=["prix"=>$prix];
echo json_encode($res);
//echo $prix;
?>