<?php
include('dbconexion.php'); 

header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=ISO-8859-1');

$data = json_decode(file_get_contents("php://input"));
$conexion = conectar(); //establece conexion con la base
$id_genero = $data->id_genero;//recibe el id genero del principal en formato json
$direccionMP3="mp3/";




$result = $conexion->query("SELECT b.id_cancion as 'id_cancion',titulo,duracion,nombre_artistico,direccion FROM artista_por_cancion a, cancion b,artista c WHERE (a.id_cancion=b.id_cancion) and (a.id_artista=c.id_artista) and (id_genero='$id_genero') ORDER BY nombre_artistico ASC"); //Consulta que recibe datos de las canciones por genero

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) { //Guarda en rs cada resultado de la fila 

    if ($outp != "") {$outp .= ",";}
    $rs["nombre_artistico"] = preg_replace("/[^a-zA-Z0-9_.'()]/", ' ', $rs["nombre_artistico"]);// Eliminacion de caracteres especiales 
    $rs["titulo"] = preg_replace("/[^a-zA-Z0-9_.'()]/", ' ', $rs["titulo"]);
    

    $outp .= '{"id_cancion":"'  . $rs["id_cancion"] . '",';
    $outp .= '"titulo":"'  . $rs["titulo"] . '",';
    $outp .= '"duracion":"'  .$rs["duracion"] . '",';
    $outp .= '"direccion":"'  . $direccionMP3. $rs["direccion"] . '",';
    $outp .= '"nombre_artistico":"'   . $rs["nombre_artistico"]    . '"}'; //Se convierte toda la data recibida en fila en formato json
}


$outp ='{"records":['.$outp.']}';//Todos los datos de la cancion se almacenan en records para su recibimiento en el javascript
echo $outp; //Muestra para el envio

$conexion->Close();
?>
