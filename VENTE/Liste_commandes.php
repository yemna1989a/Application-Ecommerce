<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes</title>
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



//print_r($_SESSION['panier']);
//commencer l'affichage du table html liste des ventes
echo"<h1>liste des ventes</h1>

<button onclick='window.print()' class='btn btn-primary mb-3'><i class='bi bi-printer-fill fs-4 lh-1 '> </i> </button>
<table border='1' width='600' class='table table-striped table-bordred'>
<thead>
<tr>
<th>Num commande</th>
<th>Date</th>
<th>Client</th>
<th>Total</th>
<th class='supp'>Actions</th>
</tr>
</thead>
<tbody>";


$sql="select * from commandes cmd,clients c where cmd.id_client=c.id_client ";
$commandes=$cnx->query($sql)->fetchAll(PDO::FETCH_OBJ);
$chiffre=0;
foreach($commandes as $commande){


 $chiffre+=$commande->totalcmd;
    echo"<tr>
 <td>".$commande->num_commande."</td>
 <td>".$commande->date."</td>
 <td>".$commande->nom_client."-".$commande->tel."</td>
 <td>".$commande->totalcmd."</td>
 

 <td><button name='supprimer' class='btn btn-danger'> <i class='bi bi-trash'></i> </button> </td>

</tr>";
 }
 echo"</tbody>
<tr>
<th colspan=3>chiffre d'affaire</th>
<td id='net'>$chiffre</td>
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









