<?php

//Test Scripts PHP
$age=13;

if($age>=18):
    echo "Vous avez {$age} ans Majeur<br><br>";
else:
    echo "Vous avez {$age} ans et vous etes Mineur<br><br>";
endif;

//Test BD

try
{
    $bdd=new PDO("mysql:host=localhost;dbname=test_excel","root","123456");
    echo "Connexion reussie<br><br>";
}catch(Exception $e){
    echo "Erreur : #{$e->getMessage()}#";
}

//Debut de la requete
$sql="SELECT * FROM etudiants";
$rq=$bdd->query($sql);
// var_dump($rq);

?>
<! doctype html>
<html>
<head>
    <title>Liste des etudiants</title>
    <meta charset='utf-8' />
</head>
<body>
    <div>
       <table border="1">
        <tr><td>Id</td><td>Nom</td><td>Prenom</td><td>Promotion</td><td>Pourcentage</td><td>Mension</td></tr>
        <?php while($et=$rq->fetch()){ ?>
            <tr><td><?= $et['id'] ?></td><td><?= $et['nom'] ?></td><td><?= $et['prenom'] ?></td><td><?= $et['promotion'] ?></td><td><?= $et['pourc'] ?></td><td><?= $et['mension'] ?></td></tr>
        <?php } ?>
       </table>
    </div>
</body>
</html>