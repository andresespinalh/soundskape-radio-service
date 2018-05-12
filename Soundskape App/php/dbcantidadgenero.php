<?php
include('dbconexion.php');
$conexion = conectar();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");




$result = $conexion->query("SELECT count(*) as 'cantidad', genero,b.id_genero  as 'id_genero' FROM cancion a,genero b where a.id_genero=b.id_genero GROUP by a.id_genero"); //Consulta que recibe la CANTIDAD de canciones por id genero

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {//Iteracion por fila de la consulta para su almacenamiento en la variable rs
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"cantidad":"'  . $rs["cantidad"] . '",';
    $outp .= '"genero":"'  . $rs["genero"] . '",';
    $outp .= '"id_genero":"'   . $rs["id_genero"]    . '"}';//Guarda todos los datos de la fila en formato json en la variable outp
}
$outp ='{"records":['.$outp.']}';
echo $outp; //muestra de los datos para su envio
$conexion->Close();
?>