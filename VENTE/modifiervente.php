<?php session_start();
if(!empty($_POST)){
    $ind=$_POST['ind'];
    $prix=$_POST['prix'];
    $qte=$_POST['qte'];
    //modifier la  qte et le prix de la vente
    $_SESSION['panier'][$ind]['qte']=$qte;
    $_SESSION['panier'][$ind]['prix']=$prix;
    $tab=array("qte"=>$qte,"prix"=>$prix);
    echo json_encode($tab);
   
}else 
exit;
?>