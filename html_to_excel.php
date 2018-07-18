<?php
//Test BD
try
{
    $bdd=new PDO("mysql:host=localhost;dbname=test_excel","root","123456");
}catch(Exception $e){
    echo "Erreur : #{$e->getMessage()}#";
}
//Debut de la requete
$sql="SELECT * FROM etudiants";
$rq=$bdd->query($sql);
$table="<table border='1'>".
"<thead><tr>".
"<th>Id</th>".
"<th>Nom</th>".
"<th>Prenom</th>".
"<th>Promotion</th>".
"<th>Pourcentage</th>".
"<th>Mension</th>".
"</tr></thead>".
"<tbody>";
        while($et=$rq->fetch()){ 
            $table .="<tr>".
            "<td>{$et['id']}</td>".
            "<td>{$et['nom']}</td>".
            "<td>{$et['prenom']}</td>".
            "<td>{$et['promotion']}</td>".
            "<td>{$et['pourc']}</td>".
            "<td>{$et['mension']}</td>".
            "</tr>";
        } 
$table .="</tbody></table>";
$fichier="delib.xls";
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachement;filename={$fichier}");
echo $table;
?>
