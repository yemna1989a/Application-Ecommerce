function modifier(ind){
    var prix=parseFloat (document.getElementById('prix'+ind).innerHTML);
    var oldqte=parseFloat (document.getElementById('qte'+ind).innerHTML);
    document.getElementById('prix'+ind).innerHTML="<input style='width:70px;' type='number' min='1' value='"+prix+"' id='valprix"+ind+"'>";
    document.getElementById('qte'+ind).innerHTML="<input style='width:70px;' type='number' min='1' value='"+oldqte+"' id='valqte"+ind+"'>";
    
    document.getElementById('modifier'+ind).innerHTML='valider'; 
    document.getElementById('modifier'+ind).style.backgroundColor='green'; 
    document.getElementById('modifier'+ind).style.color='white'; 
    document.getElementById('modifier'+ind).setAttribute("onclick","validermodif("+ind+","+oldqte+")"); 
    
    }
    function validermodif(ind,oldqte){
        var prix=document.getElementById('valprix'+ind).value;
        var qte=document.getElementById('valqte'+ind).value;
        //verifier la qte doit etre >=1

        if(qte<1){
            alert('verifier la quantite');
            document.getElementById('valqte'+ind).value=oldqte;
        }else{
        $.ajax({
            type: "POST",
            url: "modifiervente.php",//cible du script coté serveur à appeler
            data:{ind:ind,prix:prix,qte:qte},//ce qu'on l'envoit au fonction
           beforeSend:function(){
    
           },
           
            success: function(data){//code à traiter si la modification est effectué avec succes
                console.log(data);
                obj=JSON.parse(data);
    document.getElementById('prix'+ind).innerHTML=obj.prix;//ecraser innerhtmletlavaleur change automatiquementsansfaire actualiser
    document.getElementById('qte'+ind).innerHTML=obj.qte;
    var oldtotal=(document.getElementById('total'+ind).innerHTML);
    
    document.getElementById('total'+ind).innerHTML=obj.qte*obj.prix; 
    
    var diff=oldtotal-(obj.qte*obj.prix);
    var oldnet=parseFloat(document.getElementById('net').innerHTML);
    document.getElementById('net').innerHTML=(oldnet-diff).toFixed(3);
    
    document.getElementById('modifier'+ind).innerHTML='modifier'; 
    document.getElementById('modifier'+ind).style.removeProperty('background-color'); 
    document.getElementById('modifier'+ind).style.color='black'; 
    document.getElementById('modifier'+ind).setAttribute("onclick","modifier("+ind+")"); 
    
    }
    
    });
}
    }
    
    function getprix(produit){
        $.ajax({
            type: "post",
            url: "getprix.php",
            data:{produit:produit},
            success: function(result){
                var res=JSON.parse(result);
                //var prix=parseFloat(result);
               // alert(res.prix);
        document.getElementById('prix').value=res.prix;
      }
    });
       } 
    