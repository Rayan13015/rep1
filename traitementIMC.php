<?php

$codes=array("rayan"=>"motdepasse1","nico"=>"motdepasse2","souf"=>"motdepasse3","reda"=>"motdepasse4","loan"=>"motdepasse5","lucas"=>"motdepasse6");

$mot_de_passe_utilisateur=$_POST['password'];
$acces_autorise=false;

foreach($codes as $cle => $valeur) {
    if ($mot_de_passe_utilisateur === $valeur){
        $acces_autorise = true;
        break;
    }
}
if($acces_autorise){
    echo "Bienvenue";
}else{
    echo "ACCES REFUSER";
}
?>








