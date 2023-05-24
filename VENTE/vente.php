<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script> 
</head>
<body>
    <?php 
    include "security.php";
    include "menu.php";
     ?>
    <div class ="container mt-5">
<?php
include "config.php";
?> 

<form method="post"action="">
    <div class ="row">
<div class="mb-3 col-sm-12 col-md-6 col-lg-5">
    <label for="produit" class="form-label">Produit</label>
<select class="form-control"onchange="getprix(this.value)" name="produit"id ="produit" required >
    <option value="">---choisir un produit---</option>
<?php
foreach($produits as $produit){
echo"<option value='".$produit['nom_produit']."'>".$produit['nom_produit']."</option>";
}
?>
</select>
</div>

<div class="mb-3 col-sm-6  col-lg-2">
<label for="qte" class="form-label">Quantite</label>
<input class="form-control"type="number" name="qte" min="1" id="qte" required value="1" >
</div>

<div class="mb-3 col-sm-6 col-lg-3">
<label for="prix" class="form-label">Prix</label>
<input  class="form-control" type="number" name="prix" onkeyup="if(this.value<0){alert('la valeur du prix est negative');this.value=' '}" id="prix" required >
</div>
<div class="col-sm-12 col-md-12 col-lg-2">
<label  class="form-label"> &nbsp;</label>
<button name="ajouter" class=" form-control btn btn-primary fs-5"><i class='bi bi-plus fs-4 lh-1'></i><span>ajouter</span></button>
</div>
</div> <!--fin row-->
</form>
<?php 
//session_destroy();
//sauvegarder la vente dans la base de données
if(isset($_GET['sauv'])){
    //selectionner le max num_commande
    $sqlmax="select max(num_commande) as max from commandes";
    $tab_max=$cnx->query($sqlmax)->fetch(PDO::FETCH_ASSOC);
   //print_r($tab_max);
   //exit;
    if($tab_max['max']>0){
    $num_max=$tab_max['max'];
    $num_commande=$num_max+1;
    }else{
        $num_commande=date("y")."00001";
    }
    $date=date("Y-m-d H:i:s");
    $id_client=1;

//calculer total commande
$vente=$_SESSION['panier'];
$total=0;
    foreach($_SESSION['panier'] as $indice=> $vente){ 
       $total+=$vente['qte']*$vente['prix'];
    }
    //créer une nouvelle commande
    $sql="insert into commandes(num_commande,date,id_client,totalcmd) values('$num_commande','$date','$id_client','$total')";
    $cnx->exec($sql);
    $id_commande = $cnx->lastInsertId();
    //inserrer les ligne de cette commande
    $vente=$_SESSION['panier'];
    foreach($_SESSION['panier'] as $indice=> $vente){ 
        $id_produit=$vente['id_produit'];
        $qte=$vente['qte'];
        $prix=$vente['prix'];
        $sqlligne="insert into lignecommandes(id_produit,id_commande,qte,prix) values('$id_produit','$id_commande','$qte','$prix')";
        $cnx->exec($sqlligne);
    }
header("location:vente.php?vider=1");
}

//Nouvelle vente
if(isset($_GET['vider'])){
   
    unset($_SESSION['panier']);
}
//initialisation de la session
if(!isset($_SESSION['panier']))
$_SESSION['panier']=array();

//supprimer une vente
if(isset($_POST['supprimer'])){
    $indice=$_POST['indice'];
    unset($_SESSION['panier'][$indice]);
}

//recupererlesinformations de vente apartir du formulaire
if(isset($_POST['ajouter'])){
    foreach($produits as $produit){
        if($produit['nom_produit']==$_POST['produit']){
            $id_produit=$produit['id_produit'];
            break;
        }
    }

    $produit=$_POST['produit'];
    $qte=$_POST['qte'];
    $prix=$_POST['prix'];
    $vente=array('id_produit'=>$id_produit,'produit'=>$produit,'prix'=>$prix,'qte'=>$qte);
    $_SESSION['panier'][]=$vente;
 
   //creer une redirection(apres Post) vers la meme page pour eliminier le submit du form
header('location:vente.php');
}

//print_r($_SESSION['panier']);
//commencer l'affichage du table html liste des ventes
echo"<h1>liste des ventes</h1>
<a href='vente.php?vider=1'><button class='btn btn-success mb-3'><i class='bi bi-cart-plus-fill fs-4 lh-1'></i></button></a>
<button onclick='window.print()' class='btn btn-primary mb-3'><i class='bi bi-printer-fill fs-4 lh-1 '> </i> </button>
<table border='1' width='600' class='table table-striped table-bordred'>
<thead>
<tr>
<th>Produit</th>
<th>Prix unitaire</th>
<th>Quantite</th>
<th>Prix total</th>
<th class='supp'>Actions</th>
</tr>
</thead>
<tbody>";
$total=0;
foreach($_SESSION['panier'] as $indice=> $vente){
    $total+=$vente['prix']*$vente['qte'];
    echo"<tr>
 <td>".$vente['produit']."</td>
 <td id='prix$indice'>".$vente['prix']."</td>
 <td id='qte$indice'>".$vente['qte']."</td>
 <td id='total$indice'>".$vente['prix']*$vente['qte']."</td>
 <td class='supp' nowrap>
    <form method='post' action=''>
    <button class='btn btn-success' type='button'  id='modifier$indice' onclick ='modifier($indice)'> Modifier </button>
    <input type='hidden' name='indice' value='$indice'>
    <button name='supprimer' class='btn btn-danger'> <i class='bi bi-trash'></i> </button></form> </td>

</tr>";
 }
 echo"</tbody>
<tr>
<th colspan=3>Net a payer</th>
<td id='net'>$total</td>
<td class='supp'></td>
</tr>

</table>";
?>
<a href='vente.php?sauv=1'>
    <button type='button' class='btn btn-primary'><i class='bi bi-file-earmark-plus-fill fs-4 lh-1'></i>sauvegarder la vente</button>
</a>

<script src="js/script.js"language="javascript"> </script>
</div>
</body>
</html>









