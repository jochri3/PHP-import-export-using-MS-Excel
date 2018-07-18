<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    // echo "<pre>";
    // print_r($_FILES);
    // print_r($_FILES['fichier_excel']['name']);
    // echo "</pre>";

//Connexion a la base des donnees
try
{
    $bdd=new PDO("mysql:host=localhost;dbname=test_excel","root","123456");
    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Connexion reussie<br><br>";
}catch(PDOException $e){
    echo "Erreur : #{$e->getMessage()}#";
}

//Fin de la chaine de connexion

require_once "./Classes/PHPExcel/IOFactory.php";
$html="<table border='1'>";
$html .="<tr>";
$html .="<th>Id</th>";
$html .="<th>Nom</th>";
$html .="<th>Prenom</th>";
$html .="<th>Promotion</th>";
$html .="<th>Pourcentage</th>";
$html .="<th>Mension</th>";
$html .="</tr>";
// $obj=PHPExcel_IOFactory::load('user.xlsx');
$obj=PHPExcel_IOFactory::load($_FILES['fichier_excel']['tmp_name']);
foreach($obj->getWorksheetIterator() as $worksheet){
    $highestRow=$worksheet->getHighestRow();
    for($row=2;$row<=$highestRow;$row++)
    {
        $html .="<tr>";
        // $numero=mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(0,$row)->getValue());
        $id=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(0,$row)->getValue()));
        $nom=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(1,$row)->getValue()));
        $prenom=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(2,$row)->getValue()));
        $promotion=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(3,$row)->getValue()));
        $pourc=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(4,$row)->getValue()));
        $mension=htmlspecialchars(trim($worksheet->getCellByColumnAndRow(5,$row)->getValue()));
        echo "<br>{$id} - {$nom} - {$prenom} - {$promotion} - {$pourc} - {$mension}<br>";
        $sql="UPDATE etudiants SET pourc=:pourc,mension=:mension WHERE id=:id";
        $rq=$bdd->prepare($sql);
        $rq->bindValue(":pourc",$pourc,PDO::PARAM_INT);
        $rq->bindValue(":mension",$mension,PDO::PARAM_STR);
        $rq->bindValue(":id",$id,PDO::PARAM_INT);
        $rq->execute();
        // echo $rq->errorsInfo();
        // $html .="<td>".$numero."</td>";
        $html .="<td>".$id."</td>";
        $html .="<td>".$nom."</td>";
        $html .="<td>".$prenom."</td>";
        $html .="<td>".$promotion."</td>";
        $html .="<td>".$pourc."</td>";
        $html .="<td>".$mension."</td>";
        $html .="</tr>";
    }
}
$html .="</table>";
echo $html;
echo "<br>Data inserted";
}

?>
<!doctype html>
<html>
<head></head>
<body>
    <form method="post" enctype="multipart/form-data" action="">
        Choisir votre fichier de la deliberation : <input type="file" name="fichier_excel"><br>
        <input type="submit" name="btn" value="enregistrer">
    </form>
</body>
</html>
